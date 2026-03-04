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

      if (auth()->check() && auth()->user()->role === 'vendor') {
        $activeToolId = session('active_tool_id');
        
        // If no active tool in session, try to pick the first one from user
        if (!$activeToolId && auth()->user()->vendor) {
           $firstTool = auth()->user()->vendor->tools()->first();
           if ($firstTool) {
               $activeToolId = $firstTool->id;
               session(['active_tool_id' => $activeToolId]);
           }
        }

        if ($activeToolId) {
          $activeTool = \App\Models\Tool::with('tier')->find($activeToolId);
          
          if ($activeTool && $activeTool->tier) {
            $permissions = $activeTool->tier->permissions ?? [];
            
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
                
                if (empty($item->submenu)) {
                  // return false; // Optional: hide parent if empty, keeping it for now
                }
              }
              return true;
            })->values()->all();
            
            $verticalMenuData->menu = $verticalItems;
          }
        }
      }

      $view->with('menuData', [$verticalMenuData]);
    });
  }
}
