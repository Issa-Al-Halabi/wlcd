<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Setting;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IpBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->is('api/*')) {
            $validator = Validator::make($request->all(), [
                'secret' => 'required',
            ]);

            if ($validator->fails()) {
                
                return response()->json(['Secret Key is required']);
            }

            // $key = DB::table('api_keys')
            //     ->where('secret_key', '=', $request->secret)
            //     ->first();
            $key = 'b13136c2-eab7-4910-abc5-5beff83862f6';

            if (!$key) {
                
                return response()->json(['Invalid Secret Key !']);
            }
        }
        $ip = $request->ip();
        return $next($request);
        // $setting = Setting::first();
        // $setting = [
        //     'ipblock_enable'=>0
        // ];
        // $setting = collect($setting);


        // $ip_address = array();

        // if($setting->ipblock_enable == 1)
        // {
        //     if(is_array($setting['ipblock']) || is_object($setting['ipblock'])) 
        //     {
        //         foreach($setting->ipblock as $b)
        //         {
        //             array_push($ip_address, $b);
        //         }
        //     }

        //     $ip_address = array_values(array_filter($ip_address));

        //     $ip_address = array_flatten($ip_address);


        //     if($setting->ipblock_enable == 1)
        //     {
        //         if(isset($ip_address) && in_array($ip, $ip_address))
        //         {
        //             if(!$request->wantsjson()) 
        //             {
        //                 return redirect()->route('ip.block');
                        
        //             }
        //             else
        //             {
        //                 return response()->json(array('Your IP is block'), 200);
        //             }
        //         }
        //         else
        //         {
        //             return $next($request);
        //         }
                
        //     }
        //     else
        //     {
        //         return $next($request);
        //     }
        // }
        // else{
        //     return $next($request);
        // }



            
    }
}
