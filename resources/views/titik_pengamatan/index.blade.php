@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Titik Pengamatan</h4>
            <a href="{{ route('titik_pengamatan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <table id="titik_pengamatanTable" class="table table-bordered table-hover table-sm w-100">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Zona</th>
                            {{-- <th>Satuan</th> --}}
                            <th>Keterangan</th>
                            <th>Parameter</th> <!-- tambahkan ini -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- jQuery & DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {
            $('#titik_pengamatanTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('titik_pengamatan.index') }}",
                order: [[1, 'asc']],
                columns: [
                    { data: 'urutan', name: 'urutan' },
                    { data: 'nama', name: 'nama' },
                    { data: 'kode', name: 'kode' },
                    { data: 'zona.nama', name: 'zona.nama' },
                    // { data: 'satuan.nama', name: 'satuan.nama' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'daftar_parameter', name: 'parameter_titik_pengamatans.parameter.nama', orderable: false, searchable: false }, // ini baru
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection
