<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/newlogo.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><strong>Form</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="image">
                <img src="{{ asset('images/admin_icon.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item"><a href="#" class="d-block">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <li class="nav-item">
                                    <a href="#" type="button" id="edit-profile-btn" class=""
                                        class="d-block" data-toggle="modal" data-target="#profile-btn-modal"><i
                                            class="nav-icon far fa-id-card"></i>
                                        My Profile
                                    </a>
                                </li>
                            </ul>
                        </a></li>
                </ul>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @php
                    $user = Auth::user();
                @endphp




                @php
                    $user = Auth::user();
                @endphp

                @if ($user->hasRole('superadmin'))
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ Request::is('/dashboard') ? 'active' : '' }} nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                    <li class="nav-item">
                        <a href="{{ route('coaches.index') }}"
                            class="{{ Request::is('coaches') ? 'active' : '' }} nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>All Coaches</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('services.index') }}"
                            class="{{ Request::is('services') ? 'active' : '' }} nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>All Services</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
