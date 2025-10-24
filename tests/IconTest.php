<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Tests;

use Orchestra\Testbench\TestCase;
use Stratos\Pegboard\PegboardServiceProvider;
use Stratos\Pegboard\View\Components\Icon;

class IconTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PegboardServiceProvider::class,
            \BladeUI\Icons\BladeIconsServiceProvider::class,
            \BladeUI\Heroicons\BladeHeroiconsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('pegboard.dev_mode', true);
        $app['config']->set('pegboard.icons.fallback', 'question-mark-circle');
        $app['config']->set('pegboard.icons.default_variant', 'outline');
        $app['config']->set('pegboard.icons.resolution_order', ['heroicon', 'custom']);
    }

    public function test_renders_basic_heroicon(): void
    {
        $component = new Icon(name: 'home');

        $this->assertEquals('heroicon-o-home', $component->iconComponent);
        $this->assertTrue($component->ariaHidden);
    }

    public function test_applies_variant_correctly(): void
    {
        $solid = new Icon(name: 'star', variant: 'solid');
        $this->assertEquals('heroicon-s-star', $solid->iconComponent);

        $mini = new Icon(name: 'star', variant: 'mini');
        $this->assertEquals('heroicon-m-star', $mini->iconComponent);

        $micro = new Icon(name: 'star', variant: 'micro');
        $this->assertEquals('heroicon-c-star', $micro->iconComponent);

        $outline = new Icon(name: 'star', variant: 'outline');
        $this->assertEquals('heroicon-o-star', $outline->iconComponent);
    }

    public function test_uses_default_variant_when_null(): void
    {
        $component = new Icon(name: 'heart');

        $this->assertEquals('heroicon-o-heart', $component->iconComponent);
    }

    public function test_applies_size_preset(): void
    {
        $this->app['config']->set('pegboard.icons.sizes', [
            'xs' => 'h-3 w-3',
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            'xl' => 'h-8 w-8',
        ]);

        $xs = new Icon(name: 'check', size: 'xs');
        $this->assertEquals('h-3 w-3', $xs->sizeClass);

        $sm = new Icon(name: 'check', size: 'sm');
        $this->assertEquals('h-4 w-4', $sm->sizeClass);

        $md = new Icon(name: 'check', size: 'md');
        $this->assertEquals('h-5 w-5', $md->sizeClass);

        $lg = new Icon(name: 'check', size: 'lg');
        $this->assertEquals('h-6 w-6', $lg->sizeClass);

        $xl = new Icon(name: 'check', size: 'xl');
        $this->assertEquals('h-8 w-8', $xl->sizeClass);
    }

    public function test_decorative_icon_has_aria_hidden(): void
    {
        $component = new Icon(name: 'sparkles', decorative: true);

        $this->assertTrue($component->ariaHidden);
        $this->assertNull($component->ariaLabel);
    }

    public function test_semantic_icon_with_aria_label(): void
    {
        $component = new Icon(
            name: 'trash',
            decorative: false,
            ariaLabel: 'Delete item'
        );

        $this->assertFalse($component->ariaHidden);
        $this->assertEquals('Delete item', $component->ariaLabel);
    }

    public function test_aria_label_overrides_decorative(): void
    {
        // Even if decorative is true, aria-label should make it semantic
        $component = new Icon(
            name: 'info',
            decorative: true,
            ariaLabel: 'Information'
        );

        $this->assertFalse($component->ariaHidden);
        $this->assertEquals('Information', $component->ariaLabel);
    }

    public function test_explicit_heroicon_set(): void
    {
        $component = new Icon(name: 'bell', set: 'heroicon', variant: 'solid');

        $this->assertEquals('heroicon-s-bell', $component->iconComponent);
    }

    public function test_renders_view(): void
    {
        $component = new Icon(name: 'home');

        $view = $component->render();

        $this->assertEquals('pegboard::components.icon', $view->name());
    }

    public function test_fallback_for_nonexistent_icon(): void
    {
        $component = new Icon(name: 'totally-fake-icon-that-does-not-exist');

        // Should use fallback icon
        $this->assertEquals('heroicon-o-question-mark-circle', $component->iconComponent);
    }

    public function test_can_disable_fallback_via_config(): void
    {
        $this->app['config']->set('pegboard.icons.fallback', null);

        $component = new Icon(name: 'fake-icon');

        // Should return original heroicon component even if it doesn't exist
        $this->assertEquals('heroicon-o-fake-icon', $component->iconComponent);
    }

    public function test_custom_icon_set_component_name(): void
    {
        $component = new Icon(name: 'logo', set: 'custom');

        $this->assertEquals('pegboard-custom-logo', $component->iconComponent);
    }

    public function test_all_size_presets_return_null_for_invalid_size(): void
    {
        $component = new Icon(name: 'home', size: 'invalid-size');

        $this->assertNull($component->sizeClass);
    }

    public function test_component_properties_are_public(): void
    {
        $component = new Icon(
            name: 'star',
            variant: 'solid',
            set: 'heroicon',
            size: 'md',
            decorative: false,
            ariaLabel: 'Favorite'
        );

        $this->assertEquals('star', $component->name);
        $this->assertEquals('solid', $component->variant);
        $this->assertEquals('heroicon', $component->set);
        $this->assertEquals('md', $component->size);
        $this->assertFalse($component->decorative);
        $this->assertEquals('Favorite', $component->ariaLabel);
    }
}
