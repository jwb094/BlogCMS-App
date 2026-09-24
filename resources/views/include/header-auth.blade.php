<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">

    <div class="container">

        <a class="navbar-brand" href={{ route('home') }}>
            BlogSpot
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @if (request()->routeIs('profile.register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.login') }}">
                        Login
                    </a>
                </li>
                @endif

                @if (request()->routeIs('profile.login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.register') }}">
                        Register
                    </a>
                </li>
                @endif


            </ul>
        </div>

    </div>

</nav>
