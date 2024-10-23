@extends('coach-services.master') 

{{-- @extends('layouts.app') --}}
@section('title', 'Cart')
<style>
    .card-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #dee2e6;
        padding: 15px;
        font-weight: bold;
        text-align: center;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-body {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .btn-block {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-block:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .default-form-control {
        border-radius: 8px !important;
        border: 1px solid #ced4da !important;
        padding: 5px 10px !important;
        font-size: 14px !important;
        width: 60px !important;
        text-align: center !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
        appearance: none !important; 
        outline: none !important;
    }

    .default-form-control:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #dee2e6;
        padding: 10px 0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-info {
    width: 60%;
    }
    .item-info p {
        margin: 0;
    }
    #servicebtn{
        width: 100%;
    }
    #cartdetail{
        height: 100%;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Custom spinner buttons */
    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group .quantity-btn {
        background-color: #343a40;
        color: #fff;
        border: none;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 16px;
        border-radius: 50%;
    }

    .input-group .quantity-btn:hover {
        background-color: #007bff;
    }
</style>

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Your Cart</h2>

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">
                Your cart is currently empty.
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <div class="card" id="cartdetail">
                        <div class="card-header">
                            <h4>Cart Items</h4>
                        </div>
                        <div class="card-body">
                          
                            @foreach ($cartItems as $item)
                                <div class="cart-item">
                                    <div class="item-info">
                                        <p><strong>Service Name:</strong> {{ $item->name }}</p>
                                        <p><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <form action="{{ route('cart.update') }}" method="POST" class="update-cart-form ml-5">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <input type="number" name="quantity" value="1" min="1" class="form-control default-form-control" readonly>
                                    </form>                                    
                                    
                                    <form action="{{ route('cart.remove') }}" method="POST" class="remove-cart-form" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" id="cartdetail">
                        <div class="card-header">
                            <h4>Summary</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Total Quantity:</strong> {{ $cartCount }}</p>
                            <p><strong>Total Price:</strong> ${{ number_format($cartTotal, 2) }}</p>
                            @if (Auth::check())
                            <a href="{{ route('checkout.show') }}" class="btn btn-primary btn-block">Proceed to Checkout</a>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">Proceed to Checkout</a>
                            @endif
                            <div class="mt-4">
                                <a href="{{ route('CoachServices.show') }}" id="servicebtn" class="btn btn-secondary">Add More Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- <div class="mt-4">
            <a href="{{ route('CoachServices.show') }}" class="btn btn-secondary">Add More Services</a>
        </div> --}}
    </div>
@endsection
