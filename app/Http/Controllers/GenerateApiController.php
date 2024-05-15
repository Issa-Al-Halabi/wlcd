<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Session;


class GenerateApiController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getkey()
    {
        ini_set("zlib.output_compression", "Off");

        if (Auth::check()) {
            $key = DB::table('api_keys')->first();
            return view('admin.apikeys.getkey',compact('key'));
        } else {
            
            return redirect()->route('login');
        }
    }
    public function createKey(Request $request)
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }


        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d);  
        if(strstr($domain,'localhost') || strstr( $domain, '192.168.' ) || strstr($domain,'.test') || strstr($domain,'mediacity.co.in') || strstr($domain,'castleindia.in')){
             $put = 1;
            file_put_contents(public_path().'/config.txt', $put);

            

            return $this->keysupdate($request);
        }
        else{
            
            $request->validate([
                'purchase_code'=>'required'
            ],
            [
                'purchase_code.required'=>'Please enter your envato purchase code !'
            ]);


            request()->validate([
                'purchase_code' => 'required'
            ]);

            $code = request()->purchase_code;



            $personalToken = "inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4";
            if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
                //throw new Exception("Invalid code");
                $message = __("Invalid Purchase Code");
                return back()->withErrors($message)->withInput();;
            }
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$personalToken}",
                ),
            ));
            // Send the request with warnings supressed
            $response = curl_exec($ch);
            // Handle connection errors (such as an API outage)
            if (curl_errno($ch) > 0) {
                //throw new Exception("Error connecting to API: " . curl_error($ch));
                $message = __("Error connecting to API !");
                return back()->withErrors($message)->withInput();;
            }
            // If we reach this point in the code, we have a proper response!
            // Let's get the response code to check if the purchase code was found
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // HTTP 404 indicates that the purchase code doesn't exist
            if ($responseCode === 404) {
                //throw new Exception("The purchase code was invalid");
                $message = __("Purchase Code is invalid");
                return back()->withErrors($message)->withInput();;
            }
            // Anything other than HTTP 200 indicates a request or API error
            // In this case, you should again ask the user to try again later
            if ($responseCode !== 200) {
                //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
                
                $message = __("Failed to validate code.");
                return back()->withErrors($message)->withInput();;
            }
            // Parse the response into an object with warnings supressed
            $body = json_decode($response);
            // Check for errors while decoding the response (PHP 5.3+)
            if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
                //new Exception("Error parsing response");
                $message = __("Can't Verify Now.");
                return back()->withErrors($message)->withInput();
            }
            if($body->item->id == '28944416' || $body->item->id == '34807246'){


                return $this->keysupdate($request);
               

                Session::flash('success', 'Keys Updated successfully');
                return back()->withInput();
            }else{


                $message = __("Please enter eClass App purchase code.");
                

                Session::flash('success', $message);
                return back()->withInput();
            }
        

          


        }



        
    }






    public function keysupdate(Request $request)
    {
        if(config('app.demolock') == 0){
            $row = DB::table('api_keys')->where('user_id', '=', Auth::user()->id)->first();
            if ($row) {


                $key = DB::table('api_keys')
                  ->where('id', Auth::user()->id)
                  ->update(['secret_key' => (string) Str::uuid()]);

                Session::flash('success', 'Key is re-generated successfully !');
                return back();

            } else {


                $key = DB::table('api_keys')->insert([
                    'secret_key' => (string) Str::uuid(),
                    'user_id' => Auth::user()->id,
                ]);
                if ($key) {
                   
                    Session::flash('success', 'Key is generated successfully !');
                    return back();
                }
            }
        }
        return back()->with('delete','You can\'t update key in Demo');
    }
}
