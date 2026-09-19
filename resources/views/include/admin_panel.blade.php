<aside class="admin-sidebar d-flex flex-column p-3" id="adminSidebar">

    <!-- Sidebar Header -->

    <div class="d-flex align-items-center justify-content-between mb-4">

        <a href="#" class="text-white text-decoration-none fs-4 fw-bold">
            Admin Panel
        </a>

        <button {{-- type="button"
            class="btn btn-outline-light sidebar-close"
            id="sidebarClose"
            data-bs-dismiss="offcanvas"
            aria-label="Close navigation" --}} class="btn btn-outline-light sidebar-close" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar" aria-label="Toggle navigation">
            &times;
        </button>

    </div>


    <!-- Navigation -->

    <nav class="nav flex-column">

        <a href={{ route('admin.dashboard') }} @if(request()->is('admin/dashboard'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif
            >
            <span class="me-2"><i class="bi bi-bar-chart-line"></i></span>
            Dashboard
        </a>

        <a href={{ route('admin.post.index') }} @if(request()->is('admin/posts*'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif
            >
            <span class="me-2"><i class="bi bi-person-lines-fill"></i></span>
            Posts
        </a>

        <a href={{ route('admin.media.index') }} @if(request()->is('admin/media*'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif>
            <span class="me-2"><i class="bi bi-collection-fill"></i></span>
            Media
        </a>

        <a href={{ route('admin.category.index') }}
            @if(request()->is('admin/category*'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif
        >
            <span class="me-2"><i class="bi bi-bookmark"></i></span>
            Categories
        </a>

        <a href={{ route('admin.tags.index') }}
             @if(request()->is('admin/tags*'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif
        >
            <span class="me-2"><i class="bi bi-tags"></i></span>
            Tags
        </a>

        <a href={{ route('admin.profile') }}
             @if(request()->is('admin/profile*'))
            class="nav-link active"
            @else
            class="nav-link"
            @endif
        >
            <span class="me-2"><i class="bi bi-tags"></i></span>
            Profile
        </a>

    </nav>


    <!-- Bottom Navigation -->

    <div class="mt-auto">

        <hr class="border-secondary">

        <a href="#" class="nav-link">
            <span class="me-2">🚪</span>
            Logout
        </a>

    </div>

</aside>
