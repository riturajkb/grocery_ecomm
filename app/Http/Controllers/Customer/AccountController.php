<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function dashboard()
    {
        return view('account.dashboard');
    }

    /**
     * Display the user's orders.
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('account.orders', compact('orders'));
    }

    /**
     * Display single order details.
     */
    public function orderShow($id)
    {
        $order = Auth::user()->orders()->with('items.product')->findOrFail($id);
        return view('account.order_show', compact('order'));
    }

    /**
     * Cancel the order if it is in pending state.
     */
    public function cancelOrder($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);

        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->back()->with('success', 'Order cancelled successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'This order cannot be cancelled anymore.']);
    }
}
