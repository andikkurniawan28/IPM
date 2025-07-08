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

                    {{-- Checkbox Izin Detail --}}
                    <div class="mb-3">
                        <label class="form-label d-block">Detail Izin Akses</label>

                        @php
                            $izinList = [
                                'akses_master_daftar_kategori_parameter' => 'Daftar Kategori Parameter',
                                'akses_master_tambah_kategori_parameter' => 'Tambah Kategori Parameter',
                                'akses_master_edit_kategori_parameter' => 'Edit Kategori Parameter',
                                'akses_master_hapus_kategori_parameter' => 'Hapus Kategori Parameter',
                                'akses_master_daftar_satuan' => 'Daftar Satuan',
                                'akses_master_tambah_satuan' => 'Tambah Satuan',
                                'akses_master_edit_satuan' => 'Edit Satuan',
                                'akses_master_hapus_satuan' => 'Hapus Satuan',
                                'akses_master_daftar_jenis_pilihan_kualitatif' => 'Daftar Jenis Pilihan Kualitatif',
                                'akses_master_tambah_jenis_pilihan_kualitatif' => 'Tambah Jenis Pilihan Kualitatif',
                                'akses_master_edit_jenis_pilihan_kualitatif' => 'Edit Jenis Pilihan Kualitatif',
                                'akses_master_hapus_jenis_pilihan_kualitatif' => 'Hapus Jenis Pilihan Kualitatif',
                                'akses_master_daftar_parameter' => 'Daftar Parameter',
                                'akses_master_tambah_parameter' => 'Tambah Parameter',
                                'akses_master_edit_parameter' => 'Edit Parameter',
                                'akses_master_hapus_parameter' => 'Hapus Parameter',
                                'akses_master_daftar_zona' => 'Daftar Zona',
                                'akses_master_tambah_zona' => 'Tambah Zona',
                                'akses_master_edit_zona' => 'Edit Zona',
                                'akses_master_hapus_zona' => 'Hapus Zona',
                                'akses_master_daftar_titik_pengamatan' => 'Daftar Titik Pengamatan',
                                'akses_master_tambah_titik_pengamatan' => 'Tambah Titik Pengamatan',
                                'akses_master_edit_titik_pengamatan' => 'Edit Titik Pengamatan',
                                'akses_master_hapus_titik_pengamatan' => 'Hapus Titik Pengamatan',
                                'akses_master_daftar_role' => 'Daftar Role',
                                'akses_master_tambah_role' => 'Tambah Role',
                                'akses_master_edit_role' => 'Edit Role',
                                'akses_master_hapus_role' => 'Hapus Role',
                                'akses_master_daftar_user' => 'Daftar User',
                                'akses_master_tambah_user' => 'Tambah User',
                                'akses_master_edit_user' => 'Edit User',
                                'akses_master_hapus_user' => 'Hapus User',
                                'akses_daftar_input_monitoring' => 'Daftar Input Monitoring',
                                'akses_tambah_input_monitoring' => 'Tambah Input Monitoring',
                                'akses_edit_input_monitoring' => 'Edit Input Monitoring',
                            ];
                        @endphp

                        <div class="row">
                            {{-- Izin statis --}}
                            @foreach ($izinList as $key => $label)
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $key }}"
                                            id="{{ $key }}" value="1" {{ old($key) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="{{ $key }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Izin dinamis per Parameter --}}
                            @foreach ($parameters as $parameter)
                                @php
                                    $dynamicKey = 'akses_input_param' . $parameter->id;
                                    $label = "Input ({$parameter->simbol}| {$parameter->nama})";
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $dynamicKey }}"
                                            id="{{ $dynamicKey }}" value="1" {{ old($dynamicKey) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="{{ $dynamicKey }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


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
