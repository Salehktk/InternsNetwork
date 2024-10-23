@extends('admin.layouts.master')
<style>
    .dataTables_length select {
    width: 50px !important;
}

.btn-dashboard {
    padding: 3px 5px !important;
    font-size: 10px !important;
}

</style>
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper ">
    <div class="container justify-content-center">
        <div class="row justify-content-center mx-3">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-header text-center font-weight-bold">All Users</div>
                <section class="content">
            <div class="container-fluid">
                <div class="row">
                    
                    <!-- /.card -->
                    </div>
                   
                </div>
            </div><!-- /.container-fluid -->

                <table class="table table-striped table-responsive-md table-hover table-bordered table-condensed" id="example">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>CR_Code</th>
                            <th>InterviewDetails</th>
                            <th>Client</th>
                            <th>Deadline</th>
                            <th>Service</th>
                            <th>SetupNotes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @foreach ($user as $new)
                        <tr>
                            {{-- @dd( $new->client) --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $new->identifier }}</td>
                            <td>{{ $new->interviewDetails }}</td>
                            <td>{{ $new->client}}</td>
                            <td>{{ $new->deadline }}</td>
                            <td>{{ $new->service }}</td>
                            <td>{{ $new->setupNotes }}</td>
                            
                            <td>
                                <a href="{{ route('coach.edit', $new->id) }}" class="btn btn-primary btn-dashboard">Edit</a>
                            
                                <form action="{{ route('coach.destroy', $new->id) }}" method="POST" class="delete-form" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-dashboard" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
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

