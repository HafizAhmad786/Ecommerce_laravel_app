<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        $products = Product::all();
        if (Auth::user()->role == "buyer") {
            return view('buyer.dashboard', compact('products'));
        }
        return view('seller.dashboard', compact('products'));
    }


    public function createProduct(Request $request)
    {

        $validated = $request->validate([
            "product_name" => "required|string",
            "product_price" => "required|numeric",
            "quantity" => "required|integer",
        ]);

        $data = [
            "product_name" => $validated['product_name'],
            "product_price" => $validated['product_price'],
            "quantity" => $validated['quantity'],
            "user_id" => Auth::user()->id,
        ];

        if ($request->hasFile('image')) {
            $request->image->store('images', "public");
            $data["product_image"] = $request->image->hashName();
        }

        Product::create($data);
        return redirect()->route("sellerdashboard");
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
        ]);

        $data = [
            "product_name" => $validated['product_name'],
            "product_price" => $validated['product_price'],
            "quantity" => $validated['quantity'],
        ];

        if ($request->hasFile('image')) {
            $request->image->store('images', "public");
            $data["product_image"] = $request->image->hashName();
        }

        Product::where('id', $request->product_id)->update($data);
        return redirect()->route("sellerdashboard");
    }

    public function deleteProduct(int $id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route("sellerdashboard");
    }
}