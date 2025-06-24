<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-2 text-info" href="{{ route('dashboard') }}">In-Process Monitoring</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ipmNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="ipmNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Navigation Bar Content -->
                <div class="d-flex flex-row gap-3 align-items-start">
                    <!-- Master Menu Accordion -->
                    <div class="accordion" id="masterAccordion" style="min-width: 220px;">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="masterHeading">
                                <button
                                    class="accordion-button collapsed bg-secondary bg-gradient text-white fw-bold px-3 py-2 rounded shadow-sm"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#masterCollapse"
                                    aria-expanded="false" aria-controls="masterCollapse" style="font-size: 1rem;">
                                    ⚙️ Master
                                </button>
                            </h2>
                            <div id="masterCollapse" class="accordion-collapse collapse" aria-labelledby="masterHeading"
                                data-bs-parent="#masterAccordion">
                                <div class="accordion-body px-2 py-2 bg-dark border rounded shadow-sm">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-light fw-semibold px-3 py-2 rounded hover-highlight"
                                                href="{{ route('kategori_parameter.index') }}">
                                                📂 Kategori Parameter
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-light fw-semibold px-3 py-2 rounded hover-highlight"
                                                href="{{ route('satuan.index') }}">
                                                📏 Satuan
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-light fw-semibold px-3 py-2 rounded hover-highlight"
                                                href="{{ route('parameter.index') }}">
                                                📊 Parameter
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-light fw-semibold px-3 py-2 rounded hover-highlight"
                                                href="{{ route('zona.index') }}">
                                                🗺️ Zona
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-light fw-semibold px-3 py-2 rounded hover-highlight"
                                                href="{{ route('titik_pengamatan.index') }}">
                                                📍 Titik Pengamatan
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Menu Accordion -->
                    <div class="accordion" id="transaksiAccordion" style="min-width: 220px;">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="transaksiHeading">
                                <button
                                    class="accordion-button collapsed bg-info bg-gradient text-white fw-bold px-3 py-2 rounded shadow-sm"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#transaksiCollapse"
                                    aria-expanded="false" aria-controls="transaksiCollapse" style="font-size: 1rem;">
                                    🧾 Input
                                </button>
                            </h2>
                            <div id="transaksiCollapse" class="accordion-collapse collapse"
                                aria-labelledby="transaksiHeading" data-bs-parent="#transaksiAccordion">
                                <div class="accordion-body px-2 py-2 bg-dark border rounded shadow-sm">
                                    <ul class="nav flex-column">
                                        <!-- Kosong -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Laporan Menu Accordion -->
                    <div class="accordion" id="laporanAccordion" style="min-width: 220px;">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="laporanHeading">
                                <button
                                    class="accordion-button collapsed bg-warning bg-gradient text-dark fw-bold px-3 py-2 rounded shadow-sm"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#laporanCollapse"
                                    aria-expanded="false" aria-controls="laporanCollapse" style="font-size: 1rem;">
                                    📈 Laporan
                                </button>
                            </h2>
                            <div id="laporanCollapse" class="accordion-collapse collapse"
                                aria-labelledby="laporanHeading" data-bs-parent="#laporanAccordion">
                                <div class="accordion-body px-2 py-2 bg-dark border rounded shadow-sm">
                                    <ul class="nav flex-column">
                                        <!-- Kosong -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </ul>

            <span class="navbar-text small text-muted">
                {{ now()->format('d M Y, H:i') }}
            </span>
        </div>

        <style>
            .hover-highlight:hover {
                background-color: #0dcaf0 !important;
                color: #000 !important;
            }
        </style>


    </div>
</nav>

<style>
    .hover-highlight:hover {
        background-color: #0dcaf0 !important;
        /* Bootstrap info */
        color: #000 !important;
    }
</style>
