@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6 text-light">
        <h4 class="mb-3">Selamat datang, {{ Auth::user()->name }}!</h4>
        {{-- <p class="text-light">Silakan gunakan menu di atas untuk mengakses fitur monitoring dan manajemen data.</p> --}}

        {{-- @if (session('periode'))
            <div class="alert alert-info bg-secondary text-light border-0">
                Periode aktif:
                <strong>
                    @php
                        function tanggalIndo($tanggal)
                        {
                            $bulan = [
                                1 => 'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember',
                            ];
                            $date = \Carbon\Carbon::parse($tanggal);
                            return $date->format('d') .
                                ' ' .
                                $bulan[(int) $date->format('m')] .
                                ' ' .
                                $date->format('Y');
                        }
                    @endphp
                    {{ tanggalIndo(session('periode')) }}
                </strong>
            </div>
        @endif --}}

        <a href="{{ route('monitoring_all') }}" class="btn btn-outline-light mb-4">
            <i class="bi bi-graph-up"></i> Buka Monitoring
        </a>

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card bg-dark border-secondary shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-light">Jumlah Parameter</h6>
                        <p class="fs-4 text-light">{{ \App\Models\Parameter::count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card bg-dark border-secondary shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-light">Jumlah Zona</h6>
                        <p class="fs-4 text-light">{{ \App\Models\Zona::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Parameter per Kategori</h6>
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Titik Pengamatan per Zona</h6>
                        <canvas id="zonaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
        const zonaCtx = document.getElementById('zonaChart').getContext('2d');

        const kategoriChart = new Chart(kategoriCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(\App\Models\KategoriParameter::orderBy('id', 'asc')->pluck('nama')) !!},
                datasets: [{
                    data: {!! json_encode(
                        \App\Models\KategoriParameter::withCount('parameters')->pluck('parameters_count')
                    ) !!},
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                }]
            },
        });

        const zonaChart = new Chart(zonaCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(\App\Models\Zona::orderBy('id', 'asc')->pluck('nama')) !!},
                datasets: [{
                    label: 'Jumlah Titik Pengamatan',
                    data: {!! json_encode(
                        \App\Models\Zona::withCount('titik_pengamatans')->pluck('titik_pengamatans_count')
                    ) !!},
                    backgroundColor: '#36b9cc'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endsection

