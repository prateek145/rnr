<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('backend.home') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('public/backend/dashmin/img/user.jpg') }}" alt=""
                    style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('backend.home') }}" class="nav-item nav-link {{ (request()->is('home')) ? 'active' : '' }}"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-laptop me-2"></i>Audit</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('audits.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('audits.create') }}" class="dropdown-item">New</a>

                </div>
            </div> --}}

            <div class="nav-item dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle {{ (request()->is('users*')) ? 'active' : '' }}" data-bs-toggle="dropdown"><i
                        class="fa fa-user me-2"></i>Users</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    {{-- <a href="{{ route('users.create') }}" class="dropdown-item">New</a> --}}

                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle {{ (request()->is('application*')) ? 'active' : '' }}" data-bs-toggle="dropdown"><i
                        class="fa fa-tasks me-2"></i>Applications</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('application.index') }}" class="dropdown-item">View All</a>
                    {{-- <a href="{{ route('application.create') }}" class="dropdown-item">New</a> --}}

                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle {{ (request()->is('group*')) ? 'active' : '' }}" data-bs-toggle="dropdown"><i
                        class="fa fa-exclamation-triangle me-2"></i>Groups</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('group.index') }}" class="dropdown-item">View All</a>
                    {{-- <a href="{{ route('group.create') }}" class="dropdown-item">New</a> --}}

                </div>
            </div>

            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-cog me-2"></i>Application's Setting</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('users.create') }}" class="dropdown-item">New</a>

                </div>
            </div> --}}

            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-file-import me-2"></i>Import</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('users.create') }}" class="dropdown-item">New</a>

                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-user me-2"></i>Integration</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('users.create') }}" class="dropdown-item">New</a>

                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-user me-2"></i>Logs</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('users.create') }}" class="dropdown-item">New</a>

                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-user me-2"></i>MFA</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('users.index') }}" class="dropdown-item">View All</a>
                    <a href="{{ route('users.create') }}" class="dropdown-item">New</a>

                </div>
            </div> --}}
        </div>
    </nav>
</div>
