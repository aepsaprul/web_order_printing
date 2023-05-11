<?php

namespace App\Providers;

use App\Models\Notif;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Blade::directive('currency', function ( $expression ) 
      { 
        return "<?php echo number_format($expression,0,',','.'); ?>"; 
      });

      View::composer('*', function ($view) {
        if (Auth::user()) {
          $notif = Notif::where('customer_id', Auth::user()->id)->whereNull('status')->get();
        } else {
          $notif = null;
        }
        $view->with('boot_notif', $notif);
      });
    }
}
