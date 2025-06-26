@extends('template.master')

@section('content')
    <div class="container-fluid py-0 px-6">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Input Monitoring</h4>
            <a href="{{ route('monitoring.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <div class="table-responsive">

                    <table id="monitoringTable" class="table table-bordered table-hover table-sm w-100">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Periode</th>
                                <th>Jam</th>
                                <th>Kode</th>
                                <th>Titik Pengamatan</th>
                                <th>Nilai</th>
                                {{-- <th>Keterangan</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
            $('#monitoringTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('monitoring.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'periode',
                        name: 'periode'
                    },
                    {
                        data: 'jam',
                        name: 'jam'
                    },
                    {
                        data: 'titik_pengamatan.kode',
                        name: 'titik_pengamatan.kode'
                    },
                    {
                        data: 'titik_pengamatan.nama',
                        name: 'titik_pengamatan.nama'
                    },
                    {
                        data: 'parameter',
                        name: 'parameter'
                    },
                    // { data: 'satuan_nama', name: 'satuan_nama' },
                    // { data: 'keterangan', name: 'keterangan' },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
