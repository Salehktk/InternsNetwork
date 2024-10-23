@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form id="myForm" action="{{ route('submit.request') }}" method="post">
                @csrf
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

                <h2>Coaching Request</h2>
                @if (Auth::user()->email === 'peter.harrison@harrisoncareers.com')
                    <button class="btn btn-success" id="showInputBtn">Urgent</button>
                    <div id="emailInput" style="display: none;">
                        <label for="userEmails">Enter Email(s):</label>
                        <input type="text" id="userEmails" name="userEmails"
                            placeholder="Enter email(s) here testing@gmail.com,testing2@gmail.com">
                    </div>
                @endif
                <label for="interviewDetails">[Fullname], in [City] and on WhatsApp=[phone number with country code and +
                    sign], has a [what round?] interview with [Company] [Business Area if relevant] on [date]:</label>
                <textarea id="interviewDetails" name="interviewDetails" rows="5" maxlength="300"
                    placeholder="[Fullname], in [City] and on WhatsApp=[phone number with country code and + sign], has a [what round?] interview with [Company] [Business Area if relevant] on [date]. "
                    required></textarea>

                <label for="work1">Select a Client</label>
                <select id="client" class="js-example-tags" name="client" multiple="multiple" required>
                    <option value="" disabled>Please select</option>
                    @foreach ($values as $value)
                        @if (!empty($value['First Name']) && !empty($value['Last Name']))
                            <option value="{{ $value['First Name'] . ' ' . $value['Last Name'] }}">
                                {{ $value['First Name'] . ' ' . $value['Last Name'] }}
                                
                            </option>
                        @endif
                    @endforeach
                </select>

                {{-- @dd($coachBiographyMap) --}}
              
                <input type="hidden" id="clientmail" name="userEmails">
               

                <label for="deadline">Deadline:</label>
                <input type="text" id="deadline" name="deadline" placeholder="Select a date" class="form-control"
                    required>
                <small>Please select the date from the calendar.</small>


                <label for="service">Service:</label>
                {{-- <select id="service" class="js-example-tagsss" name="service" required> --}}
                <select id="service" class="js-example-tags" name="service" multiple="multiple" required>
                    <option value="" disabled>Select a services</option>
                    @foreach ($values2 as $value)
                        <option value="{{ $value }}">
                            {{ $value }}
                        </option>
                    @endforeach


                </select>

                <label for="setupNotes">Setup Notes (Max 300 words):</label>
                <textarea id="setupNotes" name="setupNotes" rows="5" maxlength="300" placeholder="Any additional notes..."
                    required></textarea>

                  
                <input type="submit"  value="Submit">
            </form>
        </div>
    </div>
@endsection

