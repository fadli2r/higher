<?php

namespace App\Providers;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentAsset::register([
            Css::make('example-external-stylesheet', 'https://example.com/external.css'),
            Css::make('example-local-stylesheet', asset('css/local.css')),
        ]);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Blade::directive('rupiah', function ($value) {
            return "<?php echo 'Rp ' . number_format($value, 0, ',', '.'); ?>";
        });
    }
}
