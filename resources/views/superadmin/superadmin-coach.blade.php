@extends('admin.layouts.master')

<style>

/* table th {
    width: auto; 
    white-space: nowrap; 
    text-align: center; 
}
table td {
    width: auto; 
    white-space: nowrap; 
    text-align: center; 
} */


</style>
@section('content')
    <div class="content-wrapper ">


        <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Coach </h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th class="text-center">Full Name</th>
                                    <th class="text-center">Specialties</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Bio</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">FX</th>
                                    <th class="text-center">Pay</th>
                                    <th class="text-center">How Good? 1-3</th>
                                    <th class="text-center">Responsive? 1-3</th>
                                    <th class="text-center">On WhatsApp?</th>
                                    <th class="text-center">LinkedIn URL</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Email 2</th>
                                    <th class="text-center">WhatsApp</th>
                                    <th class="text-center">FaceTime & iMessage</th>
                                    <th class="text-center">T&Cs Confirmed</th>
                                    <th class="text-center">Payment Details</th>
                                    <th class="text-center">Zelle | PayPal | Venmo</th>
                                    <th class="text-center">Sort Code</th>
                                    <th class="text-center">Account Number</th>
                                    <th class="text-center">Account Holder</th>
                                    <th class="text-center">Name Alias</th>
                                    <th class="text-center">Bio Alias</th>
                                    <th class="text-center">Job Offers</th>
                                    <th class="text-center">Photo AI</th>
                                    <th class="text-center">Resume</th>
                                    <th class="text-center">Availability</th>
                                    <th class="text-center">Selected Services</th>
                                </tr>
                            </thead>
                            <tbody>

                                

                                @foreach ($selectedCoach as $coach)
                                    <tr>
                                        <td class="text-center">{{ $coach['full_name'] }}</td>
                                        <td class="text-center">{{ $coach['specialties'] }}</td>
                                        <td class="text-center">{{ $coach['category'] }}</td>
                                        {{-- <td class="text-center">{{ Str::limit($coach['bio'], 20) }}</td> --}}
                                        <td class="text-center">
                                            <div class="bio-content">
                                                <span class="bio-short">{{ Str::limit($coach['bio'], 100) }}</span>
                                                <span class="bio-full" style="display: none;">{{ $coach['bio'] }}</span>
                                                <a href="javascript:void(0);" class="see-more">See More</a>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $coach['location'] }}</td>
                                        <td class="text-center">{{ $coach['fx'] }}</td>
                                        <td class="text-center">{{ $coach['pay'] }}</td>
                                        <td class="text-center">{{ $coach['how_good'] }}</td>
                                        <td class="text-center">{{ $coach['responsive'] }}</td>
                                        <td class="text-center">{{ $coach['on_whatsapp'] }}</td>
                                        <td class="text-center">{{ $coach['linkedin_url'] }}</td>
                                        <td class="text-center">{{ $coach['email'] }}</td>
                                        <td class="text-center">{{ $coach['email2'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['whatsapp'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['facetime_imessage'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['terms_confirmed'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['payment_details'] }}</td>
                                        <td class="text-center">{{ $coach['zelle_paypal_venmo'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['sort_code'] }}</td>
                                        <td class="text-center">{{ $coach['account_number'] }}</td>
                                        <td class="text-center">{{ $coach['account_holder'] }}</td>
                                        <td class="text-center">{{ $coach['name_alias'] }}</td>
                                        {{-- <td class="text-center">{{ $coach['bio_alias'] }}</td> --}}
                                        <td class="text-center">
                                            <div class="bio-content">
                                                <span class="bio-short">{{ Str::limit($coach['bio_alias'], 100) }}</span>
                                                <span class="bio-full"
                                                    style="display: none;">{{ $coach['bio_alias'] }}</span>

                                                @if (strlen($coach['bio_alias']) > 100)
                                                    <a href="javascript:void(0);" class="see-more">See More</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="bio-content">
                                                <span class="bio-short">{{ Str::limit($coach['job_offers'], 100) }}</span>
                                                <span class="bio-full" style="display: none;">{{ $coach['job_offers'] }}</span>
                                                <a href="javascript:void(0);" class="see-more">See More</a>
                                            </div>
                                        </td>
                                        {{-- <td class="text-center">{{ $coach['job_offers'] }}</td> --}}
                                        <td class="text-center">{{ $coach['photo_ai'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['resume'] ?? '' }}</td>
                                        <td class="text-center">{{ $coach['availability'] ?? '' }}</td>
                                        <td class="text-center">
                                            @php 
                                            
                                                // Get all services and split them by comma for displaying in a table format
                                                $servicesArray = $coach->services
                                               
                                                    ->map(function ($item) {
                                                        return optional($item->serviceBelong)->service_name;
                                                    })
                                                    ->toArray();
                                            @endphp

                                            <div class="services-content">
                                                <!-- Display truncated view in the main row -->
                                                <span
                                                    class="services-short">{{ Str::limit(implode(', ', $servicesArray), 50) }}</span>

                                                <!-- Full view in a nested table -->
                                                <table class="nested-table" style="display: none;">
                                                    @for ($i = 0; $i < count($servicesArray); $i += 2)
                                                        <tr>
                                                            <td>{{ $servicesArray[$i] ?? '' }}</td>
                                                            <td>{{ $servicesArray[$i + 1] ?? '' }}</td>
                                                        </tr>
                                                    @endfor
                                                </table>

                                                <!-- Toggle 'See More' button if services exceed the limit -->
                                                @if (count($servicesArray) > 1)
                                                    <a href="javascript:void(0);" class="see-moreservices">See More</a>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /////////see-more 
        document.querySelectorAll('.see-more').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var bioContent = this.previousElementSibling;
                if (bioContent.style.display === "none") {
                    bioContent.style.display = "inline";
                    this.previousElementSibling.previousElementSibling.style.display = "none";
                    this.textContent = "See Less";
                } else {
                    bioContent.style.display = "none";
                    this.previousElementSibling.previousElementSibling.style.display = "inline";
                    this.textContent = "See More";
                }
            });
        });
        ////////////......for nestead services seemore...///////

        document.querySelectorAll('.see-moreservices').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var nestedTable = this.closest('td').querySelector('.nested-table');
                var shortSpan = this.closest('td').querySelector('.services-short');

                if (nestedTable.style.display === "none") {
                    nestedTable.style.display = "table";
                    shortSpan.style.display = "none";
                    this.textContent = "See Less";
                } else {
                    nestedTable.style.display = "none";
                    shortSpan.style.display = "inline";
                    this.textContent = "See More";
                }
            });
        });
    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.see-more').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var bioContent = this.previousElementSibling;
                if (bioContent.style.display === "none") {
                    bioContent.style.display = "inline";
                    this.previousElementSibling.previousElementSibling.style.display = "none";
                    this.textContent = "See Less";
                } else {
                    bioContent.style.display = "none";
                    this.previousElementSibling.previousElementSibling.style.display = "inline";
                    this.textContent = "See More";
                }
            });
        });
    });
</script> --}}
