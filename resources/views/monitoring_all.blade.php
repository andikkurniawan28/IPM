@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Monitoring Semua</h4>
        <div id="titikCards" class="row g-4">
            <!-- Kartu titik pengamatan akan muncul di sini -->
        </div>
    </div>
@endsection

@section('scripts')
    @include('template.floating-button')
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
                                headerRow +=
                                    `<th><small>${p.simbol}<sub>(${p.satuan})</sub></small></th>`;
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
                                <h5 class="card-title text-dark">${tp.nama}</h5>
                                <p class="card-text"><small>@${tp.zona?.nama}</small></p>
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
@endsection
