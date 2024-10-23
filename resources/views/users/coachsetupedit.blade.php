@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper ">


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update</div>
                    <form action="{{ route('coachingsetup.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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


                        <h2>Coaching Setup</h2>
                        <label for="interviewDetails">[Fullname], in [City] and on WhatsApp=[phone number with country code
                            and +
                            sign], has a [what round?] interview with [Company] [Business Area if relevant] on
                            [date]:</label>
                        <textarea id="interviewDetails" name="interviewDetails" rows="5" maxlength="300" value = "" required>{{ $user->interviewDetails }}</textarea>
                        <input type="hidden" id="identifier" name="identifier" value="{{ $user->identifier }}">
                        <label for="client">Client:</label>
                        <select id="client" class="js-example-tags" name="client" multiple="multiple" required>
                            <option value="" disabled>Please select</option>
                            @foreach ($values as $value)
                                @if (!empty($value['First Name']) && !empty($value['Last Name']))
                                    <option value="{{ $value['First Name'] . ' ' . $value['Last Name'] }}"
                                        @if ($user->client == $value['First Name'] . ' ' . $value['Last Name']) selected @endif>
                                        {{ $value['First Name'] . ' ' . $value['Last Name'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>


                        <label for="deadline">Deadline:</label>
                        <input type="text" id="deadline" name="deadline" value="{{ $user->deadline }}"
                            class="form-control" required>
                        <small>Please select the date from the calendar.</small>

                       
                        <label for="service">Service:</label>
                        <select id="service" class="js-example-tags" name="service" multiple="multiple" required>
                            <option value="" disabled>Select a service</option>
                            
                            @foreach ($values2 as $value)
                            
                                <option value="{{ $value }}" @if ($user->service == $value) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>


                        <label for="setupNotes">Setup Notes (Max 300 words):</label>
                        <textarea id="setupNotes" value = "" name="setupNotes" rows="5" maxlength="300" required>{{ $user->setupNotes }}</textarea>
                         
                            <label for="coach">Select a Coach</label>
                            <select id="coach" class="js-example-tags" name="coach" multiple="multiple" required>
                            <option value="" disabled>Select a Coach:</option>
                         
                            @foreach ($serviceClient as $value)
                                <option value="{{ isset($value[0]  ) ? $value[0] : '' }}" >
                                    {{ isset($value[0]) ? $value[0] : '' }}
                                </option>
                            @endforeach
                            </select>

                            <input type="hidden" id="coachmail" name="coachmail">
                          

                            <label for="Bio">Biography:</label>
                    <textarea id="Bio" name="Bio" rows="5" readonly></textarea><br><br>

                     <div id="dynamicTable">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form">
                                    <label class="bmd-label-floating">Resume</label>
                                    <input type="file" name="resume[]" class="form-control" style="width:145%">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form">
                                    <button type="button" style="margin-top:32px; margin-left: 150px" name="add" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                            {{-- <label for="resume">Resume (Multiple files):</label>
                            <input type="file" id="resume" name="resume[]" multiple> --}}
                            <!-- Batch Dropdown --><br>
                            <label for="batch">Question Batch:</label>
                            {{-- @dd($values3) --}}
                            <select id="batch" class="js-example-tags" name="batch" multiple="multiple" required>
                                <option value="" disabled>Select a Question:</option>
                                @foreach ($values3 as $value)
                                 
                                    <option value="{{ $value }}" @if ($user->batch == $value) selected @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select></br>


                            </br> <input type="submit" value=" Submit">
                    </form>
                </div>
         
                
               
             
     @endsection

     
    