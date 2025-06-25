@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6 text-light">
        <h4 class="mb-3">Selamat datang, {{ Auth::user()->name }}!</h4>
        <p class="text-light">Silakan gunakan menu di atas untuk mengakses fitur monitoring dan manajemen data.</p>

        @if (session('periode'))
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
        @endif

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
    </div>
@endsection
