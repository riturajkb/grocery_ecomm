@extends('admin.layout')

@section('content')
    <h1>Welcome to Admin Dashboard</h1>
    <p style="color: #6c757d; margin-bottom: 30px;">Manage your store from here.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <!-- Total Products Card -->
        <div class="card" style="border-left: 4px solid #007bff;">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px; font-size: 14px;">Total Products</p>
                        <h2 style="font-size: 2rem; margin: 0; color: #007bff;">{{ $totalProducts }}</h2>
                    </div>
                    <div style="font-size: 3rem; color: #007bff; opacity: 0.3;">📦</div>
                </div>
                <a href="{{ route('admin.products') }}"
                    style="display: block; margin-top: 15px; color: #007bff; text-decoration: none;">View Products →</a>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="card" style="border-left: 4px solid #28a745;">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px; font-size: 14px;">Total Orders</p>
                        <h2 style="font-size: 2rem; margin: 0; color: #28a745;">{{ $totalOrders }}</h2>
                    </div>
                    <div style="font-size: 3rem; color: #28a745; opacity: 0.3;">🛒</div>
                </div>
                <a href="{{ route('admin.orders') }}"
                    style="display: block; margin-top: 15px; color: #28a745; text-decoration: none;">View Orders →</a>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="card" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px; font-size: 14px;">Pending Orders</p>
                        <h2 style="font-size: 2rem; margin: 0; color: #ffc107;">{{ $pendingOrders }}</h2>
                    </div>
                    <div style="font-size: 3rem; color: #ffc107; opacity: 0.3;">⏳</div>
                </div>
                <a href="{{ route('admin.orders') }}"
                    style="display: block; margin-top: 15px; color: #ffc107; text-decoration: none;">Manage Pending →</a>
            </div>
        </div>
    </div>
@endsection