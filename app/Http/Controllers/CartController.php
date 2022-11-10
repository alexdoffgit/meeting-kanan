<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function indexCart1(Request $request)
    {
        $cart = new Cart();

        $userId = (!empty(auth()->user())) ? auth()->user()->id : null;

        return view('cart1', ['carts' => $cart->cartData($userId)]);
    }

    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        $textDates = $request->input('dates');
        $from = $request->input('from');
        $to = $request->input('to');
        $guest = intval($request->input('guest'));

        $startDay = new Carbon(explode(" > ", $textDates)[0]);
        $endDay = new Carbon(explode(" > ", $textDates)[1]);
        $startTime = new Carbon($from);
        $endTime = new Carbon($to);

        $cart = new Cart();
        $cart->room_id = $id;
        $cart->user_id = auth()->user()->id;
        $cart->booking_day_start = $startDay;
        $cart->booking_day_end = $endDay;
        $cart->booking_time_start = $startTime;
        $cart->booking_time_end = $endTime;
        $cart->attendant = $guest;
        $cart->save();

        return redirect("/cart1");
    }

    public function deleteCartItem(Request $request, $id)
    {
        $cart = Cart::find(intval($id));

        $cart->delete();

        return redirect('/cart1');
    }

    public function indexCart2(Request $request)
    {
        return view('cart2');
    }

    public function indexCart3(Request $request)
    {
        return view('cart3');
    }
}