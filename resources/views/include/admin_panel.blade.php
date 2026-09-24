<aside class="admin-sidebar d-flex flex-column p-3" id="adminSidebar">

    <!-- Sidebar Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">

        <span class="text-white text-decoration-none fs-4 fw-bold">
            Admin Panel
        </span>

        <button class="btn btn-outline-light sidebar-close" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Toggle navigation">
            &times;
        </button>

    </div>


    <!-- Navigation -->
    <nav class="nav flex-column">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="me-2">
                <i class="bi bi-bar-chart-line"></i>
            </span>
            Dashboard
        </a>


        <!-- Posts -->
        <a href="{{ route('admin.post.index') }}" class="nav-link {{ request()->routeIs('admin.post.*') ? 'active' : '' }}">
            <span class="me-2">
                <i class="bi bi-collection-fill"></i>
            </span>
            Posts
        </a>


        <!-- Media -->
        <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
            <span class="me-2">
                <i class="bi bi-image-fill"></i>
            </span>
            Media
        </a>


        <!-- Categories -->
        <a href="{{ route('admin.category.index') }}" class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
            <span class="me-2">
                <i class="bi bi-bookmark"></i>
            </span>
            Categories
        </a>


        <!-- Tags -->
        <a href="{{ route('admin.tags.index') }}" class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
            <span class="me-2">
                <i class="bi bi-tags"></i>
            </span>
            Tags
        </a>


        <!-- Profile Dropdown -->
        <div class="nav-item dropdown">

            <a href="#" class="nav-link dropdown-toggle
                    {{ request()->routeIs('admin.profile.*', 'admin.profile.password') ? 'active' : '' }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">
                    <i class="bi bi-person-circle"></i>
                </span>
                Profile
            </a>

            <ul class="dropdown-menu">

                <!-- Update Profile -->
                <li>
                    <a class="dropdown-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}" href="{{ route('admin.profile.edit',auth()->user()->id) }}">
                        <i class="bi bi-person me-2"></i>
                        Update Profile
                    </a>
                </li>

                <!-- Change Password -->
                <li>
                    <a class="dropdown-item {{ request()->routeIs('admin.profile.password_change') ? 'active' : '' }}" href="{{ route('admin.profile.password_change',auth()->user()->id) }}">
                        <i class="bi bi-key me-2"></i>
                        Change Password
                    </a>
                </li>

            </ul>

        </div>

    </nav>


    <!-- Bottom Navigation -->
    <div class="mt-auto">

        <hr class="border-secondary">

        {{-- <a href="{{ route('admin.profile.logout') }}" class="nav-link">
        <span class="me-2">
            <i class="bi bi-box-arrow-right"></i>
        </span>
        Logout
        </a> --}}
        <form method="POST" action="{{ route('admin.profile.logout') }}">
            @csrf
            <button type="submit" class="nav-link">
                <span class="me-2">
                    <i class="bi bi-box-arrow-right"></i>
                </span>
                Logout
            </button>
        </form>
    </div>

</aside>
