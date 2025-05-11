<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
// use Illuminate\Support\ServiceProvider;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Warehouse;
use App\Policies\WarehousePolicy;
use App\Models\WarehouseLocation;
use App\Policies\WarehouseLocationPolicy;
use App\Models\ProductBatch;
use App\Policies\ProductBatchPolicy;
use App\Models\Stock;
use App\Policies\StockPolicy;


class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Warehouse::class => WarehousePolicy::class,
        WarehouseLocation::class => WarehouseLocationPolicy::class,
        ProductBatch::class => ProductBatchPolicy::class,
        Stock::class => StockPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
