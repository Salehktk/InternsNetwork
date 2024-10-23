@extends('layouts.app')

@section('content')
    <h1>Welcome to your dashboard, {{ Auth::user()->name }}!</h1>
    <!-- You can add user-specific data and components here -->
@endsection