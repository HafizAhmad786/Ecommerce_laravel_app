<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentServices;
use App\Models\Orders;
use App\Models\OrderItem;
use Exception;

class CartController extends Controller
{
    protected $paymentServices;

    public function __construct(PaymentServices $paymentServices)
    {
        $this->paymentServices = $paymentServices;
    }

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
        try {
            $result = $this->paymentServices->pay($request->price, $request->stripeToken);
           $order = Orders::create([
                "buyer_id" => Auth::user()->id,
                "total_price" => $request->price,
                "status" => $result->status,
                "payment_id" => $result->id,
                "url" => $result->receipt_url
            ]);

            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => 1,
                "quantity" => 2,
                "price" => 10,
                "total_price" => 100
            ]);
            
            return response()->json([
                "status" => true,
                "message" => "Payment successful",
                "data" => $result->id
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}