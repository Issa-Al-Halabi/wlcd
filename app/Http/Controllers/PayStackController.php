<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
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

class PayStackController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $ex){
            
            \Session::flash('delete', $ex->getMessage());
            return redirect('all/cart');
            
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();


        $paymentdata = $paymentDetails['data'];
       

        if($paymentDetails['status'] == 'true') {

            $txn_id = $paymentdata['reference'];

            $payment_method = 'Paystack';

            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method);

		}

		\Session::flash('delete', trans('flash.PaymentFailed'));
		    return redirect('/');
    }
}
