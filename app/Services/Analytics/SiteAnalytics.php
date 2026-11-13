<?php

namespace App\Services\Analytics;

use App\Models\ProductVariant;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Read-side queries for the staff analytics page. Every query is plain SQL that
 * runs on both PostgreSQL (local) and MySQL/MariaDB (typical shared hosting):
 * day/hour buckets are stored at write time in the shop's timezone.
 */
class SiteAnalytics
{
    public function __construct(
        private readonly CarbonImmutable $from,
        private readonly CarbonImmutable $to,
    ) {
    }

    public static function forRange(CarbonImmutable $from, CarbonImmutable $to): self
    {
        return new self($from->startOfDay(), $to->startOfDay());
    }

    public function previous(): self
    {
        $days = $this->days();

        return new self($this->from->subDays($days), $this->from->subDay());
    }

    public function days(): int
    {
        return (int) $this->from->diffInDays($this->to) + 1;
    }

    public function from(): CarbonImmutable
    {
        return $this->from;
    }

    public function to(): CarbonImmutable
    {
        return $this->to;
    }

    private function views(): Builder
    {
        return DB::table('analytics_page_views')->whereBetween('local_date', [$this->from->toDateString(), $this->to->toDateString()]);
    }

    private function entries(): Builder
    {
        return $this->views()->where('is_entry', true);
    }

    private function events(): Builder
    {
        return DB::table('analytics_events')->whereBetween('local_date', [$this->from->toDateString(), $this->to->toDateString()]);
    }

    /** @return array<string, float|int> */
    public function summary(): array
    {
        $pageViews = $this->views()->count();
        $visitors = $this->views()->distinct()->count('visitor_id');
        $sessions = $this->views()->distinct()->count('session_id');
        $newVisitors = $this->views()->where('is_new_visitor', true)->distinct()->count('visitor_id');

        $bounces = 0;
        $durationTotal = 0;
        $this->views()
            ->select('session_id', DB::raw('count(*) as views'), DB::raw('min(created_at) as started'), DB::raw('max(created_at) as ended'))
            ->groupBy('session_id')
            ->orderBy('session_id')
            ->lazy(2000)
            ->each(function ($row) use (&$bounces, &$durationTotal) {
                if ((int) $row->views === 1) {
                    $bounces++;
                }
                $durationTotal += max(0, strtotime((string) $row->ended) - strtotime((string) $row->started));
            });

        $sessionsWithWhatsapp = $this->events()->where('name', 'whatsapp_click')->distinct()->count('session_id');
        $sessionsWithAnyContact = $this->events()->whereIn('name', ['whatsapp_click', 'call_click', 'email_click'])->distinct()->count('session_id');

        return [
            'page_views' => $pageViews,
            'visitors' => $visitors,
            'new_visitors' => $newVisitors,
            'returning_visitors' => max(0, $visitors - $newVisitors),
            'sessions' => $sessions,
            'pages_per_session' => $sessions ? round($pageViews / $sessions, 2) : 0,
            'bounce_rate' => $sessions ? round($bounces / $sessions * 100, 1) : 0,
            'avg_duration' => $sessions ? (int) round($durationTotal / $sessions) : 0,
            'product_views' => $this->views()->whereNotNull('product_variant_id')->count(),
            'searches' => $this->views()->whereNotNull('search_term')->count(),
            'whatsapp_clicks' => $this->events()->where('name', 'whatsapp_click')->count(),
            'call_clicks' => $this->events()->where('name', 'call_click')->count(),
            'email_clicks' => $this->events()->where('name', 'email_click')->count(),
            'conversion_rate' => $sessions ? round($sessionsWithWhatsapp / $sessions * 100, 1) : 0,
            'contact_rate' => $sessions ? round($sessionsWithAnyContact / $sessions * 100, 1) : 0,
        ];
    }

    /** @return Collection<int, array{date: string, views: int, visitors: int, whatsapp: int}> */
    public function daily(): Collection
    {
        $views = $this->views()
            ->select('local_date', DB::raw('count(*) as views'), DB::raw('count(distinct visitor_id) as visitors'))
            ->groupBy('local_date')->get()->keyBy(fn ($row) => substr((string) $row->local_date, 0, 10));
        $whatsapp = $this->events()->where('name', 'whatsapp_click')
            ->select('local_date', DB::raw('count(*) as total'))
            ->groupBy('local_date')->pluck('total', 'local_date')->mapWithKeys(fn ($v, $k) => [substr((string) $k, 0, 10) => (int) $v]);

        return collect(CarbonPeriod::create($this->from, $this->to))->map(function ($day) use ($views, $whatsapp) {
            $key = $day->toDateString();

            return [
                'date' => $key,
                'views' => (int) ($views[$key]->views ?? 0),
                'visitors' => (int) ($views[$key]->visitors ?? 0),
                'whatsapp' => $whatsapp[$key] ?? 0,
            ];
        })->values();
    }

    /** @return array<int, array<int, int>> weekday (1=Mon..7=Sun) => hour => views */
    public function weekHourHeatmap(): array
    {
        $grid = array_fill(1, 7, array_fill(0, 24, 0));

        $this->views()
            ->select('local_date', 'local_hour', DB::raw('count(*) as total'))
            ->groupBy('local_date', 'local_hour')->get()
            ->each(function ($row) use (&$grid) {
                $weekday = CarbonImmutable::parse(substr((string) $row->local_date, 0, 10))->dayOfWeekIso;
                $grid[$weekday][(int) $row->local_hour] += (int) $row->total;
            });

        return $grid;
    }

    public function topPages(int $limit = 12): Collection
    {
        return $this->views()
            ->select('path', DB::raw('count(*) as views'), DB::raw('count(distinct visitor_id) as visitors'))
            ->groupBy('path')->orderByDesc('views')->limit($limit)->get();
    }

    public function entryPages(int $limit = 8): Collection
    {
        return $this->entries()
            ->select('path', DB::raw('count(*) as sessions'))
            ->groupBy('path')->orderByDesc('sessions')->limit($limit)->get();
    }

    public function exitPages(int $limit = 8): Collection
    {
        $lastViewIds = $this->views()->select(DB::raw('max(id)'))->groupBy('session_id');

        return DB::table('analytics_page_views')
            ->whereIn('id', $lastViewIds)
            ->select('path', DB::raw('count(*) as sessions'))
            ->groupBy('path')->orderByDesc('sessions')->limit($limit)->get();
    }

    /** Products by views, with WhatsApp enquiries and the view→enquiry rate. */
    public function topProducts(int $limit = 12): Collection
    {
        $rows = $this->views()->whereNotNull('product_variant_id')
            ->select('product_variant_id', DB::raw('count(*) as views'), DB::raw('count(distinct visitor_id) as visitors'))
            ->groupBy('product_variant_id')->orderByDesc('views')->limit($limit)->get();

        $enquiries = $this->events()->where('name', 'whatsapp_click')->whereIn('product_variant_id', $rows->pluck('product_variant_id'))
            ->select('product_variant_id', DB::raw('count(*) as total'))
            ->groupBy('product_variant_id')->pluck('total', 'product_variant_id');

        $variants = ProductVariant::query()->with('product.brand')->whereKey($rows->pluck('product_variant_id'))->get()->keyBy('id');

        return $rows->map(function ($row) use ($enquiries, $variants) {
            $whatsapp = (int) ($enquiries[$row->product_variant_id] ?? 0);

            return (object) [
                'variant' => $variants[$row->product_variant_id] ?? null,
                'views' => (int) $row->views,
                'visitors' => (int) $row->visitors,
                'whatsapp' => $whatsapp,
                'rate' => $row->visitors ? round($whatsapp / $row->visitors * 100, 1) : 0,
            ];
        })->filter(fn ($row) => $row->variant !== null)->values();
    }

    public function brandInterest(): Collection
    {
        return $this->views()
            ->join('product_variants', 'product_variants.id', '=', 'analytics_page_views.product_variant_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('brands.name', DB::raw('count(*) as views'))
            ->groupBy('brands.name')->orderByDesc('views')->get();
    }

    /** Counted per visit (entry view), so long visits don't skew the split. */
    public function breakdown(string $column, int $limit = 8): Collection
    {
        abort_unless(in_array($column, ['source', 'device', 'browser', 'os', 'country', 'referrer_host'], true), 500);

        return $this->entries()->whereNotNull($column)
            ->select($column.' as label', DB::raw('count(*) as sessions'))
            ->groupBy($column)->orderByDesc('sessions')->limit($limit)->get();
    }

    public function campaigns(int $limit = 10): Collection
    {
        return $this->entries()->whereNotNull('utm_source')
            ->select('utm_source', 'utm_medium', 'utm_campaign', DB::raw('count(*) as sessions'))
            ->groupBy('utm_source', 'utm_medium', 'utm_campaign')->orderByDesc('sessions')->limit($limit)->get();
    }

    public function searches(int $limit = 15): Collection
    {
        return $this->views()->whereNotNull('search_term')
            ->select('search_term', DB::raw('count(*) as searches'), DB::raw('count(distinct visitor_id) as visitors'))
            ->groupBy('search_term')->orderByDesc('searches')->limit($limit)->get();
    }

    /** Filters customers apply on the shop page (brand, category, price, storage). */
    public function filters(int $limit = 12): Collection
    {
        $counts = [];

        $this->views()->where('route_name', 'pricing')->whereNotNull('query')
            ->select('query', DB::raw('count(*) as total'))->groupBy('query')->get()
            ->each(function ($row) use (&$counts) {
                parse_str((string) $row->query, $params);
                foreach (['brand', 'category', 'price_range', 'storage', 'sort'] as $key) {
                    if (filled($params[$key] ?? null) && is_scalar($params[$key])) {
                        $label = str($key)->replace('_', ' ')->title().': '.$params[$key];
                        $counts[$label] = ($counts[$label] ?? 0) + (int) $row->total;
                    }
                }
            });

        arsort($counts);

        return collect(array_slice($counts, 0, $limit, true))->map(fn ($total, $label) => (object) compact('label', 'total'))->values();
    }

    public function eventsBreakdown(): Collection
    {
        return $this->events()
            ->select('name', 'label', DB::raw('count(*) as total'))
            ->groupBy('name', 'label')->orderByDesc('total')->limit(12)->get();
    }

    /** @return array{visitors: int, pages: Collection} */
    public static function live(int $minutes = 5): array
    {
        $since = now()->subMinutes($minutes);
        $recent = DB::table('analytics_page_views')->where('created_at', '>=', $since);

        return [
            'visitors' => (clone $recent)->distinct()->count('visitor_id'),
            'pages' => (clone $recent)->select('path', DB::raw('count(distinct visitor_id) as visitors'))
                ->groupBy('path')->orderByDesc('visitors')->limit(6)->get(),
        ];
    }

    /** The most recent visits with the pages they went through, in order. */
    public static function recentJourneys(int $limit = 12): Collection
    {
        $sessionIds = DB::table('analytics_page_views')
            ->select('session_id', DB::raw('max(id) as last_id'))
            ->groupBy('session_id')->orderByDesc('last_id')->limit($limit)->pluck('session_id');

        $views = DB::table('analytics_page_views')->whereIn('session_id', $sessionIds)->orderBy('id')->get()->groupBy('session_id');
        $events = DB::table('analytics_events')->whereIn('session_id', $sessionIds)->get()->groupBy('session_id');

        return $sessionIds->map(function ($id) use ($views, $events) {
            $pages = $views[$id] ?? collect();
            $first = $pages->first();

            return (object) [
                'started' => CarbonImmutable::parse($first->created_at, 'UTC'),
                'ended' => CarbonImmutable::parse($pages->last()->created_at, 'UTC'),
                'source' => $pages->firstWhere('is_entry', true)->source ?? $first->source,
                'referrer' => $pages->firstWhere('is_entry', true)->referrer_host ?? null,
                'device' => $first->device,
                'browser' => $first->browser,
                'os' => $first->os,
                'returning' => ! $pages->contains(fn ($p) => (bool) $p->is_new_visitor),
                'paths' => $pages->pluck('path'),
                'events' => ($events[$id] ?? collect())->pluck('name')->unique()->values(),
            ];
        });
    }
}
