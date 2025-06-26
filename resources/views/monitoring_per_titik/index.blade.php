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
                            <th>Periode</th>
                            <th>Jam</th>
                            @foreach ($parameter_list as $param)
                                <th>{{ $param->parameter->simbol }}<sub>({{ $param->parameter->satuan->simbol ?? '' }})</sub></th>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(function () {
        $('#monitoringTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('monitoring_per_titik.data', $titik_pengamatan_id) }}",
            order: [[1, 'desc']],
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
