@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper ">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update</div>
                    <form action="{{ route('coach.update', $user->id) }}" method="POST">
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
                        <input type="submit" onclick="submitForm()" value="Submit">
                    </form>
                </div>
            @endsection

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

            <script>
                
                var $select2 = $('.js-example-tags').select2({
                    tags: true
                });

              
                $select2.on('select2:open', () => {
                   
                    setTimeout(() => {

                        var searchBox = document.querySelector('.select2-search__field');

                        if (searchBox) {

                            searchBox.addEventListener('keydown', function(event) {

                                if (event.key === 'Backspace' && !this.value) {

                                    event.preventDefault();
                                    $select2.val(null).trigger('change');
                                }
                            });
                        }
                    }, 0);
                });
            </script>
