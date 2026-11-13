<?php

namespace App\Services\Analytics;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Anonymous first-party visitor + visit identifiers. No IP address is stored.
 */
final class VisitorContext
{
    private function __construct(
        public readonly string $visitorId,
        public readonly string $sessionId,
        public readonly bool $isNewVisitor,
        public readonly bool $isNewSession,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $visitor = $request->cookie(config('analytics.visitor_cookie'));
        $session = $request->cookie(config('analytics.session_cookie'));
        $newVisitor = ! is_string($visitor) || ! Str::isUuid($visitor);
        $newSession = ! is_string($session) || ! Str::isUuid($session);

        return new self(
            $newVisitor ? (string) Str::uuid() : $visitor,
            $newSession ? (string) Str::uuid() : $session,
            $newVisitor,
            $newSession,
        );
    }

    public function attachCookies(Response $response): void
    {
        $secure = request()->isSecure();
        $response->headers->setCookie(Cookie::create(config('analytics.visitor_cookie'), $this->visitorId, now()->addYear(), '/', null, $secure, true, false, Cookie::SAMESITE_LAX));
        // Sliding expiry: a visit ends after N idle minutes.
        $response->headers->setCookie(Cookie::create(config('analytics.session_cookie'), $this->sessionId, now()->addMinutes(config('analytics.session_minutes')), '/', null, $secure, true, false, Cookie::SAMESITE_LAX));
    }
}
