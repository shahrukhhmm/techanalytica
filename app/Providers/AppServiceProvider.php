<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        view()->composer('backend.vendor.*', function ($view) {
            $permissions = [];
            if (auth()->check() && auth()->user()->vendor) {
                $activeToolId = session('active_tool_id');
                $tool = auth()->user()->vendor->tools()->find($activeToolId) 
                        ?? auth()->user()->vendor->tools()->first();
                
                if ($tool && $tool->tier) {
                    $permissions = $tool->tier->permissions ?? [];
                }
            }
            $view->with('current_vendor_permissions', $permissions);
        });
    }
}