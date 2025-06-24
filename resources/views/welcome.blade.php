@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Dashboard</h4>
        <div id="titikCards" class="row g-4">
            <!-- Kartu titik pengamatan akan muncul di sini -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function formatTime(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
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

                            let headerCells = '<th><small>Time</small></th>';
                            let valueCells =
                                `<td><small>${tp.updated_at ? formatTime(tp.updated_at) : '-'}</small></td>`;

                            tp.parameter_titik_pengamatans.forEach(param => {
                                headerCells +=
                                    `<th><small>${param.parameter.simbol}</small></th>`;
                                valueCells +=
                                    `<td>-</td>`; // Ganti '-' dengan param.nilai jika tersedia
                            });

                            col.innerHTML = `
                        <div class="card bg-light shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-dark">${tp.nama}</h5>
                                <p class="card-text"><small>@${tp.zona.nama}</small></p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm mb-0">
                                        <thead class="table-secondary">
                                            <tr>
                                                ${headerCells}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                ${valueCells}
                                            </tr>
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
            setInterval(loadTitikPengamatan, 60000);
        });
    </script>
@endsection
