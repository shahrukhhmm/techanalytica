<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Route;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    View::composer('*', function ($view) {
      if (auth()->check() && auth()->user()->role === 'vendor') {
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuVendor.json'));
      } else {
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      }
      $verticalMenuData = json_decode($verticalMenuJson);

      if (auth()->check() && auth()->user()->role === 'vendor' && auth()->user()->vendor) {
        $vendor = auth()->user()->vendor->load('tier');
        
        if ($vendor->tier) {
          $permissions = $vendor->tier->permissions ?? [];
          
          // Filter menu based on permissions
          $verticalItems = collect($verticalMenuData->menu)->filter(function ($item) use ($permissions) {
            if (isset($item->permission) && !in_array($item->permission, $permissions)) {
              return false;
            }
            
            if (isset($item->submenu)) {
              $item->submenu = collect($item->submenu)->filter(function ($sub) use ($permissions) {
                if (isset($sub->permission) && !in_array($sub->permission, $permissions)) {
                  return false;
                }
                return true;
              })->values()->all();
            }
            return true;
          })->values()->all();
          
          $verticalMenuData->menu = $verticalItems;
        }
      }

      $view->with('menuData', [$verticalMenuData]);
    });
  }
}
