<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEWCOACHRESUME</title>

    <style>
        body {
            background-color: #f0f0f0;
            /* Light gray background for the entire page */
            font-family: Arial, sans-serif;
            /* Choose a professional font */
        }

        .form-container {
            background-color: #ffffff;
            /* White background for the form container */
            border: 1px solid #ddd;
            /* Light border */
            border-top: 5px solid #4159A0;
            /* Darker top border */
            padding: 30px;
            margin-top: 140px !important;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
            transition: all 0.3s ease-in-out;
            position: relative;
            /* Required for loader positioning */
        }

        .card {
            background-color: #ffffff;
            /* White background for the card */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #4159A0;
            /* Dark blue background */
            color: #fff;
            /* White text */
            border: none;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: background-color 0.3s;
        }

        .custom-file-upload:hover {
            background-color: #34467D;
            /* Darker blue on hover */
        }

        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #3498db;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-message {
            color: white;
            margin-top: 10px;
            font-size: 16px;
            text-align: center;
        }

        button {
            background-color: #4159A0;
            color: white;
            margin-top: 15px;
            margin-bottom: 12px;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        button:hover {
            background-color: #34467D;
        }
        
    </style>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-4">
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="loader-wrapper" id="loaderWrapper">
        <div class="loader-container">
            <div class="loader"></div>
            <div class="loader-message">Please wait...</div>
        </div>
    </div>
    <div class="form-container">
        <div class="card">
            <form id="uploadForm" action="{{ route('upload.resume') }}" method="post" enctype="multipart/form-data">
                @csrf
                <p>Please upload your resume and click Submit</p>
                <label for="resume" class="custom-file-upload" id="fileLabel">
                    Please upload your resume
                </label>
                <!--<label for="resume" class="custom-file-upload" id="fileLabel">-->
                <!--    Please upload your resume and click Submit-->
                <!--</label>-->
                <br>
                <input type="file" name="resume" id="resume" accept="application.pdf" style="display:none;">
                <br>

                {{-- @if (Auth::check() && (Auth::user()->email === 'peter.harrison@harrisoncareers.com' || Auth::user()->email === 'peter.harrison@harrisoncareers.com')) --}}
                <button type="button" class="btn btn-primary"
                    style="width: 50%;     background-color: grey; border:none
                     "data-bs-toggle="modal"
                    data-bs-target="#editPromptModal">
                    Edit Prompt
                </button>
                </br></br>


                <button type="submit" id="submitBtn">Submit</button>
            </form>
        </div>
    </div>



</div>

    <!-- Modal -->
    <div class="modal fade" id="editPromptModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editPromptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPromptModalLabel">Edit Prompt</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" action="{{ route('saved.editPrompt') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <textarea name="message" id="message" class="form-control" cols="30" rows="15">{{ $promptMsg }}</textarea>

                        <button type="submit" class="btn btn-primary mt-1 me-1" id="submitBtn">Save</button>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script>
     
     $(document).ready(function() {
    var label = document.getElementById('fileLabel');
    // var error = document.getElementById('error-message');
    console.log(label.textContent);
});

(function() {
    if (window.localStorage) {
        if (!localStorage.getItem('reload')) {
            localStorage.setItem('reload', 'true');
            // window.location.reload();
            // $('#error-message').show();
            // console.log('reload');
        } else {
            localStorage.removeItem('reload');
        }
       
    }
})();


document.getElementById('uploadForm').addEventListener('submit', function() {
            document.getElementById('loaderWrapper').style.display = 'flex'; 
            document.getElementById('submitBtn').disabled = true; 
        });

        document.getElementById('resume').addEventListener('change', function() {
            var fileName = this.files[0].name;
            var label = document.getElementById('fileLabel');
            label.textContent = fileName;
            var label = document.getElementById('fileLabel');
            console.log(label.textContent);
        });
        
    </script>
</body>

</html>
