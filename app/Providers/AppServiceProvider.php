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
        \Illuminate\Pagination\Paginator::useBootstrapFive();

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

        view()->composer(['frontend.components.header', 'frontend.layout.app'], function ($view) {
            if (!isset($view->getData()['categories'])) {
                try {
                    $view->with('categories', \App\Models\Category::withCount('tools')->get());
                } catch (\Throwable $e) {
                    // Fallback gracefully if database is not reachable
                }
            }
        });
    }
}