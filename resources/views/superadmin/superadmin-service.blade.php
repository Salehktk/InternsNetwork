@extends('admin.layouts.master')


@section('content')

<div class="content-wrapper ">


    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">  </h4>
            </div>
            <div class="card-body">
                {{-- @dd($selectedCoach) --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="text-center">Services</th>
                                <th class="text-center">Name of service</th>
                                <th class="text-center">All Services</th>
                               
                                
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @dd($allService) --}}

                            @foreach ($allService as $service)
                            {{-- @dd($service) --}}

                          
                            <tr>
                            <td class="text-center">{{ $service['service'] }}</td>
                            <td class="text-center">{{ $service['name_of_service'] }}</td>
                            {{-- <td class="text-center">{{ $service['fx'] }}</td> --}}
                            <td class="text-center">
                                @php
                                // dd($item->serviceBelongtopivot);
                                    $servicesArray = $service->allservice
                                    
                                        ->map(function ($item) {
                                            return optional($item->serviceBelongtopivot)->service_name;
                                        })
                                        ->toArray();


                                        ///
                                         $valuesArray = $service->allservice
                                        ->map(function ($item) {
                                            
                                            return $item->value;
                                        })
                                        ->toArray();
                                        
                                @endphp

                                <div class="services-content">
                                    <!-- Display truncated view in the main row -->
                                    <span
                                        class="services-short">{{ Str::limit(implode(', ', $servicesArray), 50) }}</span>

                                    <!-- Full view in a nested table -->
                                    <table class="nested-table" style="display: none;">
                                      
                                        @for ($i = 0; $i < count($servicesArray); $i += 177) 
                                            <tr>
                                                @for ($j = $i; $j < $i + 177 && $j < count($servicesArray); $j++)
                                                    <td>{{ $servicesArray[$j] ?? '' }}</td>
                                                @endfor
                                            </tr>
                                        @endfor
                                     
                                        @for ($i = 0; $i < count($valuesArray); $i += 177) <!-- Adjust number of values per row as needed -->
                                        <tr>
                                            @for ($j = $i; $j < $i + 177 && $j < count($valuesArray); $j++)
                                                <td>{{ $valuesArray[$j] ?? '' }}</td>
                                            @endfor
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
                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>

document.addEventListener('DOMContentLoaded', function() {
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