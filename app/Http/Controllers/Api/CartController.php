<?php

namespace App\Http\Controllers\Api;

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

    public function makePayment(Request $request)
    {

        $products = $this->fetchUserProducts();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $result = $this->paymentServices->pay($request->price, $request->stripeToken);

            $order = Orders::create([
                "buyer_id" => Auth::user()->id,
                "total_price" => $request->price,
                "status" => $result->status,
                "payment_id" => $result->id,
                "url" => $result->receipt_url
            ]);

            for ($i = 0; $i < count($products); $i++) {
                OrderItem::create([
                    "order_id" => $order->id,
                    "product_id" => $products[$i]->id,
                    "quantity" => $request->quantity[$i],
                    "unit_price" => $products[$i]->product_price,
                    "total_price" => $products[$i]->product_price * $request->quantity[$i]
                ]);
                Cart::where("product_id", $products[$i]->id)->delete();
            }
            DB::commit();
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
