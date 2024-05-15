<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App\Cart;
use App\Wishlist;
use App\Order;
use App\Currency;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use Session;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class InstaMojoController extends Controller
{
    public function index()
   	{
        return view('pages.checkout.show');
   	}

	public function pay(Request $request){
	 
	     $api = new \Instamojo\Instamojo(
	            config('services.instamojo.api_key'),
	            config('services.instamojo.auth_token'),
	            config('services.instamojo.url')
	        );

	    $appurl = env('APP_URL');
	    $appname = env('APP_NAME');


	 
	    try {
	         $response = $api->paymentRequestCreate(array(
	            "purpose" => $appname,
	            "amount" => $request->amount,
	            "buyer_name" => $request->name,
	            "send_email" => true,
	            "send_sms" => true,
	            "email" => $request->email,
	            "phone" => $request->mobile_number,
	            "redirect_url" => url('pay-success')
	            ));
	             
	            header('Location: ' . $response['longurl']);
	            exit();
	            
	    } catch (\Exception $e) {
	      
	        \Session::flash('delete', $e->getMessage());
            return redirect('all/cart');
	    }
	}
	 
	public function success(Request $request){
		
	    try {
	 
	        $api = new \Instamojo\Instamojo(
	            config('services.instamojo.api_key'),
	            config('services.instamojo.auth_token'),
	            config('services.instamojo.url')
	        );
	 
	         $response = $api->paymentRequestStatus(request('payment_request_id'));
	 
	        if( !isset($response['payments'][0]['status']) ) {
	           	
	           	\Session::flash('delete', trans('flash.PaymentFailed'));
		    	return redirect('/');

	        } else if($response['payments'][0]['status'] != 'Credit') {
	            
	            \Session::flash('delete', trans('flash.PaymentFailed'));
		    	return redirect('/');
	        } 
	        
	      	}catch (\Exception $e) {
	        	\Session::flash('delete', trans('flash.PaymentFailed'));
		    	return redirect('/');

	    }

	    $txn_id = $request->payment_id;

        $payment_method = 'Instamojo';

        $checkout = new OrderStoreController;

        return $checkout->orderstore($txn_id, $payment_method);


	}

}
