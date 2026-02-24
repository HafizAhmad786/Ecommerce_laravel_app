<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Orders,
    OrderItem
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        if (Auth::user()->role == "seller") {
            $orders = Orders::with(['items:id,order_id,product_id', 'items.product:id,user_id'])
                ->whereHas('items.product', function ($q) use ($sellerId) {
                    $q->where('user_id', $sellerId);
                });
        } else {
            $orders = Orders::with(['items:id,order_id,product_id', 'items.product:id,user_id'])
                ->where("buyer_id", $sellerId);
        }

        $orders = $orders->latest()->get();

        return view("seller.sales_record", compact("orders"));
    }

    public function getOrderProducts(Request $request)
    {
        $validated = $request->validate([
            "order_id" => "required|string"
        ]);

        $items = OrderItem::select([
            'id',
            'order_id',
            'quantity',
            'product_id'
        ])->with('product')
            ->where('order_id', $validated['order_id'])->get();

        if (!$items) {
            return response()->json([
                "status" => false,
                "message" => "Order not found"
            ], 404);
        }

        return response()->json([
            "status" => true,
            "products" => $items
        ]);
    }
}
