<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    product,
    Product as ModelsProduct,
    user
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === "seller") {
            $products = Auth::user()->products;
        } else {
            $products = Product::all();
        }

        return response()->json([
            "status" => true,
            "products" => $products
        ]);
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
        return response()->json([
            "status" => true,
            "message" => "Product created successfully"
        ]);
    }

    public function getProductById($id)
    {
        // return Product::where('id', $id)->first();
        // return Product::where('id', $id)->first();
    }

    public function searchProducts(Request $request)
    {
        $validated = $request->validate([
            "product_name" => "required|string"
        ]);

        $name = $validated['product_name'];

        return response()->json([
            "status" => true,
            // "products" => Product::where("product_name", "LIKE", "%$name%")->get()
        ]);
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

        // Product::where('id', $request->product_id)->update($data);
        return response()->json([
            "status" => true,
            "message" => "Product updated successfully"
        ]);
    }

    public function deleteProduct(int $id)
    {
        // Product::where('id', $id)->delete();
        return response()->json([
            "status" => true,
            "message" => "Product deleted successfully"
        ]);
    }
}
