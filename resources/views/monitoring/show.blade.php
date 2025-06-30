@extends('template.master')

@section('content')
<div class="container-fluid py-0 px-6">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Log Input Monitoring
            {{-- {{ $monitoring->titik_pengamatan->kode }}| {{ $monitoring->titik_pengamatan->nama }} - {{ $monitoring->id }} --}}
        </h4>
    </div>

    <a href="{{ route('monitoring.index') }}" class="btn btn-secondary mb-3">
        ← Kembali ke Daftar Input Monitoring
    </a>

    <div class="card shadow-sm bg-light">
        <div class="card-body">
            <h5 class="mb-4">Riwayat Perubahan Data</h5>

            @if($logs->isEmpty())
                <div class="alert alert-secondary">
                    Tidak ada log perubahan untuk monitoring ini.
                </div>
            @else
                <ul class="timeline">
                    @foreach($logs as $log)
                        <li class="timeline-item mb-4">
                            <div class="timeline-point bg-primary"></div>
                            <div class="timeline-event card p-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $log->user->name ?? 'User tidak diketahui' }}</strong>
                                    <small class="text-muted">{{ $log->created_at->format('d M Y, H:i') }}</small>
                                </div>
                                <div class="mt-2">
                                    <p class="mb-1">
                                        {{ $log->keterangan }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .timeline {
        list-style: none;
        position: relative;
        padding-left: 1.5rem;
        margin: 0;
        border-left: 2px solid #0d6efd;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-point {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        position: absolute;
        left: -8px;
        top: 4px;
        background-color: #0d6efd;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #0d6efd;
    }

    .timeline-event {
        margin-left: 1rem;
        background-color: #ffffff;
        color: #000000;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .timeline-event strong {
        color: #0d6efd;
    }
</style>
@endsection

