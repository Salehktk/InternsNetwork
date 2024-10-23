
{{-- @dd($servicesWithIndex); --}}
@foreach ($uniquePaginator as $service)

    @php
        // $serviceId = $service[6] ?? ''; // Adjust index for service ID if necessary
        $imageUrl = $service[5] ?? '';
        $Serviceprice = $service[3] ?? '';
        $ServiceId  = $service['id'] ?? '';

    @endphp
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3 service-card" data-title="{{ $service[1] }}">
        <div class="card job-detail-card">
            <!-- Make the entire card clickable -->
          {{--   <a href="{{ route('SingleService.view', $service['id']) }}" style="text-decoration: none; color: inherit;"> --}}
           
                <div class="card-body jobs-body">
                    <div class="best-course-pic relative-position">
                        @if ($imageUrl)
                            <!-- Directly show the image -->
                            <img src="{{ $imageUrl }}" alt="Service Image" class="img-fluid">
                        @else
                            <!-- Show placeholder text if no image is available -->
                            <div class="no-image">No image available</div>
                        @endif
                        {{-- <div class="trend-badge-2">
                            <i class="fas fa-bolt"></i> Trending
                        </div> --}}
                        <div class="course-price">
                            ${{ $service[3] }}
                        </div>
                        <ul class="course-rate">
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                        </ul>
                    </div>
                    <h4 class="card-title">{{ $service[0] }}</h4>
                    <div class="mt-2 mb-4"></div>
                    <span class="course-filter text-start text-white" style="background-color: #FF5A00;">{{ $service[1] }}</span>
                    <span class="course-type text-end text-white bg-info">{{ $service[2] }}</span>
                  
                    <div class="mt-2 mb-4"></div>
                    <h6 class="card-title">{{ $service[4] }}</h6>
                    {{-- <button type="button" onclick ="addToCart({{$Serviceprice}}, {{$ServiceId}}),'{{ $service[0] }}')" class="btn btn-primary">Add to Cart</button> --}}
                    {{-- <button type="button" onclick="addToCart({{ $Serviceprice }}, {{ $service['id']  }}, '{{ $service[0] }}')" class="btn btn-primary">Add to Cart</button> --}}

                </div>
            {{-- </a> --}}
           
        </div>
    </div>
@endforeach

<!-- pagination -->
<div class="mt-4 d-flex justify-content-center ">
    {{ $uniquePaginator->links() }}
</div>

