<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .error-message {
            color: red;
            display: none;
        }
    </style>
</head>

<body>
   
     @if ($feedbackSubmitted!=null)
        <div class="alert alert-success">
            <center>
                <h3>
                  Client Feedback is submitted for this identifier.</h3>
            </center>
        </div>
    @else
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            {{-- @dd(request()->get('identifier')); --}}
            <h2 class="text-center mb-4">Client Feedback</h2>
            {{-- @dd($identifier) --}}

            <form id="feedbackForm" action="{{ route('submitfeedback') }}" method="POST">
                @csrf
                {{-- @dd($identifier) --}}
                <input type="hidden" value="{{ $identifier }}" id="identifier" name="identifier">
    
                <div class="form-group">
                    <label for="q1">Q1: Would you want to be coached again by this coach some day?</label>
                    <div class="form-check">
                        <input type="radio" id="q1_yes" name="question_1" value="Yes" class="form-check-input">
                        <label for="q1_yes" class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="q1_no" name="question_1" value="No" class="form-check-input">
                        <label for="q1_no" class="form-check-label">No</label>
                    </div>
                    <div class="error-message" id="error-message-q1">Please select an option for Q1.</div>
                </div>
            
                <div class="form-group">
                    <label for="q2">Q2: Please explain why (100 words minimum. If Yes, we want your coach to understand what s/he did so well. If No, we want to understand how s/he needs to perform better)</label>
                    <textarea id="q2" name="question_2" rows="5" class="form-control" required></textarea>
                    <div class="error-message" id="error-message-q2">Please enter at least 100 characters.</div>
                </div>
            
                <div class="form-group">
                    <label for="q3">Do we have permission to share what you write below with your coach?</label>
                    <div class="form-check">
                        <input type="radio" id="q3_yes" name="question_3" value="Yes" class="form-check-input">
                        <label for="q3_yes" class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="q3_no" name="question_3" value="No" class="form-check-input">
                        <label for="q3_no" class="form-check-label">No</label>
                    </div>
                    <div class="error-message" id="error-message-q3">Please select an option for Q3.</div>
                </div>

                <button type="submit" class="btn btn-submit btn-block">Submit Feedback</button>
            </form>
        </div>
    @endif


 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            let isValid = true;

            // Validate question_1
            const q1_yes = document.getElementById('q1_yes').checked;
            const q1_no = document.getElementById('q1_no').checked;
            const errorMessageQ1 = document.getElementById('error-message-q1');

            if (!q1_yes && !q1_no) {
                errorMessageQ1.style.display = 'block';
                isValid = false;
            } else {
                errorMessageQ1.style.display = 'none';
            }

            // Validate question_2
            const textarea = document.getElementById('q2');
            const errorMessageQ2 = document.getElementById('error-message-q2');

            if (textarea.value.length < 100) {
                errorMessageQ2.style.display = 'block';
                isValid = false;
            } else {
                errorMessageQ2.style.display = 'none';
            }

            // Validate question_3
            const q3_yes = document.getElementById('q3_yes').checked;
            const q3_no = document.getElementById('q3_no').checked;
            const errorMessageQ3 = document.getElementById('error-message-q3');

            if (!q3_yes && !q3_no) {
                errorMessageQ3.style.display = 'block';
                isValid = false;
            } else {
                errorMessageQ3.style.display = 'none';
            }

            // Prevent form submission if any validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>

</body>

</html>
