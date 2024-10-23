@extends('coach-services.master')

@section('title', 'Single Services')


<style>
    .image-container .service-image {
        border-radius: 10px;
        height: auto !important;
        max-width: auto !important;
        object-fit: cover;
    }

    .no-image {
        background: #f1f1f1;
        color: #666;
        padding: 20px;
        text-align: center;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-title {
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .card-body p {
        font-size: 1.2rem;
    }

    .btnAddCart {
        background-color: #f4623a;
        /* Primary color */
        color: #fff;
        /* Text color */
        border: none;
        /* Remove default border */
        border-radius: 5px;
        /* Rounded corners */
        padding: 12px 24px;
        /* Add space inside the button */
        font-size: 16px;
        /* Font size */
        font-weight: 600;
        /* Font weight */
        text-transform: uppercase;
        /* Uppercase text */
        cursor: pointer;
        /* Pointer cursor on hover */
        transition: all 0.3s ease;
        /* Smooth transition */
        display: inline-block;
        /* Ensure button fits content */
        text-align: center;
        /* Center text */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }

    .btnAddCart:hover {
        background-color: #f4623a;
        /* Darker background on hover */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        /* Enhanced shadow on hover */
    }

    .btnAddCart:active {
        background-color: #004085;
        /* Even darker background when clicked */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        /* Inset shadow */
        transform: translateY(2px);
        /* Slightly move the button down on click */
    }

    .btnAddCart:disabled {
        background-color: #c0c0c0;
        /* Grey background when disabled */
        color: #6c757d;
        /* Grey text when disabled */
        cursor: not-allowed;
        /* Not-allowed cursor */
        box-shadow: none;
        /* Remove shadow when disabled */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 15px 30px;

    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .service-description {
        display: flex;
        align-items: center;
    }

    .service-description .image-container {
        flex: 1;
        padding: 10px;
    }

    .service-description .details-container {
        flex: 1;
        padding: 10px;
    }

    .service-description img {
        width: 100%;
        height: auto;
    }
</style>

@section('content')

    @php
        // $serviceId = $service[6] ?? ''; // Adjust index for service ID if necessary
        $imageUrl = $service[5] ?? '';
        $Serviceprice = $service[3] ?? '';
        $ServiceId = $service['id'] ?? '';

    @endphp


    <div class="container my-5">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">
                <div class="service-description">
                    <div class="image-container">
                        @if ($service[5])
                            <img src="{{ $service[5] }}" alt="Service Image" class="img-fluid service-image">
                        @else
                            <div class="no-image">No image available</div>
                        @endif
                    </div>
                    <div class="details-container">
                        <h1 class="card-title">{{ $service[0] }}</h1>
                        <p>{{ $service[4] }}</p>
                        <p><strong>Price:</strong> ${{ $service[3] }}</p>
                        <p><strong>Subscriber Level:</strong> {{ $service[1] }}</p>
                        <p><strong>Type:</strong> {{ $service[2] }}</p>
                        <button type="button"
                            onclick="addToCart({{ $Serviceprice }}, {{ $ServiceId }}, '{{ $service[0] }}')"
                            class="btnAddCart">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection()

<!-- Optional: Link to JavaScript files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    function addToCart(servicePrice, serviceId, serviceName) {

        // Show loader
        $('#loader').show();

        // Send AJAX request
        $.ajax({
            url: "{{ route('add-to-cart') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                servicePrice: servicePrice,
                serviceId: serviceId,
                serviceName: serviceName || ''
            },
            success: function(response) {
                // Update cart count
                $('#cart-count').text(response.cartCount);
                $('#cart-total').text(response.cartTotal.toFixed(2));
                // Hide loader
                $('#loader').hide();
                window.location.href = "{{ route('view-cart') }}"; // Adjust the route name as needed

            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', error);

                // Hide loader
                $('#loader').hide();
            }

        });
    }


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

        updateCartCount();
    });


    ////update  cart
    $(document).on('submit', '.update-cart-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');

        // Disable the submit button to prevent multiple submissions
        submitButton.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Reload the cart section or update UI accordingly
                console.log("Response:", response);
                location.reload(); // Reload page to see the updated cart
            },
            error: function(xhr, status, error) {
                console.error("Error:", status, error);
                alert('Error updating cart.');
            },
            complete: function() {
                // Re-enable the submit button
                submitButton.prop('disabled', false);
            }
        });
    });



    ///remove cart 

    $(document).on('submit', '.remove-cart-form', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                location.reload(); // Reload page to see the updated cart
            },
            error: function() {
                alert('Error removing item.');
            }
        });
    });
</script>





</body>

</html>
