<?php

namespace App\Console\Commands;

use App\Models\Phone;
use App\Services\Catalogue\LegacyPhoneMapper;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class FetchCatalogueImages extends Command
{
    protected $signature = 'catalogue:fetch-images
        {--dry-run : List the missing images and search queries without downloading}
        {--force : Re-download images that already exist}
        {--only= : Only handle image paths or product names containing this text}
        {--limit= : Stop after this many images}';

    protected $description = 'Download missing product images referenced by the seeders';

    private const SOURCES_FILE = 'database/data/image-sources.json';

    private const MAX_SIDE = 1000;

    private const MIN_SIDE = 300;

    // Skip huge originals rather than exhaust memory decoding them.
    private const MAX_PIXELS = 40_000_000;

    public function handle(LegacyPhoneMapper $mapper): int
    {
        $sources = $this->loadSources();
        $targets = $this->targets($mapper);

        if ($targets->isEmpty()) {
            $this->info('No missing images.');

            return self::SUCCESS;
        }

        $canSearch = $this->hasSearchProvider();

        if (! $this->option('dry-run') && ! $canSearch && $targets->keys()->diff(array_keys($sources))->isNotEmpty()) {
            $this->warn('No image search API configured (GOOGLE_CSE_KEY + GOOGLE_CSE_CX or BRAVE_SEARCH_KEY), so only images with a URL in '.self::SOURCES_FILE.' will be downloaded.');
        }

        $saved = 0;
        $failed = [];

        foreach ($targets as $path => $query) {
            if ($this->option('dry-run')) {
                $this->line(sprintf('%-45s %s%s', $path, $query, isset($sources[$path]) ? '  [source set]' : ''));

                continue;
            }

            if (! isset($sources[$path]) && ! $canSearch) {
                $failed[] = $path;

                continue;
            }

            $this->line("<comment>{$path}</comment> ← {$query}");

            $candidates = isset($sources[$path]) ? [$sources[$path]] : $this->search($query);
            $url = $this->downloadFirst($candidates, $path);

            if ($url === null) {
                $failed[] = $path;
                $this->warn('  no usable image found');

                continue;
            }

            $sources[$path] = $url;
            $this->saveSources($sources);
            $saved++;
            $this->info("  saved from {$url}");
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->info($targets->count().' image(s) missing.');

            return self::SUCCESS;
        }

        $this->newLine();
        $this->info("{$saved} image(s) saved. Sources recorded in ".self::SOURCES_FILE.'.');

        if ($failed !== []) {
            $this->warn(count($failed).' image(s) still missing — add a direct URL for each to '.self::SOURCES_FILE.' and re-run:');
            foreach ($failed as $path) {
                $this->line("  {$path}");
            }
        }

        return $failed === [] ? self::SUCCESS : self::FAILURE;
    }

    /**
     * Image paths referenced by the seeders that need downloading, keyed by path, with a search query as value.
     *
     * @return Collection<string, string>
     */
    private function targets(LegacyPhoneMapper $mapper): Collection
    {
        $only = Str::lower((string) $this->option('only'));
        $targets = collect();

        foreach (File::glob(database_path('seeders/*Seeder.php')) as $file) {
            preg_match_all(
                '/"name"\s*=>\s*"((?:[^"\\\\]|\\\\.)*)".*?"image_path"\s*=>\s*"([^"]+)"/',
                File::get($file),
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as [, $name, $path]) {
                $name = stripslashes($name);

                if ($targets->has($path) || (! $this->option('force') && is_file(public_path($path)))) {
                    continue;
                }

                if ($only !== '' && ! Str::contains(Str::lower($path.' '.$name), $only)) {
                    continue;
                }

                $targets->put($path, $this->query($mapper, $name));
            }
        }

        $limit = (int) $this->option('limit');

        return $limit > 0 ? $targets->take($limit) : $targets;
    }

    private function query(LegacyPhoneMapper $mapper, string $name): string
    {
        $mapped = $mapper->map(new Phone(['name' => $name, 'price' => 0, 'image_path' => null]));
        $query = $mapped['product_name'];

        // Drop notes such as "(2 Years Warranty)" that would only confuse the search.
        $query = trim((string) preg_replace('/\s*\([^)]*\)\s*$/', '', $query));

        if ($mapped['colour'] !== null) {
            $query .= ' '.$mapped['colour'];
        }

        return $query.' official product image';
    }

    private function hasSearchProvider(): bool
    {
        return filled(config('services.image_search.brave_key'))
            || (filled(config('services.image_search.google_key')) && filled(config('services.image_search.google_cx')));
    }

    /**
     * @return array<int, string>
     */
    private function search(string $query): array
    {
        try {
            if (filled(config('services.image_search.brave_key'))) {
                return Http::timeout(20)
                    ->withHeaders(['X-Subscription-Token' => config('services.image_search.brave_key')])
                    ->get('https://api.search.brave.com/res/v1/images/search', ['q' => $query, 'count' => 20, 'safesearch' => 'strict'])
                    ->throw()
                    ->collect('results')
                    ->pluck('properties.url')
                    ->filter()
                    ->values()
                    ->all();
            }

            return Http::timeout(20)
                ->get('https://www.googleapis.com/customsearch/v1', [
                    'key' => config('services.image_search.google_key'),
                    'cx' => config('services.image_search.google_cx'),
                    'q' => $query,
                    'searchType' => 'image',
                    'imgSize' => 'large',
                    'num' => 10,
                    'safe' => 'active',
                ])
                ->throw()
                ->collect('items')
                ->pluck('link')
                ->filter()
                ->values()
                ->all();
        } catch (Throwable $e) {
            $this->warn('  search failed: '.Str::limit($e->getMessage(), 200));

            return [];
        }
    }

    /**
     * @param  array<int, string>  $candidates
     */
    private function downloadFirst(array $candidates, string $path): ?string
    {
        foreach ($candidates as $url) {
            try {
                $response = Http::timeout(20)
                    ->withUserAgent('Mozilla/5.0 (compatible; PhoneDistrictCatalogue/1.0)')
                    ->get($url);
            } catch (Throwable) {
                continue;
            }

            if ($response->successful() && $this->store($response->body(), $path)) {
                return $url;
            }
        }

        return null;
    }

    /**
     * Resize, flatten onto white where needed, and write the image in the format its path asks for.
     */
    private function store(string $bytes, string $path): bool
    {
        $size = @getimagesizefromstring($bytes);
        if ($size === false || min($size[0], $size[1]) < self::MIN_SIDE || $size[0] * $size[1] > self::MAX_PIXELS) {
            return false;
        }

        $source = @imagecreatefromstring($bytes);
        if ($source === false) {
            return false;
        }

        [$width, $height] = [imagesx($source), imagesy($source)];
        $scale = min(1, self::MAX_SIDE / max($width, $height));
        [$newWidth, $newHeight] = [(int) round($width * $scale), (int) round($height * $scale)];

        $extension = Str::lower(pathinfo($path, PATHINFO_EXTENSION));
        $image = imagecreatetruecolor($newWidth, $newHeight);

        if (in_array($extension, ['png', 'webp'], true)) {
            imagealphablending($image, false);
            imagesavealpha($image, true);
            imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        } else {
            imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
        }

        imagecopyresampled($image, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $target = public_path($path);
        File::ensureDirectoryExists(dirname($target));

        $written = match ($extension) {
            'png' => imagepng($image, $target, 8),
            'webp' => imagewebp($image, $target, 85),
            default => imagejpeg($image, $target, 85),
        };

        imagedestroy($source);
        imagedestroy($image);

        return $written;
    }

    /**
     * @return array<string, string>
     */
    private function loadSources(): array
    {
        $file = base_path(self::SOURCES_FILE);

        return is_file($file) ? (json_decode(File::get($file), true) ?: []) : [];
    }

    /**
     * @param  array<string, string>  $sources
     */
    private function saveSources(array $sources): void
    {
        ksort($sources);
        File::ensureDirectoryExists(dirname(base_path(self::SOURCES_FILE)));
        File::put(base_path(self::SOURCES_FILE), json_encode($sources, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");
    }
}
