<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();
        $orders = Orders::with(['buyer:id,name', 'items.product'])
            ->whereHas('items.product', function ($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->latest()
            ->get();
        return view("seller.sales_record", compact("orders"));
    }
}