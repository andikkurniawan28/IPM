@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Tambah Parameter</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('parameter.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Parameter</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label for="simbol" class="form-label">Simbol</label>
                        <input type="text" name="simbol" id="simbol" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori_parameter_id" class="form-label">Kategori</label>
                        <select name="kategori_parameter_id" id="kategori_parameter_id" class="form-select" width="100%"
                            required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategori_parameters as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="satuan_id" class="form-label">Satuan</label>
                        <select name="satuan_id" id="satuan_id" class="form-select" width="100%" required>
                            <option value="" disabled selected>-- Pilih Satuan --</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan->id }}">{{ $satuan->nama }} ({{ $satuan->simbol }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('parameter.index') }}" class="btn btn-secondary">Kembali</a>
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
            $('#kategori_parameter_id, #satuan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true
            });
        });
    </script>
@endsection
