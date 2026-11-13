<?php

namespace App\Http\Controllers;

use App\Services\Analytics\SiteAnalytics;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffAnalyticsController extends Controller
{
    public const PRESETS = ['today' => 'Today', '7d' => '7 days', '30d' => '30 days', '90d' => '90 days', '365d' => '12 months'];

    public function index(Request $request): View
    {
        $today = CarbonImmutable::now(config('analytics.timezone'))->startOfDay();
        $range = $request->string('range')->toString();

        if ($request->filled(['from', 'to'])) {
            $validated = $request->validate([
                'from' => ['date_format:Y-m-d', 'before_or_equal:to'],
                'to' => ['date_format:Y-m-d', 'before_or_equal:'.$today->toDateString()],
            ]);
            $from = CarbonImmutable::parse($validated['from']);
            $to = CarbonImmutable::parse($validated['to']);
            $range = 'custom';
        } else {
            $range = array_key_exists($range, self::PRESETS) ? $range : '30d';
            $days = $range === 'today' ? 1 : (int) $range;
            $to = $today;
            $from = $today->subDays($days - 1);
        }

        // Keep the heaviest queries bounded on shared hosting.
        if ($from->diffInDays($to) > 400) {
            $from = $to->subDays(400);
        }

        $report = SiteAnalytics::forRange($from, $to);

        return view('staff.analytics', [
            'range' => $range,
            'presets' => self::PRESETS,
            'from' => $report->from(),
            'to' => $report->to(),
            'summary' => $report->summary(),
            'previous' => $report->previous()->summary(),
            'daily' => $report->daily(),
            'heatmap' => $report->weekHourHeatmap(),
            'topPages' => $report->topPages(),
            'entryPages' => $report->entryPages(),
            'exitPages' => $report->exitPages(),
            'topProducts' => $report->topProducts(),
            'brandInterest' => $report->brandInterest(),
            'sources' => $report->breakdown('source'),
            'referrers' => $report->breakdown('referrer_host', 10),
            'devices' => $report->breakdown('device'),
            'browsers' => $report->breakdown('browser'),
            'systems' => $report->breakdown('os'),
            'countries' => $report->breakdown('country'),
            'campaigns' => $report->campaigns(),
            'searches' => $report->searches(),
            'filters' => $report->filters(),
            'events' => $report->eventsBreakdown(),
            'live' => SiteAnalytics::live(),
            'journeys' => SiteAnalytics::recentJourneys(),
        ]);
    }
}
