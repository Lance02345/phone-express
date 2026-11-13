<?php

namespace App\Services\Analytics;

final class TrafficSource
{
    private const SEARCH = ['google.', 'bing.com', 'duckduckgo.com', 'yahoo.', 'yandex.', 'ecosia.org', 'baidu.com', 'brave.com', 'search.'];

    private const SOCIAL = [
        'facebook.com' => 'Facebook', 'fb.com' => 'Facebook', 'm.facebook.com' => 'Facebook', 'l.facebook.com' => 'Facebook', 'lm.facebook.com' => 'Facebook',
        'instagram.com' => 'Instagram', 'l.instagram.com' => 'Instagram',
        't.co' => 'X', 'x.com' => 'X', 'twitter.com' => 'X',
        'tiktok.com' => 'TikTok', 'linkedin.com' => 'LinkedIn', 'lnkd.in' => 'LinkedIn',
        'youtube.com' => 'YouTube', 'reddit.com' => 'Reddit', 'pinterest.com' => 'Pinterest',
        'whatsapp.com' => 'WhatsApp', 'wa.me' => 'WhatsApp', 'l.wl.co' => 'WhatsApp',
        't.me' => 'Telegram', 'telegram.org' => 'Telegram', 'snapchat.com' => 'Snapchat', 'threads.net' => 'Threads',
    ];

    /**
     * Classify how a visit started.
     *
     * @return array{source: string, label: string|null}
     */
    public static function classify(?string $referrerHost, array $query): array
    {
        if (filled($query['utm_source'] ?? null)) {
            return ['source' => 'campaign', 'label' => (string) $query['utm_source']];
        }

        if (filled($query['gclid'] ?? null) || filled($query['gad_source'] ?? null)) {
            return ['source' => 'paid', 'label' => 'Google Ads'];
        }

        if (filled($query['fbclid'] ?? null)) {
            return ['source' => 'social', 'label' => 'Facebook'];
        }

        if (blank($referrerHost)) {
            return ['source' => 'direct', 'label' => null];
        }

        $host = preg_replace('/^www\./', '', strtolower($referrerHost));

        foreach (self::SOCIAL as $domain => $label) {
            if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                return ['source' => 'social', 'label' => $label];
            }
        }

        foreach (self::SEARCH as $needle) {
            if (str_contains($host, $needle)) {
                return ['source' => 'search', 'label' => $host];
            }
        }

        return ['source' => 'referral', 'label' => $host];
    }
}
