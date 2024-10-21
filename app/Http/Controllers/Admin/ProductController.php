<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function show(Product $product)
    {
        $product = Product::where('id', $product->id)->with('category', 'images')->first();
        return response()->json([
            'product' => $product,
        ]);
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:3'],
            'price' => ['required'],
            'description' => ['nullable'],
            'category_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $product = Product::create([
            'name' => request('name'),
            'price' => request('price'),
            'description' => request('description'),
            'category_id' => request('category_id'),
        ]);
        return response()->json([
            'message' => 'product created successful.',
            'product' => $product
        ]);
    }
    public function update(Product $product)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:3'],
            'price' => ['required'],
            'quantity' => ['required'],
            'description' => ['nullable'],
            'category_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $product->update([
            'name' => request('name'),
            'price' => request('price'),
            'quantity' => request('quantity'),
            'description' => request('description'),
            'category_id' => request('category_id'),
        ]);
        return response()->json([
            'message' => 'product update successful.',
            'product' => $product
        ]);
    }
    public function delete(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'product delete successful'
        ]);
    }

    public function imageUpdate(Product $product)
    {
        $validator = Validator::make(request()->all(), [
            'images' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $uploadedFiles = request('images');
        $imagesUrl = [];
        if (gettype($uploadedFiles) == 'array') {
            foreach ($uploadedFiles as $file) {

                if (gettype($file) == 'string') {
                    $imagesUrl[] = $file;
                } else {
                    $path = $file->store('public');
                    $imagesUrl[] = $path;
                }
            }
        } else {
            $path = $uploadedFiles->store('public');
            $imagesUrl[] = $path;
        }

        if (count($imagesUrl) > 1) {
            $product->images()->delete();
        }

        foreach ($imagesUrl as $url) {
            Image::create([
                'url' => $url,
                'product_id' => $product->id
            ]);
        }
        return response()->json([
            'message' => 'product updated success.'
        ]);
    }
}
