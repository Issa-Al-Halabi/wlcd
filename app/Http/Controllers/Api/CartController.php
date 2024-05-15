<?php

namespace App\Http\Controllers\Api;

use App\BundleCourse;
use App\Cart;
use App\Course;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    //
    public function addtocart(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
        ]);
        $auth = Auth::guard('api')->user();
        $courses = Course::where('id', $request->course_id)->first();
        if (!isset($courses)) {
            return response()->json('Invalid Course ID', 401);
        }
        $orders = Order::where('user_id', $auth->id)
            ->where('course_id', $request->course_id)
            ->first();
        $cart = Cart::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->first();

        if ($courses->type != 1) {
            return response()->json('Course is free', 401);
        }
        if ($courses->type == 1) {
            if (isset($orders)) {
                return response()->json('You Already purchased this course !', 401);
            }
            if (!empty($cart)) {
                return response()->json('Course is already in cart !', 401);
            } else {
                $cart = Cart::create([
                    'course_id' => $request->course_id,
                    'user_id' => $auth->id,
                    'category_id' => $courses->category_id,
                    'price' => $courses->price,
                    'offer_price' => $courses->discount_price,
                ]);

                return response()->json('Course is added to your cart !', 200);
            }
        }
    }

    public function removecart(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);
        $auth = Auth::guard('api')->user();

        $cart = Cart::where('course_id', $request->course_id)
            ->where('user_id', $auth->id)
            ->delete();

        if ($cart == 1) {
            return response()->json(['1'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    public function showcart(Request $request)
    {

        $user = Auth::guard('api')->user();
        $carts = Cart::where('user_id', $user->id)
            ->with('courses.user')
            ->with('bundle.user')
            ->get();

        $priceTotal = $carts->sum('price');
        $offerTotal = $carts->sum(function ($cart) {
            return $cart->offer_price != 0 ? $cart->offer_price : $cart->price;
        });
        $couponDiscount = $carts->sum('disamount');
        $cartTotal = $offerTotal - $couponDiscount;

        $offerAmount = $priceTotal - ($offerTotal - $couponDiscount);
        $offerPercent = $priceTotal != 0 ? ($offerAmount / $priceTotal) * 100 : 0;

        return response()->json([
            'cart' => $carts,
            'price_total' => $priceTotal,
            'offer_total' => $priceTotal - $offerTotal,
            'cpn_discount' => $couponDiscount,
            'offer_percent' => round($offerPercent, 2),
            'cart_total' => $cartTotal,
        ], 200);
    }

    public function removeallcart(Request $request)
    {

        $auth = Auth::guard('api')->user();

        $cart = Cart::where('user_id', $auth->id)->delete();

        if (isset($cart)) {
            return response()->json(['1'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }

    public function addbundletocart(Request $request)
    {
        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $auth = Auth::guard('api')->user();

        $bundle_course = BundleCourse::where('id', $request->bundle_id)->first();
        if (!$bundle_course) {
            return response()->json('Invalid Bundle Course ID!', 401);
        }
        if ($bundle_course->type != 1) {
            return response()->json('Bundle course is free!', 401);
        }
        $orders = Order::where('user_id', $auth->id)
            ->where('bundle_id', $request->bundle_id)
            ->first();
        if (isset($orders)) {
            return response()->json('You Already purchased this course !', 401);
        }
        $cart = Cart::where('bundle_id', $request->bundle_id)
            ->where('user_id', $auth->id)
            ->first();

        if ($cart) {
            return response()->json('Bundle Course is already in cart!', 401);
        }
        Cart::create([
            'bundle_id' => $request->bundle_id,
            'user_id' => $auth->id,
            'type' => '1',
            'price' => $bundle_course->price,
            'offer_price' => $bundle_course->discount_price,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return response()->json('Bundle Course is added to your cart!', 200);
    }

    public function removebundlecart(Request $request)
    {
        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $auth = Auth::guard('api')->user();

        $cart = Cart::where('bundle_id', $request->bundle_id)
            ->where('user_id', $auth->id)
            ->delete();

        if ($cart == 1) {
            return response()->json(['1'], 200);
        } else {
            return response()->json(['error'], 401);
        }
    }
}
