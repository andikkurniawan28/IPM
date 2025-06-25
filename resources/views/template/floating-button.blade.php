<!-- Tombol Persegi: Icon + Tanggal -->
<button class="btn btn-primary position-fixed d-flex align-items-center gap-2 px-3 py-2 shadow"
    style="bottom: 20px; right: 20px; z-index: 1050;"
    data-bs-toggle="modal" data-bs-target="#tanggalModal">
    <i class="bi bi-calendar-event"></i>
    <span class="small">
        @php
            function tanggalIndo($tanggal) {
                $bulan = [
                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                $date = \Carbon\Carbon::parse($tanggal);
                return $date->format('d') . ' ' . $bulan[(int)$date->format('m')] . ' ' . $date->format('Y');
            }
        @endphp
        {{ tanggalIndo(session('periode')) }}
    </span>
</button>

<!-- Modal Pilih Tanggal -->
<div class="modal fade" id="tanggalModal" tabindex="-1" aria-labelledby="tanggalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-secondary">
      <div class="modal-header">
        <h5 class="modal-title" id="tanggalModalLabel">Pilih Tanggal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="formTanggal" action="{{ route('change_session_periode') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Monitoring</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal"
                    value="{{ session('periode') ?? date('Y-m-d') }}" required onchange="this.form.submit()">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icon (optional, for calendar icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
