{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm ">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="#">MyBrand</a>

        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMobile" data-bs-auto-close="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNavMobile">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

            </ul>
        </div>

    </div>
</nav> --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">

    <div class="container">

        <a class="navbar-brand" href="#">
            MyApp
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Contacts
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Reports
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        John Smith
                    </a>

                    <ul class="dropdown-menu dropdown-menu-lg-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                My Profile
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                Logout
                            </a>
                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>