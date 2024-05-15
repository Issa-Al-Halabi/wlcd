<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankTransfer;
use App\Order;
use Redirect, Response;
use App\Cart;
use Auth;
use DB;
use App\Currency;
use Session;
use App\Wishlist;
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
use Spatie\Permission\Models\Role;

class BankTransferController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:payment-setting-bank-details.manage', ['only' => ['show', 'update']]);
    }
    public function banktransfer(Request $request)
    {


        if ($file = $request->file('proof')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $name = str_replace(" ", "_", $name);
            $file->move('images/order', $name);
            $input['proof'] = $name;
        }


        $txn_id = str_random(32);

        $payment_method = 'BankTransfer';

        $file = $name;

        $payment_status = '0';

        $checkout = new OrderStoreController;

        return $checkout->orderstore($txn_id, $payment_method, NULL, $file, $payment_status);
    }

    public function show()
    {
        $show = BankTransfer::first();
        return view('admin.bank_transfer.edit', compact('show'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_holder_name' => 'required',
        ]);

        $data = BankTransfer::first();
        $input = $request->all();

        if (isset($data)) {
            if (isset($request->bank_enable)) {
                $input['bank_enable'] = 1;
            } else {
                $input['bank_enable'] = 0;
            }


            $data->update($input);
        } else {

            if ($request->bank_enable == 'on') {
                $input['bank_enable'] = '1';
            } else {
                $input['bank_enable'] = '0';
            }


            $data = BankTransfer::create($input);

            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }
}
