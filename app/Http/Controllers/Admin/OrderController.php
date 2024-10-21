<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $products = Order::with('user')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function show(Order $order)
    {
        $order = Order::where('id', $order->id)->with('products')->first();
        return response()->json([
            'order' => $order,
        ]);
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'total_amount' => ['required'],
            'shipping_address' => ['nullable'],
            'notes' => ['nullable'],
            'screen_shot' => ['nullable'],
            'order_products' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        if (request('screen_shot')) {
            $path = request('screen_shot')->store('public');
        }

        $order = Order::create([
            'status' => 'pending',
            'total_amount' => request('total_amount'),
            'address' => request('shipping_address') ?? request()->user()->address,
            'notes' => request('notes'),
            'screen_shot' => $path ?? null,
            'user_id' => request()->user()->id
        ]);

        foreach (request('order_products') as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity']
            ]);
        }

        return response()->json([
            'message' => 'product create successful.',
            'product' => $order
        ]);
    }
    public function update(Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        if ($order->status == 'confirmed') {
            return response()->json([
                'message' => 'Your order is already confirmed'
            ]);
        }

        $order->update([
            'status' => request('status'),
        ]);

        return response()->json([
            'message' => 'order update successful.',
            'product' => $order
        ]);
    }
    public function delete(Order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'order delete successful'
        ]);
    }
}
