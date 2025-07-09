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
        <h4 class="mb-4">Monitoring Kategori: {{ $kategori_parameter->nama }}</h4>
        <button id="exportExcelBtn" class="btn btn-success btn-sm mb-3">
            <i class="bi bi-download"></i> Export Excel
        </button>
        <div id="preloader" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="mt-2">Memuat data monitoring...</p>
        </div>
        <div id="titikCards" class="row g-4">
            <!-- Kartu titik pengamatan akan muncul di sini -->
        </div>
    </div>
@endsection

@section('scripts')
    @include('template.floating-button')
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function formatJam(jamStr) {
                return jamStr?.substring(0, 5) || '-';
            }

            function loadTitikPengamatan() {
                const container = document.getElementById('titikCards');
                const preloader = document.getElementById('preloader');

                // Tampilkan preloader dan kosongkan kontainer
                preloader.style.display = 'block';
                container.innerHTML = '';

                fetch(`/monitoring_per_kategori/data/{{ $kategori_parameter->id }}`)
                    .then(res => res.json())
                    .then(data => {
                        preloader.style.display = 'none';

                        data.titik_pengamatans.forEach(tp => {
                            const col = document.createElement('div');
                            col.className = 'col-md-' + tp.lebar;

                            // Header parameter
                            let headerRow = `<th><small>Jam</small></th>`;
                            tp.parameters.forEach(p => {
                                headerRow +=
                                    `<th><small>${p.simbol}${p.satuan ? `<sub>(${p.satuan})</sub>` : ''}</small></th>`;
                            });

                            // Baris monitoring
                            let bodyRows = '';
                            tp.monitorings.forEach(m => {
                                let row = `<td><small>${formatJam(m.jam)}</small></td>`;
                                tp.parameters.forEach(p => {
                                    const val = m['param' + p.id];
                                    row += `<td>${val ?? '-'}</td>`;
                                });
                                bodyRows += `<tr>${row}</tr>`;
                            });

                            // Baris jika tidak ada data
                            if (tp.monitorings.length === 0) {
                                const colspan = tp.parameters.length + 1;
                                bodyRows =
                                    `<tr><td colspan="${colspan}"><small>Tidak ada data</small></td></tr>`;
                            }

                            // Agregasi row
                            let agregasiRow = `<td><small>Agr</small></td>`;
                            tp.parameters.forEach(p => {
                                const val = tp.agregasi?.['param' + p.id];
                                agregasiRow += `<td><small>${val ?? '-'}</small></td>`;
                            });

                            col.innerHTML = `
                    <div class="card bg-light shadow-sm h-100">
                        <div class="card-body">
                            <a href="/monitoring_per_titik/${tp.id}">
                                <h5 class="card-title text-dark">${tp.kode} | ${tp.nama}</h5>
                            </a>
                            <a href="/monitoring_per_zona/${tp.zona?.id}">
                                <p class="card-text"><small>@${tp.zona?.nama}</small></p>
                            </a>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-secondary">
                                        <tr>${headerRow}</tr>
                                    </thead>
                                    <tbody>
                                        ${bodyRows}
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>${agregasiRow}</tr>
                                    </tfoot>
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
            setInterval(loadTitikPengamatan, 60000); // refresh tiap 1 menit
        });
    </script>

    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            const container = document.querySelector('.container-fluid.py-0.px-6');
            const wb = XLSX.utils.book_new();
            const tables = container.querySelectorAll('table');

            if (tables.length === 0) {
                alert('Tidak ada tabel untuk diekspor.');
                return;
            }

            tables.forEach((table, idx) => {
                const ws = XLSX.utils.table_to_sheet(table);
                const card = table.closest('.card');
                const titleEl = card?.querySelector('.card-title');

                let sheetName = `Titik ${idx + 1}`;
                if (titleEl) {
                    sheetName = titleEl.textContent.trim().substring(0, 31); // Excel max 31 karakter
                }

                XLSX.utils.book_append_sheet(wb, ws, sheetName);
            });

            const periode = '{{ session('periode') ?? 'periode_tidak_ditemukan' }}';
            const namaKategori = '{{ Str::slug($kategori_parameter->nama, '_') }}';
            XLSX.writeFile(wb, `Monitoring_${namaKategori}_${periode}.xlsx`);
        });
    </script>
@endsection
