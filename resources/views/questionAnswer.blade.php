<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Feedback Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }
    </style>
    

</head>

<body>

    @php
        $identifier = request()->get('identifier');

        $existingFeedback = App\Models\CoachFeedback::where('identifier', $identifier)->exists();

    @endphp
    @if ($existingFeedback)
        <div class="alert alert-danger">
            <center>
                <h3>
                    Feedback is submitted for this identifier.</h3>
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
            {{-- <div id="feedbackMessage"></div> --}}
            <h1>Coach Feedback Form</h1>
            <form id="feedbackForm" action="{{ route('saveFeedback') }}" method="POST">
                @csrf <!-- Include CSRF token for security -->


                <div class="form-group">
                    <label for="batch">Batch:</label>
                    <input type="text" id="batch" name="batch" value="{{ request()->get('question') }}"
                        required>
                </div>
                <input type="hidden" id="identifier" name="identifier" value="{{ request()->get('identifier') }}"
                    >

                    @forelse ($question as $index => $q)
                    <div class="question-group">
                        <div class="form-group">
                            <label for="question{{ $index + 1 }}">Question {{ $index + 1 }}:</label>
                            <input type="text" id="question{{ $index + 1 }}" name="questions[]" value="{{ $q }}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="feedback{{ $index + 1 }}">Feedback for Question {{ $index + 1 }}:</label>
                            <input type="text" id="feedback{{ $index + 1 }}" name="feedbacks[]" required>
                        </div>
            
                        <div class="form-group">
                            <label for="grading{{ $index + 1 }}">Grading for Question {{ $index + 1 }}:</label>
                            <input type="number" id="grading{{ $index + 1 }}" min="0" max="10" step="0.1" name="gradings[]" required>
                        </div>
                    </div>
                @empty
                    <!-- Render an empty question set if no questions are available -->
                    <div class="question-group">
                        <div class="form-group">
                            <label for="question1">Question 1:</label>
                            <input type="text" id="question1" name="questions[]" required>
                        </div>
            
                        <div class="form-group">
                            <label for="feedback1">Feedback for Question 1:</label>
                            <input type="text" id="feedback1" name="feedbacks[]" required>
                        </div>
            
                        <div class="form-group">
                            <label for="grading1">Grading for Question 1:</label>
                            <input type="number" id="grading1" min="0" max="10" step="0.1" name="gradings[]" required>
                        </div>
                    </div>
                @endforelse
                <button type="button" id="addQuestionButton" class="btn btn-secondary">Add More Questions</button></br>


                <br><div class="form-group">
                    <label for="summaryfeedback">Summary Feedback:</label>
                    <input type="text" id="summaryfeedback" name="summaryfeedback" required>
                </div>
             
                <div class="form-group">
                    <label for="overallgrading">Overall Grading:</label>
                    <input type="number" id="overallgrading" min="0" max="10" step="0.1"
                        name="overallgrading" required>

                </div>
            
                <hr>
                <center><button type="submit" class="btn btn-primary">Submit</button>
                    <center>
            </form>
            <br><p>(Please note that once the Feedback form is submitted, it will not be accessible and editable)</p>



        </div>


    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  


    <script>
        let questionCounter = {{ count($question) }}; // Initialize question counter with the number of existing questions
    
        function addQuestion() {
            questionCounter++;
    
            let newQuestionGroup = `
                <div class="question-group">
                    <div class="form-group">
                        <label for="question${questionCounter}">Question ${questionCounter}:</label>
                        <input type="text" id="question${questionCounter}" name="questions[]" required>
                    </div>
                    <div class="form-group">
                        <label for="feedback${questionCounter}">Feedback for Question ${questionCounter}:</label>
                        <input type="text" id="feedback${questionCounter}" name="feedbacks[]" required>
                    </div>
                    <div class="form-group">
                        <label for="grading${questionCounter}">Grading for Question ${questionCounter}:</label>
                        <input type="number" id="grading${questionCounter}" min="0" max="10" step="0.1" name="gradings[]" required>
                    </div>
                </div>
            `;
    
            $('.question-group:last').after(newQuestionGroup); // Insert after the last question group
        }
    
        $('#addQuestionButton').click(function() {
            addQuestion();
        });
    </script>
    






</body>

</html>
