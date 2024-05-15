<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flashsale;
use App\FlashSaleItem;

class FlashDealsController extends Controller
{
    public function dealshow()
    {
    	$deals = Flashsale::where('status', 1)->get();

    	return view('front.flashdeal.deals', compact('deals'));
    }

    public function dealitems(Request $request, $id)
    {
    	$deal = Flashsale::where('id', $id)->first();

    	$items = FlashSaleItem::where('sale_id', $id)->get();
    	return view('front.flashdeal.viewdeal', compact('deal', 'items'));
    }
}
