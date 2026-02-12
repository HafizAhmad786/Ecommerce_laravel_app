<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{
    product,
    user
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        if (Auth::user()->role == "seller") {
            $userProducts = Auth::user()->products;
            return view('seller.dashboard', compact('userProducts'));
        } else {
            return view('buyer.dashboard', compact('products'));
        }
    }

    public function createProduct(Request $request)
    {

        $validated = $request->validate([
            "product_name" => "required|string",
            "product_price" => "required|numeric",
            "quantity" => "required|integer",
            "image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048"
        ]);

        $data = [
            "product_name" => $validated['product_name'],
            "product_price" => $validated['product_price'],
            "quantity" => $validated['quantity'],
            "user_id" => Auth::user()->id,
        ];

        if ($request->hasFile('image')) {
            $request->image->store('images', "public");
            $data["product_image"] = $validated['image']->hashName();
        }

        Product::create($data);
        return redirect()->route("dashboard");
    }

    public function getProductById(Request $request)
    {
        return Product::where('id', $request->id)->first();
    }

    public function updateProduct(Request $request)
    {
        $validated = $request->validate([
            "product_name" => "required|string",
            "product_price" => "required|numeric",
            "quantity" => "required|integer",
            "image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048"
        ]);

        $data = [
            "product_name" => $validated['product_name'],
            "product_price" => $validated['product_price'],
            "quantity" => $validated['quantity'],
        ];

        if ($request->hasFile('image')) {
            $request->image->store('images', "public");
            $data["product_image"] = $validated['image']->hashName();
        }

        Product::where('id', $request->product_id)->update($data);
        return redirect()->route("dashboard");
    }

    public function deleteProduct(int $id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route("dashboard");
    }
}