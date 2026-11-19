<?php

namespace Database\Seeders;

use App\Services\Catalogue\LegacyCatalogueImporter;
use Illuminate\Database\Seeder;

class CatalogueSeeder extends Seeder
{
    public function run(LegacyCatalogueImporter $importer): void
    {
        // On a full `db:seed`, phones no longer listed in any seeder are hidden (not deleted). Run on its own,
        // no seeder has recorded names, so visibility is left as it is.
        $report = $importer->run(false, SeededPhones::names() ?: null);

        $this->command?->info(sprintf(
            'Normalized catalogue ready: %d products and %d phone variants (%d no longer listed, hidden).',
            $report['persisted']['products'],
            $report['persisted']['variants'],
            $report['retired'],
        ));
    }
}
