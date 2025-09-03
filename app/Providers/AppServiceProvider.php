<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
    \App\Models\Product::class => \App\Policies\ProductPolicy::class,
    \App\Models\ProductCategory::class => \App\Policies\ProductCategoryPolicy::class,
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
//    $this->registerPolicies();

    // Product Permissions
    Gate::define('product.add', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL'])
    );

    Gate::define('product.edit', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL'])
    );

    Gate::define('product.delete', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'SECURITY_PERSONNEL'])
    );

    Gate::define('product.view', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL', 'MAINTENANCE_STAFF', 'CONSTRUCTION_SUPERVISOR'])
    );

    // Product Category Permissions
    Gate::define('productCategories.add', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL'])
    );

    Gate::define('productCategories.edit', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL'])
    );

    Gate::define('productCategories.delete', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'SECURITY_PERSONNEL'])
    );

    Gate::define('productCategories.view', fn($user) =>
        $user->hasRole(['SUPER_ADMIN', 'PROPERTY_MANAGER', 'OFFICE_MANAGER', 'SECURITY_PERSONNEL', 'MAINTENANCE_STAFF', 'CONSTRUCTION_SUPERVISOR'])
    );

    
}
}
