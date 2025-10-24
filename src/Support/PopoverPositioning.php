<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Support;

/**
 * Popover Positioning Utility
 *
 * Centralizes CSS anchor positioning logic for all popover-based components.
 * Provides consistent placement calculations and styles across Popover, Select, Dropdown, etc.
 */
class PopoverPositioning
{
    /**
     * Generate inline CSS styles for anchor positioning
     *
     * @param  string  $placement  Placement direction (e.g., 'bottom', 'top-start', 'right-end')
     * @param  string  $anchorName  Anchor name (e.g., '--anchor-my-id')
     * @param  int  $offset  Distance from anchor in pixels
     * @return string Inline CSS styles
     */
    public static function getStyles(
        string $placement,
        string $anchorName,
        int $offset = 8
    ): string {
        $offsetPx = "{$offset}px";

        return match ($placement) {
            'top' => "position: absolute; inset: auto; position-anchor: {$anchorName}; bottom: anchor(top); margin-bottom: {$offsetPx}; left: anchor(center); translate: -50% 0; position-try-fallbacks: flip-block, flip-inline;",
            'top-start' => "position: absolute; inset: auto; position-anchor: {$anchorName}; bottom: anchor(top); margin-bottom: {$offsetPx}; left: anchor(left); position-try-fallbacks: flip-block, flip-inline;",
            'top-end' => "position: absolute; inset: auto; position-anchor: {$anchorName}; bottom: anchor(top); margin-bottom: {$offsetPx}; right: anchor(right); position-try-fallbacks: flip-block, flip-inline;",

            'bottom' => "position: absolute; inset: auto; position-anchor: {$anchorName}; top: anchor(bottom); margin-top: {$offsetPx}; left: anchor(center); translate: -50% 0; position-try-fallbacks: flip-block, flip-inline;",
            'bottom-start' => "position: absolute; inset: auto; position-anchor: {$anchorName}; top: anchor(bottom); margin-top: {$offsetPx}; left: anchor(left); position-try-fallbacks: flip-block, flip-inline;",
            'bottom-end' => "position: absolute; inset: auto; position-anchor: {$anchorName}; top: anchor(bottom); margin-top: {$offsetPx}; right: anchor(right); position-try-fallbacks: flip-block, flip-inline;",

            'left' => "position: absolute; inset: auto; position-anchor: {$anchorName}; right: anchor(left); margin-right: {$offsetPx}; top: anchor(center); translate: 0 -50%; position-try-fallbacks: flip-inline, flip-block;",
            'left-start' => "position: absolute; inset: auto; position-anchor: {$anchorName}; right: anchor(left); margin-right: {$offsetPx}; top: anchor(top); position-try-fallbacks: flip-inline, flip-block;",
            'left-end' => "position: absolute; inset: auto; position-anchor: {$anchorName}; right: anchor(left); margin-right: {$offsetPx}; bottom: anchor(bottom); position-try-fallbacks: flip-inline, flip-block;",

            'right' => "position: absolute; inset: auto; position-anchor: {$anchorName}; left: anchor(right); margin-left: {$offsetPx}; top: anchor(center); translate: 0 -50%; position-try-fallbacks: flip-inline, flip-block;",
            'right-start' => "position: absolute; inset: auto; position-anchor: {$anchorName}; left: anchor(right); margin-left: {$offsetPx}; top: anchor(top); position-try-fallbacks: flip-inline, flip-block;",
            'right-end' => "position: absolute; inset: auto; position-anchor: {$anchorName}; left: anchor(right); margin-left: {$offsetPx}; bottom: anchor(bottom); position-try-fallbacks: flip-inline, flip-block;",

            default => "position: absolute; inset: auto; position-anchor: {$anchorName}; top: anchor(bottom); margin-top: {$offsetPx}; left: anchor(left); position-try-fallbacks: flip-block, flip-inline;",
        };
    }

    /**
     * Generate Tailwind CSS classes for anchor positioning
     *
     * Note: Inline styles are recommended for anchor positioning since Tailwind doesn't have
     * built-in utilities for anchor() function. This method is provided for custom implementations.
     *
     * @param  string  $placement  Placement direction
     * @param  int  $offset  Distance from anchor in pixels
     * @return string Tailwind CSS classes (using arbitrary values)
     */
    public static function getClasses(
        string $placement,
        int $offset = 8
    ): string {
        $offsetRem = $offset / 16; // Convert px to rem
        $offsetValue = "{$offsetRem}rem";

        return match ($placement) {
            'top' => "[bottom:calc(anchor(top)+{$offsetValue})] [left:anchor(center)] -translate-x-1/2",
            'top-start' => "[bottom:calc(anchor(top)+{$offsetValue})] [left:anchor(left)]",
            'top-end' => "[bottom:calc(anchor(top)+{$offsetValue})] [right:anchor(right)]",

            'bottom' => "[top:calc(anchor(bottom)+{$offsetValue})] [left:anchor(center)] -translate-x-1/2",
            'bottom-start' => "[top:calc(anchor(bottom)+{$offsetValue})] [left:anchor(left)]",
            'bottom-end' => "[top:calc(anchor(bottom)+{$offsetValue})] [right:anchor(right)]",

            'left' => "[right:calc(anchor(left)+{$offsetValue})] [top:anchor(center)] -translate-y-1/2",
            'left-start' => "[right:calc(anchor(left)+{$offsetValue})] [top:anchor(top)]",
            'left-end' => "[right:calc(anchor(left)+{$offsetValue})] [bottom:anchor(bottom)]",

            'right' => "[left:calc(anchor(right)+{$offsetValue})] [top:anchor(center)] -translate-y-1/2",
            'right-start' => "[left:calc(anchor(right)+{$offsetValue})] [top:anchor(top)]",
            'right-end' => "[left:calc(anchor(right)+{$offsetValue})] [bottom:anchor(bottom)]",

            default => "[top:calc(anchor(bottom)+{$offsetValue})] [left:anchor(left)]",
        };
    }

    /**
     * Get position-try-fallbacks for a placement
     *
     * @param  string  $placement  Placement direction
     * @return string Position try fallbacks CSS value
     */
    public static function getFallbacks(string $placement): string
    {
        if (str_starts_with($placement, 'top') || str_starts_with($placement, 'bottom')) {
            return 'flip-block, flip-inline';
        }

        if (str_starts_with($placement, 'left') || str_starts_with($placement, 'right')) {
            return 'flip-inline, flip-block';
        }

        return 'flip-block, flip-inline';
    }

    /**
     * Generate a unique anchor name for an ID
     *
     * @param  string  $id  Component ID
     * @return string Anchor name (e.g., '--anchor-my-id')
     */
    public static function generateAnchorName(string $id): string
    {
        return "--anchor-{$id}";
    }

    /**
     * Get default transition classes for popover animations
     *
     * Uses Tailwind v4 transition-discrete and @starting-style for smooth animations
     *
     * @return string Tailwind CSS classes
     */
    public static function transitionClasses(): string
    {
        return 'origin-center transition-[opacity,transform,overlay,display] duration-fast ease-out transition-discrete starting:opacity-0 starting:scale-95';
    }

    /**
     * Get base reset classes for popovers
     *
     * Resets default browser popover styles for full control
     *
     * @return string Tailwind CSS classes
     */
    public static function baseClasses(): string
    {
        return 'p-0 m-0';
    }

    /**
     * Get styles with anchor-size width matching
     *
     * Useful for dropdowns/selects that should match trigger width
     *
     * @param  string  $placement  Placement direction
     * @param  string  $anchorName  Anchor name
     * @param  int  $offset  Distance from anchor in pixels
     * @return string Inline CSS styles with min-width: anchor-size(width)
     */
    public static function getStylesWithWidthMatching(
        string $placement,
        string $anchorName,
        int $offset = 8
    ): string {
        $baseStyles = self::getStyles($placement, $anchorName, $offset);

        return "{$baseStyles} min-width: anchor-size(width);";
    }

    /**
     * Get origin class for transform animations based on placement
     *
     * @param  string  $placement  Placement direction
     * @return string Tailwind origin class
     */
    public static function getOriginClass(string $placement): string
    {
        return match (true) {
            str_starts_with($placement, 'top-start') || str_starts_with($placement, 'left-start') => 'origin-bottom-left',
            str_starts_with($placement, 'top-end') || str_starts_with($placement, 'right-start') => 'origin-bottom-right',
            str_starts_with($placement, 'bottom-start') || str_starts_with($placement, 'left-end') => 'origin-top-left',
            str_starts_with($placement, 'bottom-end') || str_starts_with($placement, 'right-end') => 'origin-top-right',
            str_starts_with($placement, 'top') => 'origin-bottom',
            str_starts_with($placement, 'bottom') => 'origin-top',
            str_starts_with($placement, 'left') => 'origin-right',
            str_starts_with($placement, 'right') => 'origin-left',
            default => 'origin-center',
        };
    }

    /**
     * Get complete positioning configuration for a component
     *
     * Returns all necessary positioning attributes and classes
     *
     * @param  string  $id  Component ID
     * @param  string  $placement  Placement direction
     * @param  int  $offset  Distance from anchor in pixels
     * @param  bool  $matchWidth  Whether to match anchor width
     * @return array{anchor: string, styles: string, transition: string, origin: string, base: string}
     */
    public static function getConfiguration(
        string $id,
        string $placement = 'bottom',
        int $offset = 8,
        bool $matchWidth = false
    ): array {
        $anchorName = self::generateAnchorName($id);
        $styles = $matchWidth
            ? self::getStylesWithWidthMatching($placement, $anchorName, $offset)
            : self::getStyles($placement, $anchorName, $offset);

        return [
            'anchor' => $anchorName,
            'styles' => $styles,
            'transition' => self::transitionClasses(),
            'origin' => self::getOriginClass($placement),
            'base' => self::baseClasses(),
        ];
    }
}
