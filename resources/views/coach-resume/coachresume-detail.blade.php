<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resume Details</title>

        <style>
            .start-div {
                border-top: 10px solid blue;
            }
    
            label {
                font-weight: bold;
                font-family: popin;
            }
    
            .card {
                background-color: #f1f5f7;
                border: 0;
            }
    
            .card-body {
                background-color: #e5ebf0;
            }
    
            .form-control {
                border-radius: 0.5rem;
                border: 1px solid #e4e9ee;
            }
    
            .form-control:focus {
                box-shadow: none;
                border-color: #007bff;
            }
    
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }
    
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
            }
    
            .rounded-circle {
                border-radius: 50%;
            }
    
            button {
                width: 130px;
            }
    
            ::placeholder {
                font-size: 15px;
                color: #48494896 !important
                    /* Adjust the size as needed */
            }
    
            /* Specific input field placeholder styling */
            input::placeholder {
                font-size: 15px;
                color: #e4e9ee
                    /* Adjust the size as needed */
            }
    
            textarea::placeholder {
                font-size: 15px;
                color: #e4e9ee
                    /* Adjust the size as needed */
            }
    
            .loader-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                display: none;
            }
    
            .loader-container {
                text-align: center;
            }
    
            .loader {
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #3498db;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
                margin: 0 auto;
            }
    
            .loader-message {
                margin-top: 20px;
                color: #ffffff;
                font-size: 18px;
            }
    
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
    
                100% {
                    transform: rotate(360deg);
                }
            }
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }
            input[type="number"] {
            -moz-appearance: textfield; /* Hides the spinner arrows in Firefox */
            }
        </style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>

<body>  
            {{-- @dd($coachDetails); --}}
    <div class="container mt-4">
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
   

    <div class="container mt-5">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body start-div p-4">

                <!-- Profile Picture -->
{{-- @dd($serviceDetails) --}}
                <form id="submitForm" 
                    action="{{ route('harrisonupdate') }}" method="post" enctype="multipart/form-data" >
                    @csrf


                    <input type="hidden" name="reqName" value="{{ $reqName }}"/>
                    <!-- AI Photo and Resume URL -->
                    <div class="mb-4">
                        {{-- @dd($coachDetails[38]) --}}
                           <div class="form-group">
                               <input type="hidden" name="Resume"
                                   class="form-control form-control-lg shadow-sm border-primary rounded-pill"
                                   placeholder="Use this to upload new version of resume"  value="{{$coachDetails[38] ?? ''}}"/>
                           </div>
                       </div>

                    @if (!empty($coachDetails))               

                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">Personal Information</h4>
                        <div class="card border-light shadow-sm rounded-3 p-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="FullName" class="form-label">FullName</label>
                                    <input type="text" name="FullName" id="FullName"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="FullName" value="{{ $coachDetails[0] ?? ''}}" required />
                                    {{-- <span class="invalid-feedback">Please enter your First Name.</span> --}}
                                    @if ($errors->has('FullName'))
                                    <span class="text-danger">{{ $errors->first('FullName') }}</span>
                                    @endif
                                </div>
                              
                                @php
                                $split = explode(' ', $coachDetails[4] ?? '');
                            @endphp
                            <div class="col-md-4 mb-3">
                                <label for="Location" class="form-label">Location</label>
                                <input type="text" name="Location" id="Location"
                                    class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                    placeholder="Country" 
                                    value="{{ htmlspecialchars($split[0]) }} {{ htmlspecialchars(implode(' ', array_slice($split, 1)))  }}" 
                                    required />
                                {{-- <span class="invalid-feedback">Please enter your Location.</span> --}}
                                @if ($errors->has('Location'))
                                <span class="text-danger">{{ $errors->first('Location') }}</span>
                            @endif
                            </div>
                            
                            </div>
                           
                            <div class="mb-3">
                                <label for="Bio" class="form-label">Bio</label>
                                <textarea name="Bio" id="Bio" class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                    rows="4"
                                    placeholder="Make yourself sound impressive - candidates want coaches from big-name companies and they want true expertise. Write biography in this style:
[Firstname]. who currently works in [business area] has interned/worked at [Company] [City] in [BizArea], [Company] [City] in [BizArea], [Company] [City] in [BizArea], and [Company] [City] in [BizArea]. 
[Firstname] knows a lot about [insert some business/career-related things you know a lot about]. 
[Firstname] is into [briefly mention 3 fun things to show your approachability]."
 required>{{ $coachDetails[3] ?? ''}} </textarea>
                                {{-- <span class="invalid-feedback">Please enter your Bio.</span> --}}
                                @if ($errors->has('Bio'))
                                <span class="text-danger">{{ $errors->first('Bio') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">Contact Information</h4>
                        <div class="card border-light shadow-sm rounded-3 p-3">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="LinkedIn_URL" class="form-label">LinkedIn URL</label>
                                    <input type="url" name="LinkedIn_URL" id="LinkedIn_URL"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Your LinkedIn public profile URL" value="{{ $coachDetails[23] ?? ''}}" required />
                                    {{-- <span class="invalid-feedback">Please enter your LinkedIn URL</span> --}}
                                    @if ($errors->has('LinkedIn_URL'))
                                    <span class="text-danger">{{ $errors->first('LinkedIn_URL') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="Email" class="form-label">Email</label>
                                    <input type="email" name="Email" id="Email"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Primary Email" value="{{ $coachDetails[24] ?? ''}}" required />
                                    {{-- <span class="invalid-feedback">Please enter your Primary Email</span> --}}
                                    @if ($errors->has('Email'))
                                    <span class="text-danger">{{ $errors->first('Email') }}</span>
                                @endif
                                </div>
                                

                                <div class="col-md-4 mb-3">
                                    <label for="Email2" class="form-label">Email2</label>
                                    <input type="email" name="Email2" id="Email2"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Backup Email" value="{{ $coachDetails[25] ?? ''}}" required />
                                    {{-- <span class="invalid-feedback">Please enter your Backup Email</span> --}}
                                    @if ($errors->has('Email2'))
                                    <span class="text-danger">{{ $errors->first('Email2') }}</span>
                                @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="WhatsApp" class="form-label">WhatsApp</label>
                                    <input type="number"  name="WhatsApp" id="WhatsApp"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="If you are on WhatsApp, please enter number with +country code. Otherwise leave blank if not on WhatsApp." value="{{ $coachDetails[26] ?? ''}}"
                                        required />
                                    {{-- <span class="invalid-feedback">Please enter your WhatsApp</span> --}}
                                    @if ($errors->has('WhatsApp'))
                                    <span class="text-danger">{{ $errors->first('WhatsApp') }}</span>
                                @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="FaceTime_&_iMessage" class="form-label">FaceTime & iMessage</label>
                                    <input type="number" name="FaceTime_&_iMessage" id="FaceTime_&_iMessage"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="If you have an iPhone please enter number with +country code. If Android, leave blank."
                                        required value="{{ $coachDetails[27] ?? ''}}" />
                                    {{-- <span class="invalid-feedback">Please enter your FaceTime</span> --}}
                                    {{-- <span class="invalid-feedback">Please enter your FaceTime number with +country code if you have an iPhone</span> --}}
                                    @if ($errors->has('FaceTime_&_iMessage'))
                                    <span class="text-danger">{{ $errors->first('FaceTime_&_iMessage') }}</span>
                                    @endif
                                </div>
                             
                            </div>
                            <div class="row">
                               
                                
                            </div>
                        </div>  
                    </div>


                    <!-- Alias Information -->
                    <div class="mb-4">

                        <h4 class="text-primary">Alias Information</h4><small class="text-danger">* Information
                            generated from our AI system to protect your identity, you can edit the required information
                            if required</small>
                        <div class="card border-light shadow-sm rounded-3 p-3">
                            <div class="row">
                                <div class="text-center mb-5">
                              
                                    
                                    @if(empty($imageUrl))
                                    <img src="{{ $coachDetails[37] ?? ''}}"  class="img-fluid rounded-circle border border-primary"
                                    alt="Profile Picture" style="width: 120px; height: 120px; object-fit: cover;" />
                                    <input type="file" name="PhotoAI"  id="updateimage" />
                                    <div class="invalid-feedback">
                                        Please upload a file.
                                    </div>
                                    <input type="hidden" name="lastPhoto" id="sheetimage" value="{{$coachDetails[37] ?? ''}}"/>
                                    @else
                                    <img src="{{ $imageUrl }}" class="img-fluid rounded-circle border border-primary"
                                         alt="Profile Picture" style="width: 120px; height: 120px; object-fit: cover;" />
                                    <input type="hidden" name="PhotoAI" value="{{ $imageUrl }}" />
                                    @endif
                                   
                                    
                                </div>
                                <div class="col-md-6 mb-3">
                                   
                                    <label for="NameAlias" class="form-label padded-label">NameAlias</label>
                                    <input type="text" name="NameAlias" id="NameAlias" class="form-control"
                                        placeholder="Generated by AI to protect your privacy. Please edit as you see fit but keep it sensible. "
                                        value="{{ strip_tags($coachDetails[34] ?? '') }}" required>
                                    {{-- <span class="invalid-feedback">Please enter your  NameAlias</span> --}}
                                    @if ($errors->has('NameAlias'))
                                    <span class="text-danger">{{ $errors->first('NameAlias') }}</span>
                                @endif
                                  
                                </div>
                               
                                <div class="col-md-12 mb-3">
                                
                                    <label for="BioAlias" class="form-label padded-label">Bio Alias</label>
                                    <textarea name="BioAlias" id="BioAlias" class="form-control" style="height: 200px;"
                                        placeholder="This is your public alias biography that stops you being easily identified. AI generated this version. Please improve it. Keep it as real as possible but protect your privacy. "
                                     value="" required>{{ strip_tags($coachDetails[35] ?? '') }}</textarea>
                                    {{-- <span class="invalid-feedback">Please enter your Bio Alias</span> --}}
                                    @if ($errors->has('BioAlias'))
                                    <span class="text-danger">{{ $errors->first('BioAlias') }}</span>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mb-4">
                        <h4 class="text-primary mb-3">Services</h4>
                        <div class="card border-light shadow-sm rounded-3 p-3">
                            <div class="mb-4">
                             
                                    <select id="services" name="services[]" class="form-control" multiple="multiple">
                                     
                                        @foreach($mergedServices as $service)
                                        <option value="{{ $service }}" {{ in_array($service, $selectedServices) ? 'selected' : '' }}>
                                            {{ $service }}
                                        </option>
                                         @endforeach
                                      
                                    
                                    </select>
                                
                            
                            </div>
                            <div id="services-input-container">
                                @foreach($selectedServices as $service)
                                    <div class="input-group mb-3" id="input-{{ $service }}">
                                        <label class="input-group-text">{{ $service }}</label>
                                        <input type="text" class="form-control" name="service_input[{{ $service }}]" value="{{ $serviceDetails[$service] ?? '' }}" placeholder="Enter details for {{ $service }}">
                                        <button type="button" class="btn btn-danger btn-sm remove-field" data-service="{{ $service }}">Remove</button>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <!-- Advice and Availability -->
                    <div class="mb-4">
                        {{-- <h4 class="text-primary mb-3">Job Offers</h4> --}}
                        <div class="card border-light shadow-sm rounded-3 p-3">
                           
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="JobOffers" class="form-label">Job Offers</label>
                                    <input type="text" name="JobOffers" id="JobOffers"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="List companies + business areas that offered you an internship, placement or other employment. We want to impress candidates by your job search success."
                                        required value="{{ $coachDetails[36] ?? ''}}" />
                                    {{-- <span class="invalid-feedback">Please enter your Job Offers</span> --}}
                                    @if ($errors->has('JobOffers'))
                                    <span class="text-danger">{{ $errors->first('JobOffers') }}</span>
                                     @endif
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Specialties" class="form-label">Specialties</label>
                                    <input type="text" name="Specialties" id="Specialties"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="List companies + business areas that offered you an internship, placement or other employment. We want to impress candidates by your job search success."
                                        required value="{{ $coachDetails[1] ?? ''}}" />
                                    {{-- <span class="invalid-feedback">Please enter your Specialty</span> --}}
                                    @if ($errors->has('Specialties'))
                                    <span class="text-danger">{{ $errors->first('Specialties') }}</span>
                                @endif
                                </div>
                                <div class="mb-3">
                                    <label for="Availability" class="form-label">Availability</label>
                                    <textarea name="Availability" id="Availability"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3" rows="4"
                                        placeholder="Enter any notes we should send to your candidates about your availability, for example “Contact me immediately at [email] and if no reply within XX hours then WhatsApp me on XX/iMessage me on XX''"
                                        required>{{ $coachDetails[39] ?? ''}}</textarea>
                                    {{-- <span class="invalid-feedback">Please enter your Availability Note</span> --}}
                                    @if ($errors->has('Availability'))
                                    <span class="text-danger">{{ $errors->first('Availability') }}</span>
                                @endif
                                </div>
                               
                            </div>
                        </div>
                    </div>


                    <div class="mb-4">
                        <h4 class="text-primary mb-3">Harrison Career Information</h4>
                        <div class="card border-light shadow-sm rounded-3 p-3">
                           
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="Category" class="form-label">Category</label>
                                    <input type="text" name="Category" id="Category"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Finance | Tech | Consulting"
                                        required value="{{ $coachDetails[2]}}" />
                                        {{-- required value="{{ $coachDetails[14]}}" /> --}}
                                    {{-- <span class="invalid-feedback">Please select Offers</span> --}}
                                    @if ($errors->has('Category'))
                                    <span class="text-danger">{{ $errors->first('Category') }}</span>
                                @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="pay" class="form-label">Pay Rate</label>
                                    <input type="number" name="Pay" id="pay"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Pay-per-session in USD"
                                        required value="{{ $coachDetails[6]}}"/>
                                    {{-- <span class="invalid-feedback">Please enter your Pay Rate</span> --}}
                                    @if ($errors->has('pay'))
                                    <span class="text-danger">{{ $errors->first('pay') }}</span>
                                @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="HowGood_1_3" class="form-label">How Good</label>
                                    <input type="number" name="HowGood_1_3" id="HowGood_1_3"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Scale 1-3" min="1" max="3" required value="{{ $coachDetails[7]}}"/>
                                    @if ($errors->has('HowGood_1_3'))
                                        <span class="text-danger">{{ $errors->first('HowGood_1_3') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="Responsive" class="form-label">Responsive</label>
                                    <input type="number" name="Responsive_1_3" id="Responsive_1_3"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="Scale 1-3"  min="1" max="3" required value="{{ $coachDetails[8]}}"/>
                                    {{-- <span class="invalid-feedback">Please enter your Pay Rate</span> --}}
                                    @if ($errors->has('Responsive'))
                                    <span class="text-danger">{{ $errors->first('Responsive') }}</span>
                                @endif
                                </div>
                               
                                <div class="col-md-4 mb-3">
                                    <label for="PaymentDetails" class="form-label">PaymentDetails</label>
                                    <input type="text" name="PaymentDetails" id="PaymentDetails"
                                        class="form-control form-control-lg shadow-sm border-secondary rounded-3"
                                        placeholder="PH to figure out how we can automatically pay the coach"
                                        required value="{{ $coachDetails[29]}}"/>
                                    {{-- <span class="invalid-feedback">Please enter your Pay Rate</span> --}}
                                    @if ($errors->has('PaymentDetails'))
                                    <span class="text-danger">{{ $errors->first('PaymentDetails') }}</span>
                                @endif
                                </div>

                                
                               
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="form-check mb-4">
                        <input type="checkbox" name="T&Cs_Confirmed" id="T&Cs_Confirmed" class="form-check-input"
                            required />
                            @if ($errors->has('T&Cs_Confirmed'))
                            <span class="text-danger">{{ $errors->first('T&Cs_Confirmed') }}</span>
                        @endif

                        <label for="T&Cs Confirmed" class="form-check-label">I agree to the <a href="#"
                                class="text-primary">terms and conditions</a></label>
                        <span class="invalid-feedback">Please read and accept our terms and conditions</span>
                    </div>

                    <div class="text-start">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-md">Save</button>
                    </div>
                    
                    @else
                    <p>No details available.</p>
                    @endif
                </form>
            </div>

        </div>
    </div>
    {{-- <div class="loader-wrapper" id="loaderWrapper">
        <div class="loader-container">
            <div class="loader"></div>
            <div class="loader-message">Please wait...</div>
        </div>
    </div> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  
  

<script>
//     $(document).ready(function() {
//         $('.js-example-tags').select2({
//             allowClear: true
//         });
      
// });

$(document).ready(function() {
    $('#services').select2({
        placeholder: "Select services",
        tags: true
    }).on('change', function() {
        updateInputFields();
    });

    // Initial call to display input fields for selected services
    updateInputFields();
});
var serviceDetails = @json($serviceDetails);
function updateInputFields() {
    // Get currently selected services
    var selectedServices = $('#services').val();

    // Create a set of currently displayed service IDs to avoid duplicates
    var displayedServiceIds = new Set();
    $('#services-input-container .input-group').each(function() {
        displayedServiceIds.add($(this).attr('id').replace('input-', ''));
    });

    // Add input fields for each selected service if not already present
    $.each(selectedServices, function(index, service) {
        if (!displayedServiceIds.has(service)) {
            var serviceValue = serviceDetails[service] || "";
            var inputField = `
                <div class="input-group mb-3" id="input-${service}">
                    <label class="input-group-text">${service}</label>
                    <input type="text" class="form-control" name="service_input[${service}]" value="${serviceValue}" placeholder="Enter details for ${service}">
                    <button type="button" class="btn btn-danger btn-sm remove-field" data-service="${service}">Remove</button>
                </div>
            `;
            $('#services-input-container').append(inputField);
        }
    });

    // Remove input fields for services that are no longer selected
    $('#services-input-container .input-group').each(function() {
        var service = $(this).attr('id').replace('input-', '');
        if ($.inArray(service, selectedServices) === -1) {
            $(this).remove();
        }
    });
}

// Remove input field and deselect service when "Remove" button is clicked
$(document).on('click', '.remove-field', function() {
    var service = $(this).data('service');
    $('#services').find('option[value="' + service + '"]').prop('selected', false).trigger('change');
    $(this).closest('.input-group').remove();
});



  document.getElementById('submitForm').addEventListener('submit', function(event) {
    const sheetImage = document.getElementById('sheetimage').value;
    const updateImage = document.getElementById('updateimage').value;
    const updateImageInput = document.getElementById('updateimage');

    if (!sheetImage && !updateImage) {
        event.preventDefault(); // Prevent form submission
        updateImageInput.setAttribute('required', true);
        updateImageInput.classList.add('is-invalid');

        // Force the form to re-check the validity of its inputs
        if (!this.checkValidity()) {
            this.reportValidity(); // Show the validation error message
        }
    } else {
        updateImageInput.removeAttribute('required');
        updateImageInput.classList.remove('is-invalid');
    }
});


    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.getElementById('HowGood_1_3');
        const errorMessage = document.getElementById('error-message');

        if (!inputField || !errorMessage) {
            console.error('Required elements are missing.');
            return;
        }

        inputField.addEventListener('input', function (e) {
            const value = parseInt(e.target.value);
            if (value < 1 || value > 3) {
                e.target.setCustomValidity('Please enter a value between 1 and 3.');
                errorMessage.textContent = 'Please enter a value between 1 and 3.';
            } else {
                e.target.setCustomValidity('');
                errorMessage.textContent = '';
            }
        });

        inputField.addEventListener('change', function (e) {
            let value = parseInt(e.target.value);
            if (value < 1) {
                e.target.value = 1;
            } else if (value > 3) {
                e.target.value = 3;
            }
            if (value < 1 || value > 3) {
                errorMessage.textContent = 'Please enter a value between 1 and 3.';
            } else {
                errorMessage.textContent = '';
            }
        });
    });
</script>

</body>

</html>
