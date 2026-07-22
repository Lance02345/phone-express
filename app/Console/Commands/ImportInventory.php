<?php

namespace App\Console\Commands;

use App\Services\Inventory\CsvInventoryImporter;
use Illuminate\Console\Command;

class ImportInventory extends Command
{
    protected $signature = 'inventory:import {file : Path to the inventory CSV} {--dry-run : Validate without writing} {--source=csv : Source identifier}';

    protected $description = 'Validate and import inventory by product SKU and location';

    public function handle(CsvInventoryImporter $importer): int
    {
        try {
            $report = $importer->run(
                $this->argument('file'),
                (bool) $this->option('dry-run'),
                (string) $this->option('source')
            );
        } catch (\InvalidArgumentException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->table(['Measure', 'Count'], [
            ['Rows', $report['rows']],
            ['Valid', $report['valid']],
            ['Errors', count($report['errors'])],
        ]);

        foreach ($report['errors'] as $error) {
            $this->error($error);
        }

        if ($report['errors'] !== []) {
            $this->warn('Nothing was imported. Fix the errors and run the command again.');

            return self::FAILURE;
        }

        $this->info($report['dry_run'] ? 'Inventory dry run passed.' : 'Inventory imported successfully.');

        return self::SUCCESS;
    }
}
