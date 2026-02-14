<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the customer's account dashboard.
     */
    public function dashboard()
    {
        return view('account.dashboard');
    }

    /**
     * Display a list of the customer's orders.
     */
    public function orders()
    {
        // Fetch only orders belonging to the logged-in user
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        return view('account.orders', compact('orders'));
    }

    /**
     * Display the details of a specific order.
     */
    public function showOrder($id)
    {
        // SECURE: Fetch order ONLY if it belongs to the authenticated user.
        // If it doesn't exist for this user, it returns 404.
        $order = Auth::user()->orders()->with('items.product')->findOrFail($id);

        return view('account.order_show', compact('order'));
    }

    /**
     * Cancel a specific order.
     */
    public function cancelOrder($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);

        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->back()->with('success', 'Order cancelled successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Order cannot be cancelled.']);
    }
}
