<?php

namespace Database\Seeders;

use App\Services\Catalogue\LegacyCatalogueImporter;
use Illuminate\Database\Seeder;

class CatalogueSeeder extends Seeder
{
    public function run(LegacyCatalogueImporter $importer): void
    {
        $report = $importer->run(false);

        $this->command?->info(sprintf(
            'Normalized catalogue ready: %d products and %d phone variants.',
            $report['persisted']['products'],
            $report['persisted']['variants'],
        ));
    }
}
