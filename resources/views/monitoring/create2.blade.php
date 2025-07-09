@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-4">
        <h4 class="mb-4">Tambah Input Monitoring</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('monitoring.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="periode" class="form-label">Periode</label>
                            <input type="date" name="periode" id="periode" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control form-control-sm"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="titik_pengamatan_id" class="form-label">Titik Pengamatan</label>
                            <select name="titik_pengamatan_id" id="titik_pengamatan_id" class="form-select form-select-sm"
                                required>
                                <option value="" disabled selected>-- Pilih Titik --</option>
                                @foreach ($titik_pengamatans as $titik_pengamatan)
                                    <option value="{{ $titik_pengamatan->id }}">{{ $titik_pengamatan->kode }} |
                                        {{ $titik_pengamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($parameters as $parameter)
                            <div class="col-md-4 mb-3 input-parameter visually-hidden"
                                data-parameter-id="{{ $parameter->id }}">
                                <label class="form-label small" for="param{{ $parameter->id }}">
                                    {{ $parameter->simbol }}
                                    @if ($parameter->jenis === 'kuantitatif')
                                        <sub>({{ $parameter->satuan->simbol }})</sub>
                                    @endif
                                </label>
                                @php
                                    $aksesKey = 'akses_input_param' . $parameter->id;
                                    $readonly = optional(auth()->user()->role)->{$aksesKey} == 0 ? 'readonly' : '';
                                    $disabled = optional(auth()->user()->role)->{$aksesKey} == 0 ? 'disabled' : ''; // untuk select
                                @endphp
                                @if ($parameter->jenis === 'kuantitatif')
                                    <input type="number" step="any" name="param{{ $parameter->id }}"
                                        id="param{{ $parameter->id }}" class="form-control form-control-sm"
                                        placeholder="Masukkan {{ $parameter->nama }}..." {{ $readonly }}>
                                @elseif ($parameter->jenis === 'kualitatif_entry')
                                    {{-- Text input untuk kualitatif_entry --}}
                                    <input type="text" step="any" name="param{{ $parameter->id }}"
                                        id="param{{ $parameter->id }}" class="form-control form-control-sm"
                                        placeholder="Masukkan {{ $parameter->nama }}..." {{ $readonly }}>
                                @else
                                    <select class="form-select form-select-sm" name="param{{ $parameter->id }}"
                                        id="param{{ $parameter->id }}" {{ $disabled }}>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach ($parameter->pilihan_kualitatifs as $pil)
                                            <option value="{{ $pil->jenis_pilihan_kualitatif->keterangan }}">
                                                {{ $pil->jenis_pilihan_kualitatif->keterangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('monitoring.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi select2
            $('#titik_pengamatan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Titik --',
                allowClear: true,
                width: '100%'
            });

            // Mapping titik_pengamatan_id -> [parameter_id...]
            const parameterMap = @json(
                $titik_pengamatans->mapWithKeys(function ($t) {
                    return [$t->id => $t->parameter_titik_pengamatans->pluck('parameter_id')];
                }));

            $('#titik_pengamatan_id').on('change', function() {
                const selectedId = $(this).val();

                // Sembunyikan semua parameter
                $('.input-parameter').addClass('visually-hidden');

                // Reset semua input nilai
                $('input[type="number"], input[type="radio"]').prop('checked', false).val('');

                // Tampilkan yang relevan
                if (parameterMap[selectedId]) {
                    parameterMap[selectedId].forEach(function(pid) {
                        $('.input-parameter[data-parameter-id="' + pid + '"]').removeClass(
                            'visually-hidden');
                    });
                }
            });
        });
    </script>

    <style>
        .visually-hidden {
            position: absolute !important;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
@endsection
