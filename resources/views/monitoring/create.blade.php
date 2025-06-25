@extends('template.master')

@section('content')
<div class="container-fluid py-0 px-4">
    <h4 class="mb-4">Tambah Monitoring</h4>

    <div class="card shadow-sm bg-light">
        <div class="card-body">
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="periode" class="form-label">Periode</label>
                        <input type="date" name="periode" id="periode" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" name="jam" id="jam" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-4">
                        <label for="titik_pengamatan_id" class="form-label">Titik Pengamatan</label>
                        <select name="titik_pengamatan_id" id="titik_pengamatan_id" class="form-select form-select-sm" required>
                            <option value="" disabled selected>-- Pilih Titik --</option>
                            @foreach ($titik_pengamatans as $titik_pengamatan)
                                <option value="{{ $titik_pengamatan->id }}">{{ $titik_pengamatan->kode }} | {{ $titik_pengamatan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    @foreach($parameters as $parameter)
                        <div class="col-md-4 mb-3">
                            <label for="param{{ $parameter->id }}" class="form-label small">
                                {{ $parameter->simbol }}
                                <sub>({{ $parameter->satuan->simbol }})</sub>
                            </label>
                            <input type="number" step="any" name="param{{ $parameter->id }}" id="param{{ $parameter->id }}"
                                class="form-control form-control-sm" placeholder="Masukkan {{ $parameter->nama }}">
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
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#titik_pengamatan_id').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Titik --',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
