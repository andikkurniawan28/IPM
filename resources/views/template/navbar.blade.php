{{-- <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top"> --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-light fs-4" href="{{ route('dashboard') }}">
            <i class="bi bi-graph-up"></i> MDP
        </a>
        <style>
            .navbar-toggler {
                background-color: #f8f9fa;
                /* warna terang */
            }

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%280,0,0,0.7%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
            }
        </style>
        <button class="navbar-toggler border border-secondary" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="monitoringMenu" role="button"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-activity"></i> Monitoring
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="monitoringMenu">
                        <li>
                            <h6 class="dropdown-header">Semua</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('monitoring_all') }}">
                                <i class="bi bi-eye"></i> Semua
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header">Per Kategori</h6>
                        </li>
                        @foreach ($semua_kategori_parameter as $kategori)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('monitoring_per_kategori.index', $kategori->id) }}">
                                    <i class="bi bi-tags"></i> {{ $kategori->nama }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header">Per Zona</h6>
                        </li>
                        @foreach ($semua_zona as $zona)
                            <li>
                                <a class="dropdown-item" href="{{ route('monitoring_per_zona.index', $zona->id) }}">
                                    <i class="bi bi-geo-alt"></i> {{ $zona->nama }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- MENU INPUT --}}
                @if (auth()->check() && auth()->user()->role->izin_akses_input)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="transaksiMenu" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-receipt"></i> Input
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="transaksiMenu">
                            <li>
                                <a class="dropdown-item" href="{{ route('monitoring.index') }}">
                                    <i class="bi bi-eye"></i> Monitoring
                                </a>
                                {{-- <a class="dropdown-item" href="{{ route('input_monitoring_log') }}">
                                    <i class="bi bi-clock-history"></i> Input Log
                                </a> --}}
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- MENU LAPORAN --}}
                {{-- @if (auth()->check() && auth()->user()->role->izin_akses_laporan)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="laporanMenu" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-bar-chart-line"></i> Laporan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="laporanMenu">
                            <li>
                                <span class="dropdown-item text-muted">
                                    <i class="bi bi-clock-history"></i> Coming soon...
                                </span>
                            </li>
                        </ul>
                    </li>
                @endif --}}

                {{-- MENU MASTER --}}
                @if (auth()->check() && auth()->user()->role->izin_akses_master)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="masterMenu" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-gear-fill"></i> Master
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="masterMenu">
                            <li><a class="dropdown-item" href="{{ route('kategori_parameter.index') }}"><i
                                        class="bi bi-folder2-open"></i> Kategori Parameter</a></li>
                            <li><a class="dropdown-item" href="{{ route('satuan.index') }}"><i class="bi bi-rulers"></i> Satuan</a></li>
                            <li><a class="dropdown-item" href="{{ route('jenis_pilihan_kualitatif.index') }}"><i
                                        class="bi bi-check-circle"></i> Jenis Pilihan Kualitatif</a></li>
                            <li><a class="dropdown-item" href="{{ route('parameter.index') }}"><i class="bi bi-graph-up"></i> Parameter</a></li>
                            <li><a class="dropdown-item" href="{{ route('zona.index') }}"><i class="bi bi-map"></i> Zona</a></li>
                            <li><a class="dropdown-item" href="{{ route('titik_pengamatan.index') }}"><i class="bi bi-geo-alt-fill"></i> Titik Pengamatan</a></li>
                            <li><a class="dropdown-item" href="{{ route('role.index') }}"><i class="bi bi-shield-lock-fill"></i> Role</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.index') }}"><i class="bi bi-person-circle"></i> User</a></li>
                        </ul>
                    </li>
                @endif

                {{-- MENU DOKUMENTASI --}}
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ asset('doc/doc.pdf') }}" target="_blank">
                        <i class="bi bi-file-earmark-text"></i> Dokumentasi
                    </a>
                </li>


            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                    Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Tambahkan Bootstrap Icons CDN jika belum -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
