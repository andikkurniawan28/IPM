@extends('template.master')

@section('style')
    <style>
        #preloader {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Monitoring Zona: {{ $zona->nama }}</h4>
        <button id="exportExcelBtn" class="btn btn-success btn-sm mb-3">
            <i class="bi bi-download"></i> Export Excel
        </button>
        <div id="preloader" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="mt-2">Memuat data monitoring...</p>
        </div>
        <div id="titikCards" class="row g-4" data-zona="{{ $zona_id }}">
            <!-- Kartu titik pengamatan akan muncul di sini -->
        </div>
    </div>
@endsection

@section('scripts')
    @include('template.floating-button')
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('titikCards');
            const zonaId = container.getAttribute('data-zona');

            function formatJam(jamStr) {
                return jamStr?.substring(0, 5) || '-';
            }

            function loadTitikPengamatan() {
                const preloader = document.getElementById('preloader');
                const container = document.getElementById('titikCards');

                // Tampilkan preloader dan kosongkan kontainer
                preloader.style.display = 'block';
                container.innerHTML = '';

                fetch(`/monitoring_per_zona/data/${zonaId}`)
                    .then(res => res.json())
                    .then(data => {
                        preloader.style.display = 'none';

                        data.titik_pengamatans.forEach(tp => {
                            const col = document.createElement('div');
                            col.className = 'col-md-4';

                            let headerRow = `<th><small>Jam</small></th>`;
                            tp.parameters.forEach(p => {
                                if (p.jenis === 'kuantitatif') {
                                    headerRow +=
                                        `<th><small>${p.simbol}<sub>(${p.satuan})</sub></small></th>`;
                                } else {
                                    headerRow += `<th><small>${p.simbol}</small></th>`;
                                }
                            });

                            let bodyRows = '';
                            tp.monitorings.forEach(m => {
                                let row = `<td><small>${formatJam(m.jam)}</small></td>`;
                                tp.parameters.forEach(p => {
                                    const val = m['param' + p.id];
                                    row += `<td>${val ?? '-'}</td>`;
                                });
                                bodyRows += `<tr>${row}</tr>`;
                            });

                            // Jika tidak ada monitoring
                            if (tp.monitorings.length === 0) {
                                const colspan = 1 + tp.parameters.length;
                                bodyRows =
                                    `<tr><td colspan="${colspan}"><small>Tidak ada data</small></td></tr>`;
                            }

                            // Baris agregasi
                            let agregasiRow = `<td><small><strong>Agregasi</strong></small></td>`;
                            tp.parameters.forEach(p => {
                                const val = tp.agregasi?.['param' + p.id];
                                agregasiRow += `<td><strong>${(val ?? '-')}</strong></td>`;
                            });

                            col.innerHTML = `
                    <div class="card bg-light shadow-sm h-100">
                        <div class="card-body">
                            <a href="/monitoring_per_titik/${tp.id}">
                                <h5 class="card-title text-dark">${tp.kode}| ${tp.nama}</h5>
                            </a>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-secondary">
                                        <tr>${headerRow}</tr>
                                    </thead>
                                    <tbody>
                                        ${bodyRows}
                                        <tr class="table-info">${agregasiRow}</tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;

                            container.appendChild(col);
                        });
                    })
                    .catch(error => {
                        console.error('Gagal memuat data:', error);
                        preloader.innerHTML = `<div class="alert alert-danger">Gagal memuat data.</div>`;
                    });
            }

            loadTitikPengamatan();
            setInterval(loadTitikPengamatan, 60000);
        });
    </script>

    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            const container = document.querySelector('.container-fluid.py-0.px-6');
            const tables = container.querySelectorAll('table');

            if (!tables.length) {
                alert('Tidak ada tabel untuk diekspor.');
                return;
            }

            const wb = XLSX.utils.book_new();

            tables.forEach((table, idx) => {
                const ws = XLSX.utils.table_to_sheet(table);
                const card = table.closest('.card');
                const titleEl = card?.querySelector('.card-title');

                let sheetName = `Titik ${idx + 1}`;
                if (titleEl) {
                    sheetName = titleEl.textContent.trim().substring(0, 31);
                }

                XLSX.utils.book_append_sheet(wb, ws, sheetName);
            });

            const periode = '{{ session('periode') ?? 'periode_tidak_ditemukan' }}';
            const namaZona = '{{ $zona->nama }}'.replace(/\s+/g, '_');
            XLSX.writeFile(wb, `Monitoring_Zona_${namaZona}_${periode}.xlsx`);
        });
    </script>
@endsection
