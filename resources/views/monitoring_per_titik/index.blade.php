@extends('template.master')

@section('content')
<div class="container-fluid py-0 px-6">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ $titik->kode }}| {{ $titik->nama }}</h4>
    </div>

    <div class="card shadow-sm bg-light">
        <div class="card-body">
            <div class="table-responsive">
                <table id="monitoringTable" class="table table-bordered table-hover table-sm w-100">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Monitoring ID</th>
                            <th>Periode</th>
                            <th>Jam</th>
                            @foreach ($parameter_list as $param)
                                @if($param->parameter->jenis == "kuantitatif")
                                    <th>{{ $param->parameter->simbol }}<sub>({{ $param->parameter->satuan->simbol ?? '' }})</sub></th>
                                @else
                                    <th>{{ $param->parameter->simbol }}</th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons Extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- JSZip (needed for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    $(function () {
        $('#monitoringTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('monitoring_per_titik.data', $titik_pengamatan_id) }}",
            order: [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Monitoring - {{ $titik->kode }}',
                    exportOptions: {
                        columns: ':visible'
                    },
                    className: 'btn btn-success btn-sm'
                }
            ],
            columns: [
                {
                    data: null,
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'id', name: 'id' },
                { data: 'periode', name: 'periode' },
                { data: 'jam', name: 'jam' },
                @foreach ($parameter_list as $param)
                    { data: 'param{{ $param->parameter_id }}', name: 'param{{ $param->parameter_id }}' },
                @endforeach
            ]
        });
    });
</script>
@endsection
