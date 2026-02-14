@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1 class="display-4 text-success">Order Placed Successfully!</h1>
        <p class="lead">Thank you for shopping with Dipika Store.</p>
        <p>Your Order ID is: <strong>#{{ session('order_id') }}</strong></p>
        <hr>
        <p>
            <a href="{{ route('home') }}" class="btn btn-primary" role="button">Continue Shopping</a>
        </p>
    </div>
@endsection