<?php

namespace App\Http\Controllers\Api;

use Stripe\StripeClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentServices;
use App\Models\{
    Orders,
    OrderItem,
    Product
};
use Illuminate\Support\Facades\DB;
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
        $products = $this->fetchUserProducts();
        return response()->json([
            "status" => true,
            "cartProducts" => $products
        ]);
    }

    public function fetchUserProducts()
    {
        $user = Auth::user();
        $products = $user->carts()->with('products')->get()->pluck("products")->filter(); //filter for null safety
        return $products;
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
                "status" => true,
                "message" => "Product added successfully"
            ]);
        }
    }

    public function initializePayment(Request $request)
    {
        $products = $this->fetchUserProducts();

        if ($products->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Cart is empty"
            ], 400);
        }
        $totalPrice = 0;

        $quantitiesMap = $request->input('quantities', []);

        foreach ($products as  $product) {
            $quantity = $quantitiesMap[$product->id] ?? 1;
            $totalPrice += ($product->product_price * $quantity);
        }

        try {
            $intent = $this->paymentServices->pay($totalPrice);
            return response()->json([
                "status" => true,
                "client_secret" => $intent->client_secret,
                "payment_intent_id" => $intent->id
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function makePayment(Request $request)
    {

        $request->validate([
            'payment_intent_id' => 'required|string',
            'quantity' => 'required|array'
        ]);

        $products = $this->fetchUserProducts();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $intent = $this->paymentServices->retrievePaymentIntent($request->payment_intent_id);
            
            $order = Orders::create([
                "buyer_id" => Auth::user()->id,
                "total_price" => $intent->amount / 100,
                "status" => $intent->status,
                "payment_id" => $intent->id,
                "url" => $intent->recepit_url ?? ""
            ]);

            $quantitiesMap = $request->input('quantity', []);

            foreach ($products as $product) {
                $qty = $quantitiesMap[$product->id] ?? 1;

                OrderItem::create([
                    "order_id" => $order->id,
                    "product_id" => $product->id,
                    "quantity" => $qty,
                    "unit_price" => $product->product_price,
                    "total_price" => $product->product_price * $qty
                ]);

                Cart::where("product_id", $product->id) ->delete();
            }
            DB::commit();
            return response()->json([
                "status" => true,
                "message" => "Payment successful",
                "data" => $intent->id
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
