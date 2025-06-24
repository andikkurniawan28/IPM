<a href="{{ route('kategori_parameter.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
<form action="{{ route('kategori_parameter.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger">Hapus</button>
</form>
