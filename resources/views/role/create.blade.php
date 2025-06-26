@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">
        <h4 class="mb-4">Tambah Role</h4>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Role</label>
                        <input type="text" name="nama" id="nama" class="form-control" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Izin Akses</label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="izin_akses_input" id="izin_akses_input"
                                value="1" checked>
                            <label class="form-check-label" for="izin_akses_input">Input</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="izin_akses_laporan"
                                id="izin_akses_laporan" value="1" checked>
                            <label class="form-check-label" for="izin_akses_laporan">Laporan</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="izin_akses_master" id="izin_akses_master"
                                value="1" checked>
                            <label class="form-check-label" for="izin_akses_master">Master</label>
                        </div>
                    </div>


                    {{-- <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" required>
                    </div> --}}

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('role.index') }}" class="btn btn-secondary">Kembali</a>
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
            $('#kategori_role_id, #satuan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true
            });
        });
    </script>
@endsection
