@extends('template.master')

@section('content')
<div class="container-fluid py-0 px-6">
    <h4 class="mb-4">Ubah Urutan Titik Pengamatan</h4>

    <div class="card shadow-sm bg-light">
        <div class="card-body">
            <form id="urutanForm" action="{{ route('ubah_urutan_titik_pengamatan.process') }}" method="POST">
                @csrf
                <ul id="sortable" class="list-group">
                    @foreach ($titik_pengamatans->sortBy('urutan') as $item)
                        <li class="list-group-item d-flex align-items-center gap-3" data-id="{{ $item->id }}">
                            <i class="bi bi-list fs-4 text-secondary handle" style="cursor: grab;"></i>
                            <span>{{ $item->nama }} <small class="text-muted">({{ $item->kode }})</small></span>
                        </li>
                    @endforeach
                </ul>

                <input type="hidden" name="urutan_baru" id="urutanBaru">

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-down-up"></i> Simpan Urutan
                    </button>
                    <a href="{{ route('titik_pengamatan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />

<script>
    $(function() {
        $('#sortable').sortable({
            handle: '.handle',
            update: function() {
                let order = [];
                $('#sortable li').each(function(index, element) {
                    order.push($(element).data('id'));
                });
                $('#urutanBaru').val(JSON.stringify(order));
            }
        });

        // Trigger pertama kali untuk isi hidden field
        $('#sortable').sortable('option', 'update').call($('#sortable'));
    });
</script>
@endsection
