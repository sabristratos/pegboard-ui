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
    | Visual Customization
    |--------------------------------------------------------------------------
    |
    | Pegboard follows a CSS-first design philosophy. All visual customization
    | (colors, spacing, typography, transitions, etc.) is done by overriding
    | CSS custom properties defined in resources/css/pegboard.css.
    |
    | To customize the appearance:
    | 1. Import pegboard.css in your main CSS file
    | 2. Override any custom property (e.g., --color-primary, --brand-500, etc.)
    | 3. Use Tailwind utilities on components for one-off styling
    |
    | Example:
    | @import 'path/to/pegboard.css';
    |
    | @theme {
    |   --brand-500: var(--color-purple-500);  // Change brand color
    |   --duration-fast: 100ms;                // Speed up animations
    | }
    |
    */

];
