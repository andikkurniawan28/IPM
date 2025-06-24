<!-- Floating Button -->
<button class="btn btn-primary rounded-circle position-fixed"
  style="bottom: 20px; right: 20px; width: 56px; height: 56px;" data-bs-toggle="modal" data-bs-target="#tanggalModal">
  <i class="bi bi-calendar-event"></i>
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
        <form id="formTanggal">
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Monitoring</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
          </div>
          <button type="submit" class="btn btn-primary">Terapkan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icon (optional, for calendar icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
