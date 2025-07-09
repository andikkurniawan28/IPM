@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Tambah Titik Pengamatan</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('titik_pengamatan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Titik Pengamatan</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="zona_id" class="form-label">Zona</label>
                        <select name="zona_id" id="zona_id" class="form-select" width="100%"
                            required>
                            <option value="" disabled selected>-- Pilih Zona --</option>
                            @foreach ($zonas as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lebar" class="form-label">Lebar</label>
                        <input name="lebar" id="lebar" class="form-control" class="form-control" value="4"></input>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
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
