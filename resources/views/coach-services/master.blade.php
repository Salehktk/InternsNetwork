<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title> <!-- Title section for individual pages -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3//css/bootstrap.min.css">

</head>
<body>
  
<header class="header sticky" id="navbar">
    <button class="toggle-button" aria-label="Toggle navigation">
        &#9776; <!-- Hamburger icon -->
    </button>
    <div class="logo">
        <a href="#">
            <img src="{{ asset('logo-image/service-logo.png') }}" alt="Logo">
        </a>
    </div>
    <div class="nav-icons">
        <a href="#">Home</a>
        <a href="{{route('CoachServices.show')}}">Services</a>
        <a href="#">Checkout</a>
        {{-- <a href="{{route('login')}}" data-toggle="modal" data-target="#loginModel">Sign In</a> --}}
        @if (Auth::check())
        <!-- Display the authenticated user's name with a dropdown -->
        <div class="dropdown">
            <a href="#" class="btn btn-secondary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @else
        <!-- Display the login button when the user is not logged in -->
        <a href="{{ route('login') }}" class="">Signin</a>

        <a href="{{ route('register') }}" class="">Register</a>

        @endif
        <a href="{{route('view-cart')}}"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a>
    </div>
</header>

  
    <main class="container">
        @yield('content') 
    </main>

   @include('coach-services.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>



 
<script>
        // Filters JS //
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
        // Debounce function
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Your AJAX call
        function fetchServices(page, subscriberLevel, serviceType, servicePrice) {
            $('#loader').show();
            // const query = $('#searchInput').val();

            $.ajax({
                url: "{{ route('CoachServices.show') }}",
                method: 'GET',
                data: {
                    page: page,
                    subscriber_level: subscriberLevel,
                    service_type: serviceType,
                    service_price: servicePrice,

                },


                dataType: 'json',
                success: function(response) {
                    console.log(page);
                    $('#servicesContainer').html(response.html);
                },
                error: function() {
                    // Handle error if needed
                    $('#servicesContainer').html('<p>Error fetching data. Please try again.</p>');
                },
                complete: function() {
                    // Hide the loader
                    $('#loader').hide();
                }

            });
        }

        // Bind keyup event with debounce
        $('#subscriberLevelFilter, #serviceTypeFilter, #servicePriceFilter').on('change', debounce(function() {
            var subscriberLevel = $('#subscriberLevelFilter').val();
            var serviceType = $('#serviceTypeFilter').val();
            var servicePrice = $('#servicePriceFilter').val();

            fetchServices(1, subscriberLevel, serviceType, servicePrice);
        }, 1000));

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var subscriberLevel = $('#subscriberLevelFilter').val();
            var serviceType = $('#serviceTypeFilter').val();
            var servicePrice = $('#servicePriceFilter').val();

            fetchServices(page, subscriberLevel, serviceType, servicePrice);
        });

        //??///////for sticky navbar
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.scrollY >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 70) { // Adjust the scroll value as needed
                    $('#navbar').addClass('scrolled');
                } else {
                    $('#navbar').removeClass('scrolled');
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('.toggle-button');
            const navIcons = document.querySelector('.nav-icons');

            toggleButton.addEventListener('click', function() {
                navIcons.classList.toggle('show');
            });
        });
        $(document).ready(function() {
            function adjustPagination() {
                if ($(window).width() < 576) {
                    $('.pagination li:not(:first-child):not(:last-child)').hide();

                } else {
                    $('.pagination li').show();
                }
            }

            adjustPagination();

            $(window).resize(function() {
                adjustPagination();
            });
        });
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.scrollY >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 60) { // Adjust the scroll value as needed
                    $('#navbar').addClass('scrolled');
                } else {
                    $('#navbar').removeClass('scrolled');
                }
            });
        });
    </script>

@yield('scripts')

</body>
</html>
