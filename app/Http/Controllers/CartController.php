<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = $user->carts()->with('product')->get()->pluck('product');
        return view('cart', compact("carts"));
    }

    public function getCartProducts()
    {
        $counter = Auth::user()->carts()->count();
        return response()->json([
            'counter' => $counter
        ]);
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            "product_id" => "required|string"
        ]);

        if (!Auth::user()->carts()->where("product_id", $validated['product_id'])->exists()) {
            Cart::create([
                "user_id" => Auth::user()->id,
                "product_id" => $validated['product_id'],
            ]);

            return response()->json([
                "status" => true
            ]);
        }
    }

    public function makePayment(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe.secret'));
        $stripe->charges->create([
            'amount' => $request->price * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment from customer',
        ]);

        return redirect('dashboard')->withSuccess("Payment successful");
    }
}
