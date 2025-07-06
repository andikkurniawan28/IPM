@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Monitoring Semua</h4>
        <button id="exportExcelBtn" class="btn btn-success btn-sm mb-3">
            <i class="bi bi-download"></i> Export Excel
        </button>
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
                fetch('/api/dashboard')
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById('titikCards');
                        container.innerHTML = '';

                        data.titik_pengamatans.forEach(tp => {
                            const col = document.createElement('div');
                            col.className = 'col-md-4';

                            // Buat header kolom parameter
                            let headerRow =
                                `<th><small>Jam</small></th>`;
                            tp.parameters.forEach(p => {
                                if (p.jenis === 'kuantitatif') {
                                    headerRow +=
                                        `<th><small>${p.simbol}<sub>(${p.satuan})</sub></small></th>`;
                                } else {
                                    headerRow += `<th><small>${p.simbol}</small></th>`;
                                }
                            });

                            // Buat baris data monitoring
                            let bodyRows = '';
                            tp.monitorings.forEach(m => {
                                let row =
                                    `<td><small>${formatJam(m.jam)}</small></td>`;
                                tp.parameters.forEach(p => {
                                    const val = m['param' + p.id];
                                    row += `<td>${val ?? '-'}</td>`;
                                });
                                bodyRows += `<tr>${row}</tr>`;
                            });

                            // Jika tidak ada monitoring, tampilkan baris kosong
                            if (tp.monitorings.length === 0) {
                                let emptyRow =
                                    `<td colspan="${2 + tp.parameters.length}"><small>Tidak ada data</small></td>`;
                                bodyRows = `<tr>${emptyRow}</tr>`;
                            }

                            col.innerHTML = `
                        <div class="card bg-light shadow-sm h-100">
                            <div class="card-body">
                                <a href="/monitoring_per_titik/${tp.id}">
                                    <h5 class="card-title text-dark">${tp.kode}| ${tp.nama}</h5>
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
                    });
            }

            loadTitikPengamatan();
            setInterval(loadTitikPengamatan, 60000); // refresh tiap 1 menit
        });
    </script>
    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            const container = document.querySelector('.container-fluid.py-0.px-6');

            if (!container) {
                alert('Kontainer tidak ditemukan.');
                return;
            }

            // Buat workbook baru
            const wb = XLSX.utils.book_new();
            let sheetIndex = 1;

            // Ambil semua table di dalam container
            const tables = container.querySelectorAll('table');

            if (tables.length === 0) {
                alert('Tidak ada tabel untuk diekspor.');
                return;
            }

            // tables.forEach((table, idx) => {
            //     const ws = XLSX.utils.table_to_sheet(table);
            //     const titleEl = card.querySelector('.card-title');
            //     const sheetName = `Titik ${sheetIndex++}`;
            //     XLSX.utils.book_append_sheet(wb, ws, sheetName);
            // });

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
            XLSX.writeFile(wb, `Monitoring_${periode}.xlsx`);
        });
    </script>
@endsection
