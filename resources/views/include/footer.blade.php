<div class="{{ request()->routeIs('admin.*') ? 'container-fluid' : 'container-fluid mt-auto' }}">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top ">
        <p class="col-md-4 mb-0 text-body-secondary">© 2026 Company, Inc</p> <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none" aria-label="Bootstrap"> <svg class="bi me-2" width="40" height="32" aria-hidden="true">
                <use xlink:href="#bootstrap"></use>
            </svg> </a>
        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="{{ route('pages.about') }}" class="nav-link px-2 text-body-secondary">About</a></li>
            <li class="nav-item"><a href="{{ route('pages.contact') }}" class="nav-link px-2 text-body-secondary">Contact</a></li>
            <li class="nav-item"><a href="{{ route('pages.terms') }}" class="nav-link px-2 text-body-secondary">Terms</a></li>
            <li class="nav-item"><a href="{{ route('pages.privacy') }}" class="nav-link px-2 text-body-secondary">Privacy</a></li>
        </ul>
    </footer>
</div>
