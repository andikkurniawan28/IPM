@extends('template.master')

@section('content')
<div class="container-fluid py-0 px-6 text-light">
    <h4 class="mb-3">Dokumentasi API: Input Eksternal Monitoring</h4>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Endpoint</h5>
            <p class="text-light mb-1"><code>GET /eksternal_input/{periode}/{jam}/{titik_pengamatan_id}/{parameter_id}/{user_id}/{value}</code></p>
            <p class="text-light">Endpoint ini digunakan untuk menginput atau mengupdate data monitoring dari sistem eksternal ke aplikasi.</p>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Parameter URL</h5>
            <ul class="text-light mb-0">
                <li><strong>periode</strong> – format: <code>YYYY-MM-DD</code>, contoh: <code>2025-07-06</code></li>
                <li><strong>jam</strong> – format yang didukung:
                    <ul>
                        <li><code>HH:mm:ss</code> (contoh: <code>07:30:00</code>)</li>
                        <li><code>HH-mm-ss</code> (contoh: <code>07-30-00</code>)</li>
                        {{-- <li><code>HHmmss</code> (contoh: <code>073000</code>)</li> --}}
                        <li><code>HH%3Amm%3Ass</code> (contoh: <code>07%3A30%3A00</code>) – jika ingin tetap pakai <code>HH:mm:ss</code>, pastikan dikodekan sebagai URL-safe</li>
                    </ul>
                </li>
                <li><strong>titik_pengamatan_id</strong> – ID titik pengamatan (cek master <a target="_blank" href="{{ route('titik_pengamatan.index') }}">titik pengamatan</a>)</li>
                <li><strong>parameter_id</strong> – ID parameter (cek master <a target="_blank" href="{{ route('parameter.index') }}">parameter</a>)</li>
                <li><strong>user_id</strong> – ID user (digunakan untuk mencatat log input)</li>
                <li><strong>value</strong> – Nilai yang akan disimpan</li>
            </ul>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Contoh Request</h5>
            <p class="text-light">
                <code>GET /eksternal_input/2025-07-06/073000/5/3/2/7.8</code><br>
                Akan menyimpan nilai <code>7.8</code> ke kolom <code>param3</code> untuk titik pengamatan ID 5 pada jam 07:30:00 dan periode 2025-07-06, dengan user ID 2.
            </p>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Response Sukses</h5>
            <pre class="bg-black text-success p-3 rounded">
{
    "status": "ok",
    "message": "Data disimpan ke kolom param3 untuk jam 07:30:00"
}
            </pre>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Response Gagal</h5>
            <pre class="bg-black text-danger p-3 rounded">
{
    "status": "error",
    "message": "Terjadi kesalahan.",
    "error": "Exception message (hanya muncul saat debug aktif)"
}
            </pre>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-light">Catatan Tambahan</h5>
            <ul class="text-light">
                <li>Data yang masuk akan otomatis dibuat atau diperbarui pada tabel <code>monitorings</code>.</li>
                <li>Setiap perubahan juga dicatat ke tabel <code>input_monitoring_logs</code> dengan detail user dan kolom yang diubah.</li>
                <li>Pastikan ID-ID (titik, parameter, user) valid dan sesuai database.</li>
                <li>Endpoint ini hanya mendukung metode <code>GET</code>, dan sebaiknya dipanggil via HTTPS untuk keamanan.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
