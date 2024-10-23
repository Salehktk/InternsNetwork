@extends('coach-services.master')

@section('title', 'Services')

@section('content')
@php

// Convert paginator items to array
$servicesArray = $uniquePaginator->items();
// Determine the maximum length of the arrays to iterate correctly
$max_length = max(array_map('count', $servicesArray));
@endphp

    <!-- Content specific to the coach services page goes here -->
    <div class="container">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="start-div text-center">
                <h1>Services</h1>


                <!-- Dropdown Filters -->
                <div class="container filter-section mt-4">
                    <div class="row">
                        {{-- <div class="col-12 text-start mb-3">
                            <h5 class="fw-bolder">Filters</h5>
                        </div> --}}
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="subscriberLevelFilter" class="form-label fw-bold">Filter by Subscriber Level</label>
                                    <select id="subscriberLevelFilter" class="form-select">
                                        <option value="">Subscriber Levels</option>
                                        @foreach ($subscriberLevels as $level)
                                            <option value="{{ $level }}">{{ $level }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <label for="serviceTypeFilter" class="form-label fw-bold">Filter by Service Type</label>
                                    <select id="serviceTypeFilter" class="form-select">
                                        <option value="">Service Types</option>
                                        @foreach ($serviceTypes as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="servicecurrencyFilter" class="form-label fw-bold">Filter by Currency</label>
                                    <select id="servicecurrencyFilter" class="form-select">
                                        <option value="">Service Currency</option>
                                        
                                            <option value="">$</option>
                                            <option value="">€</option>
                                       
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="servicePriceFilter" class="form-label fw-bold">Filter by Service Prices</label>
                                    <select id="servicePriceFilter" class="form-select">
                                        <option value="">Service Prices</option>
                                        @foreach ($servicePrices as $price)
                                            <option value="{{ $price }}">{{ $price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="servicesContainer">
                    @include('partials.services', ['uniquePaginator' => $uniquePaginator])
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    function updateCartCount() {
        $.ajax({
            url: "{{ route('cart.count') }}",
            method: 'GET',
            success: function(response) {
                $('#cart-count').text(response.count);
            }
        });
    }

    // Call function on page load
    updateCartCount();
});
</script>