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

class OmiseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Omise Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | - Mediacity
    | 
    */

    public function pay(Request $request){

		require_once base_path().'/vendor/omise/omise-php/lib/Omise.php';

		define('OMISE_API_VERSION', env('OMISE_API_VERSION'));
		define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
		define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

		try{
			$charge = \OmiseCharge::create(array(
			  'amount' => $request->amount*100,
			  'currency' => 'thb',
			  'card' => $_POST["omiseToken"]
			));
		}catch(\Exception $ex){
			return redirect('/all/cart')->with('delete',$ex->getMessage());
		}

		

		if($charge['status'] == 'successful'){
			$txnid = $charge['id'];

            $txn_id = $txnid;

            $payment_method = 'Omise';

            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method);


		}else{
			return redirect('/all/cart')->with('delete',trans('flash.PaymentFailed'));
		}
    }
}
