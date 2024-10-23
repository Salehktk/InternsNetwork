@extends('admin.layouts.master')
<style>
    .dataTables_length select {
        width: 50px !important;
    }
    .btn-success a{
        
        color: white

    }
    .btn-primary a{ 
        color: white;
        text-decoration: none;

    }
    .btn-primary a:hover {
        text-decoration: none;
        color: white;
}
   
</style>

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <div class="container justify-content-center">
            <div class="row justify-content-center mx-3">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header text-center font-weight-bold">All Coaching Setup</div>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- /.card -->
                            </div>

                        </div>
                </div><!-- /.container-fluid -->

                <table class="table table-striped table-responsive-md table-hover table-bordered table-condensed"
                    id="example">
                    <thead class="thead-dark">
                        <tr>

                            <th>Id</th>
                            <th>CR_Code</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>View Feedback</th>

                        </tr>
                    </thead>
                    <tbody>
                      


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



                        @foreach ($user as $new)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $new->identifier }}</td>
                                <td>
                                    @if ($new->status == 0)
                                        <a href="{{ route('coachsetup.edit', $new->id) }}"
                                            class="btn btn-primary btn-dashboard">View</a>
                                    {{-- @elseif($new->status == 1)
                                        <button class="btn btn-primary btn-dashboard" disabled>View</button> --}}
                                    @endif
                                </td>
                                <td>
                                    @if ($new->status == 0)
                                        <span class="badge badge-success">Pending</span>
                                    @elseif($new->status == 1)
                                        <span class="badge badge-danger">Coach Assigned</span>
                                    @elseif ($new->status == 2)
                                    <span class="badge badge-warning">Coach Feedback Received</span>
                                @elseif($new->status == 3)
                                    <span class="badge badge-info">Client Feedback Received</span>
                                @endif
                                </td>
                                <td>
                                    @if ($new->status == 2)
                                    <button  class="btn btn-primary justify-content-center"><a href="{{ route('showFeedback', $new->identifier) }}"> View Feedback</a></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
                {{-- <center><a name="" class="btn btn-success"  href="{{ route('users.create') }}" role="button">Add More</a></center> --}}
                <div id="noRecordFound" class="alert bg-info" style="display:none;">
                    No records found.
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection