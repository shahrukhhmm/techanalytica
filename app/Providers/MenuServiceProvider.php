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
    View::composer([
      'backend.admin.layouts.*',
      'backend.vendor.layouts.*',
      'backend.admin.layouts.sections.menu.*',
      'backend.vendor.layouts.sections.menu.*',
    ], function ($view) {
      static $adminMenuCache = null;
      static $vendorMenuCache = [];

      $isVendor = auth()->check() && auth()->user()->role === 'vendor';

      if ($isVendor) {
        $vendor = auth()->user()->vendor;
        $vendorId = $vendor ? $vendor->id : 0;

        if (!isset($vendorMenuCache[$vendorId])) {
          $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuVendor.json'));
          $verticalMenuData = json_decode($verticalMenuJson);

          if ($vendor && $vendor->tier) {
            $permissions = $vendor->tier->permissions ?? [];

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

          $vendorMenuCache[$vendorId] = $verticalMenuData;
        }

        $menuData = $vendorMenuCache[$vendorId];
      } else {
        if ($adminMenuCache === null) {
          $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
          $adminMenuCache = json_decode($verticalMenuJson);
        }
        $menuData = $adminMenuCache;
      }

      $view->with('menuData', [$menuData]);
    });
  }
}
