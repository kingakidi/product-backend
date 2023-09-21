<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function show(Request $request, Product $product)
    {
        // You can add logic to retrieve and return a specific product by ID here if needed.
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required',
            'product_name' => 'required|unique:products', // Ensure product_name is unique
            'manufacturer' => 'required',
            'barcode' => 'required',
            'quantity' => 'required|numeric', // Add numeric validation for quantity
            'price' => 'required|numeric', // Add numeric validation for price
            'manufacturing_date' => 'required',
            'expiry_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 422);
        }

        $product = new Product($request->all());

        if ($product->save()) {
            return response()->json(['status' => 'success', 'message' => 'Product added']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product was not added']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required',
            'product_name' => 'required|unique:products,product_name,' . $id, // Ensure product_name is unique, except for the current product
            'manufacturer' => 'required',
            'barcode' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'manufacturing_date' => 'required',
            'expiry_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], 422);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        $product->fill($request->all());

        if ($product->save()) {
            return response()->json(['status' => 'success', 'message' => 'Product updated']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product was not updated']);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        if ($product->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Product deleted']);
        }

        return response()->json(['status' => 'error', 'message' => 'Product was not deleted']);
    }
}
