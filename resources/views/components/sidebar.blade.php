<div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
    <div class="sidebar-header p-3 border-bottom border-secondary">
        <h4 class="mb-0">
            <i class="bi bi-receipt me-2"></i>E-Billing
        </h4>
        <small class="text-muted">Management System</small>
    </div>

    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>

            @if(session('role') === 'admin')

            <!-- Infrastruktur FTTH Section -->
            <li class="nav-item mb-1 mt-3">
                <small class="text-muted px-3">INFRASTRUKTUR</small>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('ftth.pop.index') }}" class="nav-link text-white {{ request()->routeIs('ftth.pop.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-building me-2"></i>POP
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('ftth.olt.index') }}" class="nav-link text-white {{ request()->routeIs('ftth.olt.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-router me-2"></i>OLT
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('ftth.odc.index') }}" class="nav-link text-white {{ request()->routeIs('ftth.odc.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-hdd-network me-2"></i>ODC
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('ftth.odp.index') }}" class="nav-link text-white {{ request()->routeIs('ftth.odp.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-diagram-3 me-2"></i>ODP
                </a>
            </li>


            <!-- Pelanggan & Billing Section -->
            <li class="nav-item mb-1 mt-3">
                <small class="text-muted px-3">PELANGGAN & BILLING</small>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('pelanggan.index') }}" class="nav-link text-white {{ request()->routeIs('pelanggan.*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-people-fill me-2"></i>Pelanggan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-wifi me-2"></i>Paket Internet
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-file-earmark-text me-2"></i>Tagihan
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-cash-coin me-2"></i>Transaksi
                </a>
            </li>

            <!-- Monitoring & Support Section -->
            <li class="nav-item mb-1 mt-3">
                <small class="text-muted px-3">MONITORING & SUPPORT</small>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-activity me-2"></i>Monitoring PPPoE
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-ticket-detailed me-2"></i>Tiket Support
                </a>
            </li>

            <!-- System Section -->
            <li class="nav-item mb-1 mt-3">
                <small class="text-muted px-3">SYSTEM</small>
            </li>

            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-gear-fill me-2"></i>Pengaturan
                </a>
            </li>
            @endif
        </ul>
    </div>

    <div class="sidebar-footer p-3 border-top border-secondary mt-auto">
        <div class="d-flex align-items-center">
            <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <small class="d-block fw-semibold">{{ session('username', 'User') }}</small>
                <small class="text-muted">{{ ucfirst(session('role', 'guest')) }}</small>
            </div>
        </div>
    </div>
</div>

<style>
    .sidebar {
        display: flex;
        flex-direction: column;
    }
    .sidebar-menu {
        flex: 1;
        overflow-y: auto;
    }
    .nav-link {
        border-radius: 8px;
        transition: all 0.3s;
    }
    .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
    }
    .nav-link.active {
        background-color: #0d6efd !important;
    }
</style>
