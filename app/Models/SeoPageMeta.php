<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeoPageMeta extends Model
{
    protected $fillable = [
        'uri',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_card',
        'noindex',
        'nofollow',
        'canonical',
        'schema_markup',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
    ];

    /**
     * Find a page meta by its URI.
     */
    public static function findByUri(string $uri): ?static
    {
        return static::query()->where('uri', $uri)->first();
    }

    /**
     * Get the OG image URL or null.
     */
    public function ogImageUrl(): ?string
    {
        return $this->og_image ? Storage::disk('public')->url($this->og_image) : null;
    }

    /**
     * Get the Twitter image URL or null.
     */
    public function twitterImageUrl(): ?string
    {
        return $this->twitter_image ? Storage::disk('public')->url($this->twitter_image) : null;
    }

    /**
     * Get robots directives string.
     */
    public function robotsDirective(): string
    {
        $directives = [];

        if ($this->noindex) {
            $directives[] = 'noindex';
        } else {
            $directives[] = 'index';
        }

        if ($this->nofollow) {
            $directives[] = 'nofollow';
        } else {
            $directives[] = 'follow';
        }

        return implode(', ', $directives);
    }

    /**
     * Get all unique page URIs from public routes for seeding the manager.
     */
    public static function publicPageUris(): array
    {
        return [
            '/' => 'Home Page',
            '/about' => 'About Us',
            '/events' => 'Events',
            '/news' => 'News',
            '/stories' => 'Alumni Stories',
            '/gallery' => 'Photo Gallery',
            '/leaderboard' => 'Donor Leaderboard',
            '/finance' => 'Financial Transparency',
            '/committees' => 'Committees',
            '/publications' => 'Publications',
            '/press-releases' => 'Press Releases',
            '/contact' => 'Contact Us',
            '/credits' => 'Credits',
            '/members' => 'Member Directory',
            '/membership' => 'Membership',
            '/membership/apply' => 'Apply for Membership',
        ];
    }
}
