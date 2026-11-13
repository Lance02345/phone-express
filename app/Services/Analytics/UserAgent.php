<?php

namespace App\Services\Analytics;

/**
 * Deliberately small user-agent classifier: enough for device/browser/OS
 * breakdowns without pulling a parsing package onto shared hosting.
 */
final class UserAgent
{
    private const BOT_PATTERN = '/bot|crawl|spider|slurp|scan|fetch|preview|facebookexternalhit|whatsapp|telegram|discord|skype|embedly|quora|pinterest|lighthouse|pagespeed|headless|phantom|curl|wget|python|java\/|go-http|okhttp|axios|node-fetch|guzzle|monitor|uptime|pingdom|semrush|ahrefs|mj12|dotbot|bytespider|gptbot|claude|perplexity|ccbot|symfony|^$/i';

    public function __construct(private readonly string $ua)
    {
    }

    public function isBot(): bool
    {
        return (bool) preg_match(self::BOT_PATTERN, $this->ua);
    }

    public function device(): string
    {
        $ua = $this->ua;

        if (preg_match('/iPad|Tablet|PlayBook|Silk|Kindle|(Android(?!.*Mobile))/i', $ua)) {
            return 'tablet';
        }

        if (preg_match('/Mobi|iPhone|iPod|Android|IEMobile|Opera Mini|KaiOS|BlackBerry/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    public function browser(): string
    {
        return match (true) {
            (bool) preg_match('/Opera Mini/i', $this->ua) => 'Opera Mini',
            (bool) preg_match('/OPR\/|Opera|OPiOS/i', $this->ua) => 'Opera',
            (bool) preg_match('/Edg(e|A|iOS)?\//i', $this->ua) => 'Edge',
            (bool) preg_match('/SamsungBrowser/i', $this->ua) => 'Samsung Internet',
            (bool) preg_match('/UCBrowser/i', $this->ua) => 'UC Browser',
            (bool) preg_match('/FBAN|FBAV|FB_IAB/i', $this->ua) => 'Facebook app',
            (bool) preg_match('/Instagram/i', $this->ua) => 'Instagram app',
            (bool) preg_match('/Twitter|TwitterAndroid/i', $this->ua) => 'X app',
            (bool) preg_match('/TikTok|musical_ly|BytedanceWebview/i', $this->ua) => 'TikTok app',
            (bool) preg_match('/Firefox|FxiOS/i', $this->ua) => 'Firefox',
            (bool) preg_match('/CriOS|Chrome/i', $this->ua) => 'Chrome',
            (bool) preg_match('/Safari/i', $this->ua) => 'Safari',
            default => 'Other',
        };
    }

    public function os(): string
    {
        return match (true) {
            (bool) preg_match('/iPhone|iPad|iPod/i', $this->ua) => 'iOS',
            (bool) preg_match('/Android/i', $this->ua) => 'Android',
            (bool) preg_match('/KaiOS/i', $this->ua) => 'KaiOS',
            (bool) preg_match('/Windows/i', $this->ua) => 'Windows',
            (bool) preg_match('/Mac OS X|Macintosh/i', $this->ua) => 'macOS',
            (bool) preg_match('/CrOS/i', $this->ua) => 'ChromeOS',
            (bool) preg_match('/Linux/i', $this->ua) => 'Linux',
            default => 'Other',
        };
    }
}
