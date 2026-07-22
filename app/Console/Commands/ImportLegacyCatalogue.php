<?php

namespace App\Console\Commands;

use App\Services\Catalogue\LegacyCatalogueImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ImportLegacyCatalogue extends Command
{
    protected $signature = 'catalogue:import-legacy {--dry-run : Analyse without writing normalized catalogue records}';

    protected $description = 'Import legacy phones into the normalized product catalogue';

    public function handle(LegacyCatalogueImporter $importer): int
    {
        $dryRun = (bool) $this->option('dry-run');

        if (! $dryRun && ! Schema::hasTable('product_variants')) {
            $this->error('Catalogue tables do not exist. Run php artisan migrate first.');

            return self::FAILURE;
        }

        $report = $importer->run($dryRun);

        $this->info($dryRun ? 'Legacy catalogue dry run complete.' : 'Legacy catalogue import complete.');
        $this->table(
            ['Measure', 'Count'],
            [
                ['Legacy phones', $report['legacy_phones']],
                ['Normalized products', $report['products']],
                ['Product variants', $report['variants']],
                ['Quote required', $report['quote_required']],
                ['Missing images', $report['missing_images']],
                ['Records with warnings', count($report['warnings'])],
            ]
        );

        if ($report['warnings'] !== []) {
            $this->newLine();
            $this->warn('Review warnings:');
            foreach ($report['warnings'] as $warning) {
                $this->line(sprintf(
                    '#%d %s — %s',
                    $warning['legacy_phone_id'],
                    $warning['name'],
                    implode('; ', $warning['messages'])
                ));
            }
        }

        if (! $dryRun) {
            $this->newLine();
            $this->table(
                ['Persisted', 'Count'],
                collect($report['persisted'])->map(fn ($count, $name) => [$name, $count])->values()->all()
            );
        }

        return self::SUCCESS;
    }
}
