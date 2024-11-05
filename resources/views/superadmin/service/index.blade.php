@extends('admin.layouts.master')


@section('content')

<div class="content-wrapper ">


    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">All Services</h4>
            </div>
            <div class="card-body">
                {{-- @dd($selectedCoach) --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th class="text-center">Service Name</th>
                                <th class="text-center">Display Order</th>
                                <th class="text-center">Subscriber Level</th>
                                <th class="text-center"> Type</th>
                                <th class="text-center"> Price</th>
                                <th class="text-center"> Description</th>
                                <th class="text-center"> Image</th>
                                <th class="text-center"> Bio</th>
                            </tr>
                        </thead>
                     
                        <tbody>
                            @foreach ($AllServices as $service)
                           
                            <tr>
                            <td class="text-center">{{ $service->service_name }}</td>
                            <td class="text-center">{{ $service->display_order }}</td>
                            <td class="text-center">{{ $service->subscriber_level }}</td>
                            <td class="text-center">{{ $service->service_type }}</td>
                            <td class="text-center">{{ $service->service_price }}</td>
                            <td class="text-center">{{ $service->service_description }}</td>
                            <td class="text-center">{{ $service->service_image }}</td>
                            <td class="text-center">{{ $service->service_bio }}</td>
                        
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