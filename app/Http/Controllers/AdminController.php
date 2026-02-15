<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
            return back()->withErrors(['email' => 'You do not have admin access.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function products(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Product::distinct()->pluck('category')->toArray();
        $defaultCategories = ['vegetables', 'dairy', 'grains', 'fruits', 'beverages', 'snacks', 'other'];
        $categories = array_unique(array_merge($defaultCategories, $categories));
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $product = new Product();
        $product->name = $request->name;

        // Handle new category logic
        if ($request->category === 'new' && $request->new_category) {
            $product->category = $request->new_category;
        } else {
            $product->category = $request->category ?? 'other';
        }

        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Product::distinct()->pluck('category')->toArray();
        $defaultCategories = ['vegetables', 'dairy', 'grains', 'fruits', 'beverages', 'snacks', 'other'];
        $categories = array_unique(array_merge($defaultCategories, $categories));
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;

        // Handle new category logic
        if ($request->category === 'new' && $request->new_category) {
            $product->category = $request->new_category;
        } else {
            $product->category = $request->category;
        }

        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Order status updated');
    }

    public function generateInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
