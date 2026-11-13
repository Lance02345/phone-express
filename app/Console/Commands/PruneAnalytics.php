<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneAnalytics extends Command
{
    protected $signature = 'analytics:prune {--days= : Keep this many days (default: config analytics.retention_days)}';

    protected $description = 'Delete raw analytics page views and events older than the retention window';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?: config('analytics.retention_days'));
        $cutoff = now(config('analytics.timezone'))->subDays($days)->toDateString();

        $events = DB::table('analytics_events')->where('local_date', '<', $cutoff)->delete();
        $views = DB::table('analytics_page_views')->where('local_date', '<', $cutoff)->delete();

        $this->info("Deleted {$views} page views and {$events} events before {$cutoff}.");

        return self::SUCCESS;
    }
}
