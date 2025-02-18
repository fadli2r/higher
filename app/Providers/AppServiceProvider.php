<?php

namespace App\Providers;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use App\Models\Order;
use App\Models\Product;
use App\Models\TicketMessage;
use App\Models\Transaction;
use App\Observers\MessageObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\TransactionObserver;
use App\Models\WorkerTask;
use App\Observers\WorkerTaskObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // FilamentAsset::register([
        //     Css::make('example-external-stylesheet', 'https://example.com/external.css'),
        //     Css::make('example-local-stylesheet', asset('css/local.css')),
        // ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // \URL::forceScheme('https');

        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::except([
            'webhook'
        ]);

        Order::observe(OrderObserver::class);  // Daftarkan observer untuk model Order
        Transaction::observe(TransactionObserver::class);
        TicketMessage::observe(MessageObserver::class);
        Product::observe(ProductObserver::class);
        WorkerTask::observe(WorkerTaskObserver::class);

        User::observe(UserObserver::class);
        Blade::directive('rupiah', function ($value) {
            return "<?php echo 'Rp ' . number_format($value, 0, ',', '.'); ?>";
        });

    }


}
