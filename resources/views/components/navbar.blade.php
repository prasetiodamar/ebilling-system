<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <button class="btn btn-link text-dark d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="navbar-brand mb-0 h1 d-none d-lg-block">
            @yield('page-title', 'Dashboard')
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <button class="btn btn-link text-dark text-decoration-none dropdown-toggle d-flex align-items-center"
                        type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                         style="width: 35px; height: 35px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="d-none d-md-inline">{{ session('username', 'User') }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>Profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear me-2"></i>Pengaturan
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .dropdown-toggle::after {
        margin-left: 0.5em;
    }
</style>
