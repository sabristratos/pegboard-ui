<?php

declare(strict_types=1);

namespace Stratos\Pegboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PegboardServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/pegboard.php',
            'pegboard'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pegboard');

        Blade::componentNamespace('Stratos\\Pegboard\\View\\Components', 'pegboard');

        Route::get('/pegboard/pegboard.js', function () {
            return response()->file(__DIR__.'/../dist/pegboard.js', [
                'Content-Type' => 'application/javascript',
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        })->name('pegboard.js');

        Blade::directive('pegboard', function () {
            return "<?php echo '<script type=\"module\" src=\"' . route('pegboard.js') . '\"></script>'; ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/pegboard.php' => config_path('pegboard.php'),
            ], 'pegboard-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/pegboard'),
            ], 'pegboard-views');

            $this->publishes([
                __DIR__.'/../dist/pegboard.js' => public_path('vendor/pegboard/pegboard.js'),
            ], 'pegboard-assets');

            $this->publishes([
                __DIR__.'/../resources/icons' => resource_path('icons'),
            ], 'pegboard-icons');

            $this->publishes([
                __DIR__.'/../config/pegboard.php' => config_path('pegboard.php'),
                __DIR__.'/../resources/views' => resource_path('views/vendor/pegboard'),
                __DIR__.'/../dist/pegboard.js' => public_path('vendor/pegboard/pegboard.js'),
                __DIR__.'/../resources/icons' => resource_path('icons'),
            ], 'pegboard');
        }
    }
}
