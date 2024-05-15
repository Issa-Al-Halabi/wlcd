<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Cart;
use Auth;
use Braintree;
use Session;

class CheckoutController extends Controller
{
    public function checkoutpage(Request $request)
    {
        $course = Course::all();
        if(auth::check())
        {
            $carts = Cart::where('user_id',Auth::User()->id)->get();
        }
        else
        {
            $carts = session()->get('cart.add_to_cart');
            $carts = array_unique($carts);
        }
        

        $price_total = session()->get('price_total');
        $offer_total = session()->get('offer_total');
        $offer_percent = session()->get('offer_percent');
        $cart_total = session()->get('cart_total');


        if(Session::get('one_order_course') !== null)
        {
            session()->forget('one_order_course');
        }

        if(Session::get('one_order_user') !== null)
        {
            session()->forget('one_order_user');
        }


        return view('front.checkout',compact('course', 'carts','price_total','offer_total', 'offer_percent', 'cart_total'));
    }
}
