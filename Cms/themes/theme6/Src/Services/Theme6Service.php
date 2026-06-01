<?php

namespace Cms\Themes\Theme6\Src\Services;
use App\Facades\Theme;
use Illuminate\Support\Facades\Cache;

class Theme6Service
{
    /**
     * Get theme-specific settings
     */
    public function getSettings()
    {
        return Cache::remember('theme6_settings', 3600, function () {
            return [
                'colors' => [
                    'primary' => '#3490dc',
                    'secondary' => '#38c172',
                    'dark' => '#343a40',
                    'light' => '#f8f9fa'
                ],
                'fonts' => [
                    'primary' => "'Arial', sans-serif",
                    'secondary' => "'Helvetica', sans-serif"
                ],
                'layout' => [
                    'container_width' => '1200px',
                    'sidebar_width' => '300px'
                ]
            ];
        });
    }

    /**
     * Get theme assets
     */
    public function getAssets()
    {
        return [
            'css' => [
                Theme::asset('css/theme.css'),
                Theme::asset('css/custom.css')
            ],
            'js' => [
                Theme::asset('js/theme.js'),
                Theme::asset('js/custom.js')
            ]
        ];
    }

    /**
     * Get navigation menu
     */
    public function getNavigation()
    {
        return [
            [
                'label' => 'Home',
                'url' => '/',
                'icon' => 'fas fa-home'
            ]
        ];
    }

    /**
     * Get footer widgets
     */
    public function getFooterWidgets()
    {
        return [
            'about' => [
                'title' => 'About VivaEgyptTravel',
                'content' => 'VivaEgyptTravel is your premier tour experience platform, offering memorable tours and professional tour guides.'
            ],
            'quick_links' => [
                'title' => 'Quick Links',
                'items' => [
                    ['label' => 'Home', 'url' => '/'],
                ]
            ],
            'contact' => [
                'title' => 'Contact Us',
                'address' => '123 Travel Street, Adventure City',
                'phone' => '+1 234 567 8901',
                'email' => 'info@vivaegypttravel.com'
            ]
        ];
    }

    /**
     * Get social media links
     */
    public function getSocialLinks()
    {
        return Cache::remember('theme6_social_links', 3600, function () {
            return getContent('social_links.element') ?? [
                ['platform' => 'facebook', 'url' => '#', 'icon' => 'fab fa-facebook'],
                ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter'],
                ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram'],
                ['platform' => 'linkedin', 'url' => '#', 'icon' => 'fab fa-linkedin']
            ];
        });
    }
}
