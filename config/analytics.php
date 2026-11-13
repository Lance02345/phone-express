<?php

return [
    // Reports are bucketed by the shop's local day/hour, not UTC.
    'timezone' => env('ANALYTICS_TIMEZONE', 'Africa/Nairobi'),

    // Raw page views/events older than this are deleted by `php artisan analytics:prune`.
    'retention_days' => (int) env('ANALYTICS_RETENTION_DAYS', 395),

    // A visit ends after this many minutes without a page view.
    'session_minutes' => 30,

    'visitor_cookie' => 'dd_vid',
    'session_cookie' => 'dd_sid',

    // Paths (no leading slash) that are never recorded.
    'excluded_prefixes' => ['staff', 'api', 'a/', 'build', 'Images', 'storage', 'livewire', '_ignition'],
];
