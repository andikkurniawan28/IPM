@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-4">
        <h4 class="mb-4">Edit Input Monitoring</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('monitoring.update', $monitoring->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Periode, Jam, Titik --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="periode" class="form-label">Periode</label>
                            <input type="date" name="periode" id="periode" class="form-control form-control-sm"
                                   value="{{ old('periode', $monitoring->periode) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control form-control-sm"
                                   value="{{ old('jam', $monitoring->jam) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="titik_pengamatan_id" class="form-label">Titik Pengamatan</label>
                            <select name="titik_pengamatan_id" id="titik_pengamatan_id" class="form-select form-select-sm" required>
                                <option value="" disabled>-- Pilih Titik --</option>
                                @foreach($titik_pengamatans as $tp)
                                    <option value="{{ $tp->id }}"
                                        {{ $tp->id == old('titik_pengamatan_id', $monitoring->titik_pengamatan_id) ? 'selected' : '' }}>
                                        {{ $tp->kode }} | {{ $tp->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Parameter Inputs --}}
                    <div class="row">
                        @foreach($parameters as $parameter)
                            @php
                                $field = 'param' . $parameter->id;
                                $value = old($field, $monitoring->{$field});
                            @endphp

                            <div class="col-md-4 mb-3 input-parameter visually-hidden" data-parameter-id="{{ $parameter->id }}">
                                <label class="form-label small" for="{{ $field }}">
                                    {{ $parameter->simbol }}
                                    @if($parameter->jenis === 'kuantitatif')
                                        <sub>({{ $parameter->satuan->simbol }})</sub>
                                    @endif
                                </label>

                                @if($parameter->jenis === 'kuantitatif')
                                    <input type="number"
                                           step="any"
                                           name="{{ $field }}"
                                           id="{{ $field }}"
                                           class="form-control form-control-sm"
                                           placeholder="Masukkan {{ $parameter->nama }}..."
                                           value="{{ $value }}">
                                @else
                                    <select class="form-select form-select-sm" name="{{ $field }}" id="{{ $field }}">
                                        <option value="" disabled>-- Pilih --</option>
                                        @foreach($parameter->pilihan_kualitatifs as $pil)
                                            @php
                                                $keterangan = $pil->jenis_pilihan_kualitatif->keterangan;
                                            @endphp
                                            <option value="{{ $keterangan }}" {{ $value == $keterangan ? 'selected' : '' }}>
                                                {{ $keterangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('monitoring.index') }}" class="btn btn-sm btn-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- jQuery & Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#titik_pengamatan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Titik --',
                allowClear: true,
                width: '100%'
            });

            const parameterMap = @json(
                $titik_pengamatans->mapWithKeys(function ($t) {
                    return [$t->id => $t->parameter_titik_pengamatans->pluck('parameter_id')];
                })
            );

            function toggleInputs(titikId) {
                $('.input-parameter').addClass('visually-hidden');

                if (parameterMap[titikId]) {
                    parameterMap[titikId].forEach(function (pid) {
                        $('.input-parameter[data-parameter-id="' + pid + '"]').removeClass('visually-hidden');
                    });
                }
            }

            const selected = $('#titik_pengamatan_id').val();
            if (selected) {
                toggleInputs(selected);
            }

            $('#titik_pengamatan_id').on('change', function () {
                toggleInputs($(this).val());
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
