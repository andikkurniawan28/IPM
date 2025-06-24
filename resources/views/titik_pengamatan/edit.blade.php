@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Edit Titik Pengamatan</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('titik_pengamatan.update', $titik_pengamatan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Titik Pengamatan</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $titik_pengamatan->nama }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control"
                            value="{{ $titik_pengamatan->kode }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="urutan" class="form-label">#Urutan</label>
                        <input type="number" name="urutan" id="urutan" class="form-control"
                            value="{{ $titik_pengamatan->urutan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="zona_id" class="form-label">Zona</label>
                        <select name="zona_id" id="zona_id" class="form-select" required>
                            <option value="" disabled>-- Pilih Zona --</option>
                            @foreach ($zonas as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ $titik_pengamatan->zona_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $titik_pengamatan->keterangan }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Parameter</label>
                        <div class="row">
                            @foreach ($parameters as $parameter)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="parameter_id[]"
                                            value="{{ $parameter->id }}"
                                            id="parameter_{{ $parameter->id }}"
                                            {{ in_array($parameter->id, $titik_pengamatan->parameter_titik_pengamatans->pluck('parameter_id')->toArray()) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="parameter_{{ $parameter->id }}">
                                            {{ $parameter->nama }} <sub>({{ $parameter->satuan->simbol }})</sub>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Perbarui
                    </button>
                    <a href="{{ route('titik_pengamatan.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Select2 JS & CSS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#zona_id, #satuan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true
            });
        });
    </script>
@endsection
