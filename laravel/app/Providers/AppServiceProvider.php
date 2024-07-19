<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\CepService as CepServiceContract;
use App\Services\CepService;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        CepServiceContract::class => CepService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('datetime', function (string $expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });
    }
}
