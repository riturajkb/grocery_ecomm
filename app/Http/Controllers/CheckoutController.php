<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('home')->with('error', 'Your cart is empty!');
        }

        // Load user's saved addresses
        $addresses = Auth::user()->addresses()->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('checkout.index', compact('cart', 'addresses', 'defaultAddress'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        // Get the selected address
        $savedAddress = Auth::user()->addresses()->findOrFail($request->address_id);

        // Build full address text
        $addressText = $savedAddress->address . ', ' . $savedAddress->city . ', ' . $savedAddress->state . ' - ' . $savedAddress->pincode;

        $cart = session()->get('cart');

        // Validate stock availability before placing order
        foreach ($cart as $id => $item) {
            $product = \App\Models\Product::find($id);
            if (!$product) {
                return redirect()->route('cart.index')->withErrors(['error' => 'Product not found: ' . $item['name']]);
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->withErrors(['error' => 'Insufficient stock for ' . $product->name . '. Available: ' . $product->stock]);
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->address_id = $request->address_id;
        $order->customer_name = $savedAddress->name;
        $order->address = $addressText;
        $order->phone = $savedAddress->phone;
        $order->total_price = $total;
        $order->status = 'pending';
        $order->payment_method = 'COD';
        $order->delivery_note = $request->delivery_note;
        $order->save();

        foreach ($cart as $id => $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $id;
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->save();

            // Reduce product stock
            $product = \App\Models\Product::find($id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        session()->forget('cart');

        return redirect()->route('checkout.success')->with('order_id', $order->id);
    }

    public function success()
    {
        if (!session('order_id')) {
            return redirect()->route('home');
        }
        return view('checkout.success');
    }
}
