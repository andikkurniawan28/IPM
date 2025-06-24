<a href="{{ route('titik_pengamatan.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('titik_pengamatan.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger">Hapus</button>
</form>
