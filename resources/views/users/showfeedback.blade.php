@extends('admin.layouts.master')

@section('styles')
    <style>
        /* Additional styling */
        .content-wrapper {
            margin-top: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center; /* Center the text */
            font-size: 1.5rem; /* Increase font size */
            padding: 15px 0; /* Adjust padding */
        }

        .card-body {
            padding: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px; /* Adjust margin for labels */
            display: block; /* Ensure labels appear on their own line */
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none; /* Remove border */
            background-color: #f8f9fa;
            color: #495057;
            resize: none; /* Prevent resizing */
            box-shadow: none; /* Remove any box shadow */
            font-size: 1rem; /* Adjust font size */
        }

        input[type="text"][readonly],
        textarea[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        small {
            display: block;
            margin-top: 5px;
            font-size: 80%;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                   
                    <div class="card-body">
                        <h2>Coaching Request</h2>

                        @foreach ($item as $user)
                            
                       {{-- @dd($user); --}}
                        <label for="interviewDetails">Interview Details:</label>

                        <p>{{ $user->interviewDetails }}</p>
                        {{-- <textarea id="interviewDetails" name="interviewDetails" rows="5" maxlength="300" readonly>{{ $user->interviewDetails }}</textarea> --}}

                        <label for="client">Client:</label>
                        <p>{{ $user->client }}</p>

                        <label for="deadline">Deadline:</label>
                        <p>{{ $user->deadline }}</p>                     

                        <label for="service">Service:</label>
                        <p>{{ $user->service }}</p>                       

                        <label for="setupNotes">Setup Notes (Max 300 words):</label>
                        <p>{{ $user->setupNotes }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2>Coaching Setup</h2>
                        {{-- @dd($adminsetup); --}}
                        @if ($adminsetup->isNotEmpty())
                        @foreach ($adminsetup as $setup)
                      
                            <label for="client">Interview Detail:</label>
                            <p>{{ $setup->interviewDetails }}</p>
        
                            <label for="client">Client:</label>
                            <p>{{ $setup->client }}</p>  
        
                            <label for="client">Coach:</label>
                            <p>{{ $setup->coach }}</p>
        
                            <label for="client">Coach Email:</label>
                            <p>{{ $setup->coachmail }}</p>
        
                            <label for="client">Biography:</label>
                            <p>{{ $setup->biography }}</p>
        
                            <label for="deadline">Deadline:</label>
                            <p>{{ $setup->deadline }}</p>
        
                            <label for="client">Service:</label>
                            <p>{{ $setup->service }}</p>
        
                            <label for="service">Setup Notes:</label>
                            <p>{{ $setup->setupNotes }}</p>
                            
                            <label for="service">Resume:</label>
                            <p>{{ $setup->resume }}</p>
        
                            <label for="client">Batch:</label>
                            <p>{{ $setup->batch }}</p>                       
        
                            <label for="setupNotes">Setup Notes (Max 300 words):</label>
                            <p>{{ $setup->interviewDetails}}</p>
                        @endforeach
                        @else
                        <p>No Coaching setup available</p>
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>Coaching Feedback</h2>
                    @foreach ($coachfeedbacks as $index => $feedback)
                    {{-- @dd($feedback); --}}
                        <div class="question-group">
                            <div class="form-group">
                                <label for="question{{ $index + 1 }}">Question {{ $index + 1 }}:</label>
                                <p>{{ $feedback->question }}</p>
                            </div>
                
                            <div class="form-group">
                                <label for="feedback{{ $index + 1 }}">Feedback for Question {{ $index + 1 }}:</label>
                                <p>{{ $feedback->feedback }}</p>
                            </div>
                
                            <div class="form-group">
                                <label for="grading{{ $index + 1 }}">Grading for Question {{ $index + 1 }}:</label>
                                <p>{{ $feedback->grading }}</p>
                            </div>
                        </div>
                    @endforeach
                    @if ($coachfeedbacks->isNotEmpty())
                    <div class="form-group">
                      <label>Summary Feedback:</label>
                     
                          <p>{{ $coachfeedbacks->first()->summaryfeedback }}</p>
                     
                    </div>
              
                  <div class="form-group">
                      <label>Overall Grading:</label>
                     
                          <p>{{ $coachfeedbacks->first()->overallgrading }}</p>
                     
                  </div>
                  @else
                  <p>No feedback available</p>
              @endif
                </div>
            </div>
        </div>
    </div>
   
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>Client Feedback</h2> 
                    @if ($client_feedback->isNotEmpty())
                        @foreach ($client_feedback as $item)   
                            <p>Identifier: {{ $item->identifier }}</p>
                            <p>Q1: Would you want to be coached again by this coach some day?</p>
                            <p>Answer: {{ $item->question_1 }}</p>
                    
                            <p>Q2: Please explain why</p>
                            <p>Answer: {{ $item->question_2 }}</p>
                    
                            <p>Do we have permission to share what you write below with your coach?</p>
                            <p>Answer: {{ $item->question_3 }}</p>
                        @endforeach   
                        @elseif($client_feedback->isEmpty())
                        <p>No client feedback available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    


@endsection
