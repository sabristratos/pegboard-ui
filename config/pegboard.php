<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | This value determines the prefix used for all Pegboard components.
    | By default, components can be used as <x-pegboard::button />.
    | You can change this to customize the component namespace.
    |
    */

    'prefix' => 'pegboard',

    /*
    |--------------------------------------------------------------------------
    | Load Alpine.js
    |--------------------------------------------------------------------------
    |
    | Determine whether Pegboard should automatically load Alpine.js.
    | Set this to false if you're already loading Alpine.js in your project.
    |
    */

    'load_alpinejs' => true,

    /*
    |--------------------------------------------------------------------------
    | Asset Path
    |--------------------------------------------------------------------------
    |
    | The path where Pegboard assets are published. This is relative to
    | the public directory. Change this if you need a different location.
    |
    */

    'asset_path' => 'vendor/pegboard',

    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | Configure default theme settings for Pegboard components.
    | These values can be overridden on a per-component basis.
    |
    */

    'theme' => [
        'colors' => [
            'primary' => 'blue',
            'secondary' => 'gray',
            'success' => 'green',
            'danger' => 'red',
            'warning' => 'yellow',
            'info' => 'cyan',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, Pegboard will use unminified assets and provide
    | additional debugging information. This should be disabled in production.
    |
    */

    'dev_mode' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Icon Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how Pegboard handles icons, including custom icon sets,
    | fallback behavior, and resolution order.
    |
    */

    'icons' => [
        /*
        | Custom Icons Path
        | Path relative to resources/ where custom SVG icons are stored.
        | Publish with: php artisan vendor:publish --tag=pegboard-icons
        */
        'custom_path' => 'icons',

        /*
        | Fallback Icon
        | Icon name to use when requested icon cannot be found in any set.
        | Uses Heroicon naming (without prefix). Set to null to disable.
        */
        'fallback' => 'question-mark-circle',

        /*
        | Default Variant
        | Default Heroicon variant when none specified.
        | Options: outline, solid, mini, micro
        */
        'default_variant' => 'outline',

        /*
        | Resolution Order
        | Order in which icon sets are searched when no explicit set specified.
        | First match wins. Options: heroicon, custom
        */
        'resolution_order' => ['heroicon', 'custom'],

        /*
        | Size Presets
        | Predefined size classes that can be used via size="xs|sm|md|lg|xl"
        */
        'sizes' => [
            'xs' => 'h-3 w-3',
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            'xl' => 'h-8 w-8',
        ],
    ],

];
