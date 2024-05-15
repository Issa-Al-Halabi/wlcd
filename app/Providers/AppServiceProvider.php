<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use App\Setting;
use Session;
use App\Currency;
use App\InstructorSetting;
use Illuminate\Support\Facades\Validator;
use App\ColorOption;
use App\Helpers\Tracker;
use App\Homesetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use File;
use App\Terms;
use Illuminate\Support\Facades\URL;

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
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            URL::forceScheme('https');
        }

        if (!file_exists(storage_path() . '/app/public/text.txt')) {

            try {

                $dir27 = base_path() . '/bootstrap/cache';

                foreach (glob("$dir27/*") as $file) {

                    try {
                        unlink($file);
                    } catch (\Exception $e) {
                    }
                }



                $dir = base_path() . '/Modules';

                $x = File::deleteDirectory($dir);

                $y = File::deleteDirectory(public_path() . '/modules');

                try {
                    unlink(base_path() . '/modules_statuses.json');
                } catch (\Exception $e) {
                }

                \Artisan::call('route:clear');


                $file = @file_put_contents(storage_path() . '/app/public/text.txt', 1);
            } catch (\Exception $e) {
            }
        }




        try {
            \DB::connection()->getPdo();


            $code = @file_get_contents(public_path() . '/code.txt');

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip_address = @$_SERVER['HTTP_CLIENT_IP'];
            }
            //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip_address = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            //whether ip is from remote address
            else {
                $ip_address = @$_SERVER['REMOTE_ADDR'];
            }

            $d = \Request::getHost();


            $data = array();
            
            if (\DB::connection()->getDatabaseName()) {
                // if (Schema::hasTable('settings')) {
                    if(!\Request::is('api/*'))
                    {
                        $gsetting = Setting::first();
                        $currency =  Currency::where('default', '=', '1')->first();
                        $isetting = InstructorSetting::first();
                        $zoom_enable = Setting::first()->zoom_enable;
                        $terms = Terms::first();
                        $hsetting = Homesetting::first();

                        $data = array(

                            'gsetting' => $gsetting ?? '',
                            'currency' => $currency ?? '',
                            'isetting' => $isetting ?? '',
                            'zoom_enable' => $zoom_enable ?? '',
                            'terms' => $terms ?? '',
                            'hsetting' => $hsetting ?? '',
                        );



                        view()->composer('*', function ($view) use ($data) {

                            try {

                                $view->with([
                                    'gsetting' => $data['gsetting'],
                                    'currency' => $data['currency'],
                                    'isetting' => $data['isetting'],
                                    'zoom_enable' => $data['zoom_enable'],
                                    'terms' => $data['terms'],
                                    'hsetting' => $data['hsetting']
                                ]);
                            } catch (\Exception $e) {
                            }
                        });
                    }
                // }
            }
        } catch (\Exception $ex) {
        }
    }
}
