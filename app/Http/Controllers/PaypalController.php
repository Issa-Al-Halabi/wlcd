<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;

/** All Paypal Details class **/
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Crypt;
use Illuminate\Support\Facades\Input;
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
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class PaypalController extends Controller
{
    public function __construct()
    {
		/** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
	}

	public function payWithpaypal(Request $request)
    {

    	$currency = Currency::where('default', '=', '1')->first();
    	$gsettings = Setting::first();
    	$currency_code = strtoupper($currency->code);

    	$pay = Crypt::decrypt($request->amount);
    	Session::put('payment',$pay);
		$payer = new Payer();
		        $payer->setPaymentMethod('paypal');
		$item_1 = new Item();
		$item_1->setName('Item 1') /** item name **/
		            ->setCurrency($currency_code)
		            ->setQuantity(1)
		            ->setPrice($pay); /** unit price **/
		$item_list = new ItemList();
		        $item_list->setItems(array($item_1));
		$amount = new Amount();
		        $amount->setCurrency($currency_code)
		            ->setTotal($pay);
		$transaction = new Transaction();
		        $transaction->setAmount($amount)
		            ->setItemList($item_list)
		            ->setDescription('Your transaction description');
		$redirect_urls = new RedirectUrls();
		        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
		            ->setCancelUrl(URL::route('status'));
		$payment = new Payment();
		        $payment->setIntent('Sale')
		            ->setPayer($payer)
		            ->setRedirectUrls($redirect_urls)
		            ->setTransactions(array($transaction));
		        
		try {
			$payment->create($this->_api_context);
		} 
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			if (\Config::get('app.debug')) {
				\Session::flash('delete', $ex->getMessage());
				return redirect('/');
			} else {
				\Session::flash('delete', $ex->getMessage());
				return redirect('/');
			}
		}

		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
			    break;
			}
		}
		/** add payment ID to session **/
		Session::put('paypal_payment_id', $payment->getId());
		if (isset($redirect_url)) {
		/** redirect to paypal **/
		    return Redirect::away($redirect_url);
		}

		\Session::put('error', 'Unknown error occurred');
		        return redirect('/');
	}

	public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $amount = Session::get('payment');
		/** clear the session payment ID **/
		        Session::forget('paypal_payment_id');
		        if (empty($request->get('PayerID')) || empty($request->get('token')))

		         {
		\Session::flash('delete', trans('flash.PaymentFailed'));
		            return Redirect('/');
		}
		 $payment = Payment::get($payment_id, $this->_api_context);
		    	$execution = new PaymentExecution();
		        $execution->setPayerId($request->get('PayerID'));
		/**Execute the payment **/
		    $result = $payment->execute($execution, $this->_api_context);



		if ($result->getState() == 'approved') {

			$transactions = $payment->getTransactions();
		    $relatedResources = $transactions[0]->getRelatedResources();
		    $sale = $relatedResources[0]->getSale();
		    $saleId = $sale->getId();


		    $txn_id = $payment_id;

            $payment_method = 'PayPal';

            $sale_id = $saleId;

            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method, $sale_id);

		     
		}
		\Session::flash('delete', trans('flash.PaymentFailed'));
		    return redirect('/');
	}
}
