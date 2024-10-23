<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout Confirmation</title>
    <!-- Include Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Checkout Confirmation</h2>

        <!-- Display the services here -->
        <div id="services-list" class="mb-4">
            <h4>Services Purchased:</h4>
            <ul>
                @foreach ($serviceNames as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Stripe Payment Form -->
        <form id="payment-form"  class="shadow p-4 rounded bg-white">
            <div class="form-group">
                <label for="card-holder-name">Cardholder Name</label>
                <input type="text" id="card-holder-name" class="form-control" placeholder="Enter Cardholder Name" required>
            </div>

            
            <div class="form-group">
                <label for="card-element">Credit or Debit Card</label>
                <div id="card-element" class="form-control">
                    <!-- Stripe Element will be inserted here -->
                </div>
                <small id="card-errors" class="form-text text-danger mt-2" role="alert"></small>
            </div>

            <button type="submit" id="submit" class="btn btn-primary btn-block">Pay Now</button>
        </form>
        {{-- <input type="hidden" id="validatedData" name="validatedData" value="{{ json_encode($validatedData) }}"> --}}

        <div id="payment-result" class="text-center mt-4"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Initialize Stripe
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();

        // Custom styling for Stripe Elements
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element
        var cardElement = elements.create('card', { style: style });
        cardElement.mount('#card-element');

        // Handle form submission
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const cardHolderName = document.getElementById('card-holder-name').value;
            stripe.confirmCardPayment("{{ $clientSecret ?? '' }}", {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName,
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error to your customer
                    document.getElementById('card-errors').textContent = result.error.message;
                    // Redirect to failure page
                    window.location.href = "{{ route('checkout.failure') }}";
                } else {
                    // The payment succeeded!
                    if (result.paymentIntent.status === 'succeeded') {
                        // Redirect to success page
                        window.location.href = "{{ route('thank-you') }}?payment_id=" + result.paymentIntent.id;


                        // window.location.href = "{{ route('checkout.success') }}";
                    }
                }
            });
        });
    </script>
</body>

</html>
