@extends('coach-services.master')

@section('title', 'Single Services')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<style>
    .checkout-header {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }

    .checkout-container {
        margin-top: 30px;
    }

    .form-group label {
        font-weight: bold;
    }

    .order-summary {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #f4623a;
        border-color: #f4623a;
    }

    .btn-primary:hover {
        background-color: #e04801;
        border-color: #e04801;
    }
    .style-form-control{
        box-shadow: none !important;
    }
    .col-md-8{
        background-color: #f8f9fa;
    }
    #order-summary{
    height: 100%;
    }
</style>
@section('content')

    <div class="container checkout-container mb-5">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Billing Information Section -->
                <div class="col-md-8" >
                    <div class="checkout-header">
                        <h4>Billing Information</h4>
                    </div>

                   

                    <div class="row">
                        {{-- <div class="col-md-6">
                           
                        </div> --}}

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name"> Name</label>
                                <input type="text" name="name" id="name" class="form-control style-form-control" value="{{ $user ? $user->name : old('name') }}" readonly  required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control style-form-control" value="{{ $user ? $user->email : old('email') }}" readonly  required>
                    </div>

                    <div class="form-group">
                        
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control style-form-control" value="{{ $user ? $user->phone : old('phone') }}" required>
                        
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user ? $user->id : '' }}">


                </div>

                <!-- Order Summary Section -->
                <div class="col-md-4">
                    <div class="order-summary" id="order-summary">
                        <h4>Order Summary</h4>
                        <ul class="list-group">
                            @foreach ($cartItems as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->name }} ({{ $item->quantity }})
                                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                                <input type="hidden" name="cart_items[{{ $item->id }}][name]" value="{{ $item->name }}">
                            @endforeach
                        </ul>
                        <div class="mt-3 d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>${{ number_format($cartTotal, 2) }}</strong>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">
                            <i class="fas fa-dollar-sign"></i> Complete Purchase
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
