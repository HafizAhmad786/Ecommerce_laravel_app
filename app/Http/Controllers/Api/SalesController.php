<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Orders,
    OrderItem
};
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        if (Auth::user()->role == "seller") {
            $orders = Orders::whereHas('items.product', function ($q) use ($sellerId) {
                    $q->where('user_id', $sellerId);
                });
        } else {
            $orders = Orders::where("buyer_id", $sellerId);
        }

        $orders = $orders->latest()->get();

        return response()->json([
            "status" => true,
            "orders" => $orders
        ]);
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
                "message" => "Orders not found"
            ], 404);
        }

        return response()->json([
            "status" => true,
            "products" => $items
        ]);
    }
}
