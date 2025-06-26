@extends('template.master')

@section('content')
    <div class="container-fluid py-4 px-6">
        <h4 class="mb-4">Edit Parameter</h4>
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <form action="{{ route('parameter.update', $parameter->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- Nama & Simbol -->
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input name="nama" value="{{ old('nama', $parameter->nama) }}" class="form-control" required
                                autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Simbol</label>
                            <input name="simbol" value="{{ old('simbol', $parameter->simbol) }}" class="form-control"
                                required>
                        </div>

                        <!-- Kategori & Jenis -->
                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_parameter_id" id="kategori_parameter_id" class="form-select" required>
                                <option disabled>-- Pilih Kategori --</option>
                                @foreach ($kategori_parameters as $k)
                                    <option value="{{ $k->id }}"
                                        {{ $k->id == old('kategori_parameter_id', $parameter->kategori_parameter_id) ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <label class="me-2 mb-0">Jenis</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="jenisSwitch" name="jenis"
                                    value="kualitatif"
                                    {{ old('jenis', $parameter->jenis) == 'kualitatif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenisSwitch" id="jenisLabel"></label>
                            </div>
                        </div>

                        <!-- Satuan & Agregasi -->
                        <div class="col-md-4" id="satuan-group">
                            <label class="form-label">Satuan</label>
                            <select name="satuan_id" id="satuan_id" class="form-select" required>
                                <option disabled>-- Pilih Satuan --</option>
                                @foreach ($satuans as $s)
                                    <option value="{{ $s->id }}"
                                        {{ $s->id == old('satuan_id', $parameter->satuan_id) ? 'selected' : '' }}>
                                        {{ $s->nama }} ({{ $s->simbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4" id="agregasi-group">
                            <label class="form-label">Agregasi</label>
                            <select name="metode_agregasi" class="form-select" required>
                                <option disabled>-- Pilih Metode --</option>
                                @foreach (['sum' => 'Sum', 'avg' => 'Avg', 'count' => 'Count'] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ $val == old('metode_agregasi', $parameter->metode_agregasi) ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilihan Kualitatif -->
                        <div class="col-12" id="kualitatif-group" style="display:none;">
                            <label class="form-label d-block">Pilihan Kualitatif</label>
                            <div class="row">
                                @foreach ($jenis_pilihan_kualitatifs as $p)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pilihan_kualitatif[]"
                                                id="pilihan{{ $p->id }}" value="{{ $p->id }}"
                                                {{ in_array($p->id, old('pilihan_kualitatif', $selectedPilihan)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pilihan{{ $p->id }}">
                                                {{ $p->keterangan }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $parameter->keterangan) }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="col-12 text-end">
                            <button class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
                            </button>
                            <a href="{{ route('parameter.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery & Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            // Initialize Select2 on Kategori & Satuan
            $('#kategori_parameter_id, #satuan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true,
                width: '100%'
            });

            // Toggle fields based on jenisSwitch
            function toggle() {
                const isKual = $('#jenisSwitch').is(':checked');
                $('#jenisLabel').text(isKual ? 'Kualitatif' : 'Kuantitatif');
                $('#satuan-group, #agregasi-group')
                    .toggle(!isKual)
                    .find('select').prop('required', !isKual);
                $('#kualitatif-group')
                    .toggle(isKual)
                    .find('input[type=checkbox]').prop('disabled', !isKual);
            }

            // Bind and trigger initial toggle
            $('#jenisSwitch').change(toggle).trigger('change');
        });
    </script>
@endsection
