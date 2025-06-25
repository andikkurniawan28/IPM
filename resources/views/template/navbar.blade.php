<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('dashboard') }}">
            <i class="bi bi-graph-up"></i> In-Process Monitoring
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="masterMenu" role="button" data-bs-toggle="dropdown">
                        ⚙️ Master
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="masterMenu">
                        <li><a class="dropdown-item" href="{{ route('kategori_parameter.index') }}">📂 Kategori Parameter</a></li>
                        <li><a class="dropdown-item" href="{{ route('satuan.index') }}">📏 Satuan</a></li>
                        <li><a class="dropdown-item" href="{{ route('parameter.index') }}">📊 Parameter</a></li>
                        <li><a class="dropdown-item" href="{{ route('zona.index') }}">🗺️ Zona</a></li>
                        <li><a class="dropdown-item" href="{{ route('titik_pengamatan.index') }}">📍 Titik Pengamatan</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="transaksiMenu" role="button" data-bs-toggle="dropdown">
                        🧾 Input
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="transaksiMenu">
                        <li><a class="dropdown-item" href="{{ route('monitoring.index') }}">👁️ Monitoring</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="laporanMenu" role="button" data-bs-toggle="dropdown">
                        📈 Laporan
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="laporanMenu">
                        <li><span class="dropdown-item text-muted">Coming soon...</span></li>
                    </ul>
                </li>

            </ul>

            <span class="navbar-text small text-muted">
                <i class="bi bi-clock"></i> {{ now()->format('d M Y, H:i') }}
            </span>
        </div>
    </div>
</nav>

<!-- Tambahkan Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
