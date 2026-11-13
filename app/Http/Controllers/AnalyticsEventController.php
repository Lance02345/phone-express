<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\AnalyticsPageView;
use App\Services\Analytics\UserAgent;
use App\Services\Analytics\VisitorContext;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** Receives click beacons (WhatsApp, call, email, outbound) from the storefront. */
class AnalyticsEventController extends Controller
{
    public function store(Request $request): Response
    {
        // A click after 30 idle minutes starts a new visit, but we only accept
        // beacons from browsers that have already loaded a tracked page.
        $context = VisitorContext::fromRequest($request);

        if ($context->isNewVisitor || $request->user() || (new UserAgent((string) $request->userAgent()))->isBot()) {
            return response()->noContent();
        }

        $data = $request->validate([
            'name' => ['required', Rule::in(AnalyticsEvent::NAMES)],
            'path' => ['required', 'string', 'max:255'],
            'label' => ['nullable', 'string', 'max:500'],
        ]);

        $path = '/'.ltrim((string) parse_url($data['path'], PHP_URL_PATH), '/');

        // Attribute the click to the product being viewed on that page, if any.
        $variantId = AnalyticsPageView::query()
            ->where('session_id', $context->sessionId)
            ->where('path', $path)
            ->latest('id')
            ->value('product_variant_id');

        AnalyticsEvent::create([
            'visitor_id' => $context->visitorId,
            'session_id' => $context->sessionId,
            'name' => $data['name'],
            'path' => Str::limit($path, 250, ''),
            'label' => isset($data['label']) ? Str::limit($data['label'], 250, '') : null,
            'product_variant_id' => $variantId,
            'local_date' => now(config('analytics.timezone'))->toDateString(),
            'created_at' => now(),
        ]);

        $response = response()->noContent();
        $context->attachCookies($response);

        return $response;
    }
}
