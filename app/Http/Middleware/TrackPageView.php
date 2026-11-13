<?php

namespace App\Http\Middleware;

use App\Models\AnalyticsPageView;
use App\Models\ProductVariant;
use App\Services\Analytics\TrafficSource;
use App\Services\Analytics\UserAgent;
use App\Services\Analytics\VisitorContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Records storefront page views server-side (no extra browser request, which
 * matters on the rate-limited shared host).
 */
class TrackPageView
{
    private const DROPPED_QUERY_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid', 'gad_source', 'msclkid', 'page'];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            $context = VisitorContext::fromRequest($request);
            $this->record($request, $context);
            $context->attachCookies($response);
        } catch (Throwable $exception) {
            // Analytics must never break the storefront.
            report($exception);
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $request->ajax() || $request->expectsJson() || $request->user()) {
            return false;
        }

        if ($response->getStatusCode() !== 200 || ! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return false;
        }

        // Browser/link prefetches are not real views.
        if (str_contains(strtolower($request->header('Sec-Purpose', '').$request->header('Purpose', '').$request->header('X-Moz', '')), 'prefetch')) {
            return false;
        }

        $path = ltrim($request->path(), '/');
        foreach (config('analytics.excluded_prefixes') as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return false;
            }
        }

        return ! (new UserAgent((string) $request->userAgent()))->isBot();
    }

    private function record(Request $request, VisitorContext $context): void
    {
        $ua = new UserAgent((string) $request->userAgent());
        $query = $request->query();
        $referrerHost = $this->externalReferrerHost($request);
        $local = now(config('analytics.timezone'));
        $source = $context->isNewSession ? TrafficSource::classify($referrerHost, $query)['source'] : 'internal';
        $variant = $request->route('phone');
        $country = strtoupper((string) $request->header('CF-IPCountry'));

        AnalyticsPageView::create([
            'visitor_id' => $context->visitorId,
            'session_id' => $context->sessionId,
            'is_new_visitor' => $context->isNewVisitor,
            'is_entry' => $context->isNewSession,
            'path' => Str::limit('/'.ltrim($request->path(), '/'), 250, ''),
            'query' => $this->cleanQuery($query),
            'search_term' => $this->searchTerm($query),
            'route_name' => $request->route()?->getName(),
            'product_variant_id' => $variant instanceof ProductVariant ? $variant->getKey() : null,
            'referrer_host' => $referrerHost,
            'source' => $source,
            'utm_source' => $this->utm($query, 'utm_source'),
            'utm_medium' => $this->utm($query, 'utm_medium'),
            'utm_campaign' => $this->utm($query, 'utm_campaign'),
            'device' => $ua->device(),
            'browser' => $ua->browser(),
            'os' => $ua->os(),
            'country' => preg_match('/^[A-Z]{2}$/', $country) && $country !== 'XX' ? $country : null,
            'local_date' => $local->toDateString(),
            'local_hour' => $local->hour,
            'created_at' => now(),
        ]);
    }

    private function externalReferrerHost(Request $request): ?string
    {
        $host = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);

        if (! is_string($host) || $host === '' || strcasecmp($host, $request->getHost()) === 0) {
            return null;
        }

        return Str::limit(strtolower($host), 150, '');
    }

    private function cleanQuery(array $query): ?string
    {
        $kept = array_filter(
            array_diff_key($query, array_flip(self::DROPPED_QUERY_KEYS)),
            fn ($value) => is_scalar($value) && $value !== '',
        );
        ksort($kept);

        return $kept === [] ? null : Str::limit(http_build_query($kept), 250, '');
    }

    private function searchTerm(array $query): ?string
    {
        $term = $query['search'] ?? $query['q'] ?? null;

        return is_string($term) && trim($term) !== '' ? Str::limit(Str::lower(trim(preg_replace('/\s+/', ' ', $term))), 100, '') : null;
    }

    private function utm(array $query, string $key): ?string
    {
        $value = $query[$key] ?? null;

        return is_string($value) && trim($value) !== '' ? Str::limit(Str::lower(trim($value)), 100, '') : null;
    }
}
