<?php

namespace App\Services\Inventory;

use App\Models\InventoryLevel;
use App\Models\Location;
use App\Models\ProductVariant;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SplFileObject;

class CsvInventoryImporter
{
    private const REQUIRED_HEADERS = [
        'sku', 'location_code', 'location_name', 'tracking_mode', 'status',
        'quantity_on_hand', 'quantity_reserved', 'observed_at',
    ];

    /**
     * @return array{dry_run: bool, rows: int, valid: int, errors: array<int, string>, records: array<int, array<string, mixed>>}
     */
    public function run(string $path, bool $dryRun = true, string $source = 'csv'): array
    {
        $records = $this->read($path);
        $errors = [];
        $validated = [];
        $seen = [];

        foreach ($records as $index => $record) {
            $line = $index + 2;
            $result = $this->validate($record, $line);
            $errors = [...$errors, ...$result['errors']];

            if ($result['record'] === null) {
                continue;
            }

            $key = $result['record']['sku'].'|'.$result['record']['location_code'];
            if (isset($seen[$key])) {
                $errors[] = "Line {$line}: duplicate SKU and location combination";

                continue;
            }

            $seen[$key] = true;
            $validated[] = $result['record'];
        }

        $report = [
            'dry_run' => $dryRun,
            'rows' => count($records),
            'valid' => count($validated),
            'errors' => $errors,
            'records' => $validated,
        ];

        if ($dryRun || $errors !== []) {
            return $report;
        }

        DB::transaction(function () use ($validated, $source): void {
            foreach ($validated as $record) {
                $location = Location::updateOrCreate(
                    ['code' => $record['location_code']],
                    ['name' => $record['location_name'], 'is_active' => true]
                );

                InventoryLevel::updateOrCreate(
                    ['product_variant_id' => $record['variant_id'], 'location_id' => $location->id],
                    [
                        'tracking_mode' => $record['tracking_mode'],
                        'status' => $record['status'],
                        'quantity_on_hand' => $record['quantity_on_hand'],
                        'quantity_reserved' => $record['quantity_reserved'],
                        'source' => Str::limit($source, 40, ''),
                        'source_key' => $record['sku'].':'.$record['location_code'],
                        'observed_at' => $record['observed_at'],
                    ]
                );
            }
        });

        return $report;
    }

    /** @return array<int, array<string, string|null>> */
    private function read(string $path): array
    {
        $resolvedPath = realpath($path);
        if ($resolvedPath === false || ! is_readable($resolvedPath)) {
            throw new \InvalidArgumentException("Inventory file is not readable: {$path}");
        }

        $file = new SplFileObject($resolvedPath);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
        $headers = $file->fgetcsv();

        if ($headers === false || array_diff(self::REQUIRED_HEADERS, $headers) !== []) {
            throw new \InvalidArgumentException('Inventory CSV headers must be: '.implode(', ', self::REQUIRED_HEADERS));
        }

        $records = [];
        while (! $file->eof()) {
            $row = $file->fgetcsv();
            if ($row === false || $row === [null]) {
                continue;
            }

            $row = array_pad($row, count($headers), null);
            $records[] = array_combine($headers, array_slice($row, 0, count($headers)));
        }

        return $records;
    }

    /**
     * @param  array<string, string|null>  $record
     * @return array{record: array<string, mixed>|null, errors: array<int, string>}
     */
    private function validate(array $record, int $line): array
    {
        $errors = [];
        $sku = trim((string) $record['sku']);
        $variant = ProductVariant::where('sku', $sku)->first();
        $locationCode = Str::upper(trim((string) $record['location_code']));
        $locationName = trim((string) $record['location_name']);
        $mode = trim((string) $record['tracking_mode']);
        $status = trim((string) $record['status']);

        if ($variant === null) {
            $errors[] = "Line {$line}: unknown SKU {$sku}";
        }
        if ($locationCode === '' || $locationName === '') {
            $errors[] = "Line {$line}: location code and name are required";
        }
        if (! in_array($mode, ['unknown', 'coarse', 'exact'], true)) {
            $errors[] = "Line {$line}: invalid tracking mode";
        }
        if (! in_array($status, ['unknown', 'available', 'limited', 'out_of_stock'], true)) {
            $errors[] = "Line {$line}: invalid stock status";
        }

        $onHand = $this->integerOrNull($record['quantity_on_hand']);
        $reserved = $this->integerOrNull($record['quantity_reserved']);
        if ($mode === 'exact' && ($onHand === null || $reserved === null || $reserved > $onHand)) {
            $errors[] = "Line {$line}: exact tracking requires valid on-hand and reserved quantities";
        }
        if ($mode !== 'exact') {
            $onHand = $reserved = null;
        }

        try {
            $observedAt = CarbonImmutable::parse((string) $record['observed_at']);
        } catch (\Throwable) {
            $errors[] = "Line {$line}: observed_at must be a valid date and time";
            $observedAt = null;
        }

        return [
            'record' => $errors === [] ? [
                'variant_id' => $variant->id,
                'sku' => $sku,
                'location_code' => $locationCode,
                'location_name' => $locationName,
                'tracking_mode' => $mode,
                'status' => $status,
                'quantity_on_hand' => $onHand,
                'quantity_reserved' => $reserved,
                'observed_at' => $observedAt,
            ] : null,
            'errors' => $errors,
        ];
    }

    private function integerOrNull(?string $value): ?int
    {
        $value = trim((string) $value);

        return $value !== '' && ctype_digit($value) ? (int) $value : null;
    }
}
