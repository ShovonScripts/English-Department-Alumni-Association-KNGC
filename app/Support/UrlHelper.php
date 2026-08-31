<?php

namespace App\Support;

class UrlHelper
{
    /**
     * Sanitize a URL for safe output in an href attribute.
     * Returns null if the URL is invalid or uses a dangerous protocol.
     */
    public static function sanitize(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Only allow http and https protocols.
        $scheme = parse_url($url, PHP_URL_SCHEME);

        if ($scheme === null || ! in_array(strtolower($scheme), ['http', 'https'], true)) {
            return null;
        }

        // Must have a valid host.
        $host = parse_url($url, PHP_URL_HOST);
        if (empty($host)) {
            return null;
        }

        return $url;
    }

    /**
     * Sanitize a URL and return an HTML-safe anchor tag, or empty string if invalid.
     */
    public static function link(?string $url, string $label, string $classes = ''): string
    {
        $url = static::sanitize($url);

        if ($url === null) {
            return '';
        }

        $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        $escapedLabel = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
        $escapedClasses = $classes ? ' class="'.htmlspecialchars($classes, ENT_QUOTES, 'UTF-8').'"' : '';

        return '<a href="'.$escapedUrl.'"'.$escapedClasses.' target="_blank" rel="noopener noreferrer">'.$escapedLabel.'</a>';
    }

    /**
     * Return a safe href value or '#' as fallback.
     */
    public static function safeHref(?string $url): string
    {
        return static::sanitize($url) ?? '#';
    }
}
