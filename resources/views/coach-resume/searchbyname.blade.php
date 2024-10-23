<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by Name</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" >
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
            <a href="#">Services</a>
            <a href="#">Checkout</a>
            <a href="#" data-toggle="modal" data-target="#loginModel">Sign In</a>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </header>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="search-section">
        <div class="container search-text text-center">
            {{-- <label for="search" class="form-label fw-bold mb-3">Search Here</label><br> --}}
            <input type="text" class="form-control form-control-lg w-100 input-search"
                placeholder="Search By Name ....." id="search" name="search" autocomplete="off">
        </div>
    </div>
    <footer class="bg-ligh">
        <div class="container text-center">
            <div class="small text-muted">Copyright © 2022 - THE INTERNS NETWORK</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HyE1N76ZebTnUMIhBwsL9mR8vF8A1I2dVJxGFA8Uxa9PtwN+g0Pln1QU9voUjRGF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script>
        document.querySelector('.toggle-button').addEventListener('click', function() {
            var navIcons = document.querySelector('.nav-icons');
            navIcons.classList.toggle('show');
        });
        $(document).ready(function() {
            var searchName = document.getElementById('search');
            var names = @json($names);
          

            $('#search').typeahead({

                highlight: true,
                minLength: 1
            }, {
                name: 'names',
                source: function(query, syncResults) {
                    var matches = [];
                    var substrRegex = new RegExp(query, 'i');
                    $.each(names, function(i, name) {

                        if (substrRegex.test(name)) {
                            matches.push(name);
                        }
                    });
                    syncResults(matches);
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                $.ajax({
                    url: '{{ route('fetchCoachDetails') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: suggestion
                    },
                    success: function(response,services,servic) {
                        // console.log(typeof response);
                        if (response && typeof response === 'object') {
                            // Redirect to the coach form with the selected coach's details using a GET request
                            var queryString = $.param({
                                coachDetails: JSON.stringify(response),
                                services: JSON.stringify(services),
                                servic: JSON.stringify(servic),                             
                                
                                searchName: document.getElementById('search').value
                            });
                         
                            window.location.href = '{{ route('showCoachForm') }}?' +
                                queryString;
                        } else {
                            alert('No details found for the selected coach.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching the details.');
                    }
                });
            });
        });
    </script>
</body>
</html>