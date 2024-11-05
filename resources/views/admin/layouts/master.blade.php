<!DOCTYPE html>
<html lang="en">
{{-- head --}}
<link rel="icon" href="{{ asset('images/newlogo.png') }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>

@include('admin.layouts.master.head')
{{-- body --}}
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
   
    <div class="wrapper">
    @yield('style')
        {{-- header --}}
        @include('admin.layouts.master.header')
      
        {{-- sidebar --}}
        @include('admin.layouts.master.sidebar') 
        {{-- main --}}
       @include('layouts.app')
        {{-- footer --}}
        @include('admin.layouts.master.footer')
         @yield('script')
    </div>
    <!-- ./wrapper -->
   
</body>
</html>





