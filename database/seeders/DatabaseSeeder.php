<?php

namespace Database\Seeders;

use App\Models\JenisPilihanKualitatif;
use App\Models\Role;
use App\Models\User;
use App\Models\Zona;
use App\Models\Satuan;
use App\Models\Parameter;
use App\Models\TitikPengamatan;
use Illuminate\Database\Seeder;
use App\Models\KategoriParameter;
use App\Models\ParameterTitikPengamatan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['nama' => 'Kabag Pabrikasi'],
            ['nama' => 'Kabag QC'],
            ['nama' => 'Kabag Teknik'],
            ['nama' => 'Kasie Pabrikasi'],
            ['nama' => 'Kasie Lab'],
            ['nama' => 'Kasie Teknik'],
            ['nama' => 'Kasubsie Pabrikasi'],
            ['nama' => 'Kasubsie QC'],
            ['nama' => 'Kasubsie Teknik'],
            ['nama' => 'Mandor Pabrikasi'],
            ['nama' => 'Mandor QC'],
            ['nama' => 'Mandor Teknik'],
        ]);

        $roles = Role::all();

        foreach ($roles as $index => $role) {
            User::create([
                'role_id' => $role->id,
                'name' => $role->nama,
                'email' => 'user' . ($index + 1) . '@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Insert kategori parameter
        KategoriParameter::insert([
            ['nama' => 'Peralatan'],
            ['nama' => 'Produksi'],
            ['nama' => 'Lingkungan'],
        ]);

        // Insert satuan
        Satuan::insert([
            ['nama' => 'Derajat Celcius', 'simbol' => '°C'],
            ['nama' => 'Fahrenheit', 'simbol' => '°F'],
            ['nama' => 'Kelvin', 'simbol' => 'K'],
            ['nama' => 'Ampere', 'simbol' => 'A'],
            ['nama' => 'Volt', 'simbol' => 'V'],
            ['nama' => 'Watt', 'simbol' => 'W'],
            ['nama' => 'Kilowatt', 'simbol' => 'kW'],
            ['nama' => 'Megawatt', 'simbol' => 'MW'],
            ['nama' => 'Kilowatt-hour', 'simbol' => 'kWh'],
            ['nama' => 'Putaran per Menit', 'simbol' => 'RPM'],
            ['nama' => 'Pascal', 'simbol' => 'Pa'],
            ['nama' => 'Kilopascal', 'simbol' => 'kPa'],
            ['nama' => 'Bar', 'simbol' => 'bar'],
            ['nama' => 'Liter', 'simbol' => 'L'],
            ['nama' => 'Mililiter', 'simbol' => 'mL'],
            ['nama' => 'Meter Kubik', 'simbol' => 'm³'],
            ['nama' => 'Meter Kubik per Jam', 'simbol' => 'm³/h'],
            ['nama' => 'Liter per Menit', 'simbol' => 'L/min'],
            ['nama' => 'Persentase', 'simbol' => '%'],
            ['nama' => 'Kilogram', 'simbol' => 'kg'],
            ['nama' => 'Gram', 'simbol' => 'g'],
            ['nama' => 'Ton', 'simbol' => 't'],
            ['nama' => 'Newton', 'simbol' => 'N'],
            ['nama' => 'Kilonewton', 'simbol' => 'kN'],
            ['nama' => 'Meter', 'simbol' => 'm'],
            ['nama' => 'Centimeter', 'simbol' => 'cm'],
            ['nama' => 'Milimeter', 'simbol' => 'mm'],
            ['nama' => 'Jam', 'simbol' => 'h'],
            ['nama' => 'Menit', 'simbol' => 'min'],
            ['nama' => 'Detik', 'simbol' => 's'],
            ['nama' => 'Lux', 'simbol' => 'lx'],
            ['nama' => 'Decibel', 'simbol' => 'dB'],
            ['nama' => 'Hz', 'simbol' => 'Hz'],
            ['nama' => 'Ohm', 'simbol' => 'Ω'],
            ['nama' => 'Siklus', 'simbol' => 'cycle'],
            ['nama' => 'Jumlah', 'simbol' => 'unit'],
            ['nama' => 'Kalori', 'simbol' => 'cal'],
            ['nama' => 'Joule', 'simbol' => 'J'],
            ['nama' => 'Kandungan Air', 'simbol' => '%RH'],
            ['nama' => 'pH', 'simbol' => 'pH'],
            ['nama' => 'Brix', 'simbol' => '°Bx'],
            ['nama' => 'PPM', 'simbol' => 'ppm'],
            ['nama' => 'Tegangan', 'simbol' => 'MPa'],
            ['nama' => 'Kecepatan Alir', 'simbol' => 'm/s'],
            ['nama' => 'Frekuensi', 'simbol' => '1/s'],
            ['nama' => 'Energi Termal', 'simbol' => 'BTU'],
            ['nama' => 'Lumen', 'simbol' => 'lm'],
            ['nama' => 'Density', 'simbol' => 'kg/m³'],
            ['nama' => 'Konsentrasi', 'simbol' => 'mol/L'],
        ]);

        JenisPilihanKualitatif::insert([
            // Untuk parameter_id 1 → status mesin
            ['keterangan' => 'Aktif'],
            ['keterangan' => 'Nonaktif'],

            // Untuk parameter_id 2 → konfirmasi
            ['keterangan' => 'Ya'],
            ['keterangan' => 'Tidak'],

            // Untuk parameter_id 3 → kondisi umum
            ['keterangan' => 'Baik'],
            ['keterangan' => 'Cukup'],
            ['keterangan' => 'Buruk'],

            // Untuk parameter_id 4 → level
            ['keterangan' => 'Rendah'],
            ['keterangan' => 'Sedang'],
            ['keterangan' => 'Tinggi'],

            // Untuk parameter_id 5 → warna indikator
            ['keterangan' => 'Hijau'],
            ['keterangan' => 'Kuning'],
            ['keterangan' => 'Merah'],

            // Untuk parameter_id 6 → mode kerja
            ['keterangan' => 'Manual'],
            ['keterangan' => 'Otomatis'],

            // Untuk parameter_id 7 → validasi
            ['keterangan' => 'Valid'],
            ['keterangan' => 'Tidak Valid'],

            // Untuk parameter_id 8 → keputusan
            ['keterangan' => 'Disetujui'],
            ['keterangan' => 'Ditolak'],
            ['keterangan' => 'Revisi'],

            // Untuk parameter_id 9 → koneksi
            ['keterangan' => 'Terkoneksi'],
            ['keterangan' => 'Tidak Terkoneksi'],
        ]);

        // Simpan id kategori dan satuan
        $kategori = KategoriParameter::pluck('id', 'nama');
        $satuan = Satuan::pluck('id', 'simbol');

        // Insert parameter
        $parameters = [
            [
                'nama' => 'Rotation Speed',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['RPM'],
                'simbol' => 'Rpm',
                'keterangan' => 'Kecepatan putaran peralatan dalam satuan RPM.',
                'metode_agregasi' => 'avg',
            ],
            [
                'nama' => 'Electric Current',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['A'],
                'simbol' => 'Amp',
                'keterangan' => 'Besarnya arus listrik pada peralatan.',
                'metode_agregasi' => 'avg',
            ],
            [
                'nama' => 'Voltage',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['V'],
                'simbol' => 'Volt',
                'keterangan' => 'Tegangan kerja sistem atau alat.',
                'metode_agregasi' => 'avg',
            ],
            [
                'nama' => 'Pressure',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['bar'],
                'simbol' => 'Press',
                'keterangan' => 'Tekanan sistem dalam satuan bar.',
                'metode_agregasi' => 'avg',
            ],
            [
                'nama' => 'Temperature',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['°C'],
                'simbol' => 'Temp',
                'keterangan' => 'Suhu pengamatan dalam satuan derajat Celsius.',
                'metode_agregasi' => 'avg',
            ],
            [
                'nama' => 'Product Count',
                'kategori_parameter_id' => $kategori['Produksi'],
                'satuan_id' => $satuan['unit'],
                'simbol' => 'Qty',
                'keterangan' => 'Jumlah unit produk yang dihasilkan.',
                'metode_agregasi' => 'sum',
            ],
            [
                'nama' => 'Flow',
                'kategori_parameter_id' => $kategori['Produksi'],
                'satuan_id' => $satuan['m³/h'],
                'simbol' => 'flow',
                'keterangan' => 'Jumlah aliran.',
                'metode_agregasi' => 'sum',
            ]
        ];

        foreach($parameters as $parameter){
            Parameter::create($parameter);
        }

        // Insert zona
        Zona::insert([
            ['kode' => 'GIL', 'nama' => 'Gilingan'],
            ['kode' => 'PMN', 'nama' => 'Pemurnian'],
            ['kode' => 'UAP', 'nama' => 'Penguapan'],
            ['kode' => 'MSK', 'nama' => 'Masakan'],
            ['kode' => 'DRK', 'nama' => 'DRK'],
            ['kode' => 'PTR', 'nama' => 'Puteran'],
            ['kode' => 'PCK', 'nama' => 'Packer'],
            ['kode' => 'LST', 'nama' => 'Listrik'],
            ['kode' => 'KTL', 'nama' => 'Ketel'],
            ['kode' => 'UPLC', 'nama' => 'UPLC'],
        ]);

        $zona = Zona::pluck('id', 'kode');
        TitikPengamatan::insert([
            ['urutan' => 1, 'nama' => 'Gilingan 1', 'kode' => 'G1', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 1'],
            ['urutan' => 2, 'nama' => 'Gilingan 2', 'kode' => 'G2', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 2'],
            ['urutan' => 3, 'nama' => 'Gilingan 3', 'kode' => 'G3', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 3'],
            ['urutan' => 4, 'nama' => 'Gilingan 4', 'kode' => 'G4', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 4'],
            ['urutan' => 5, 'nama' => 'Gilingan 5', 'kode' => 'G5', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 5'],
            ['urutan' => 6, 'nama' => 'Cane Cutter', 'kode' => 'CC', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Pencacah Tebu'],
        ]);

        // Mapping titik dan parameter ke relasi
        $titik = TitikPengamatan::pluck('id', 'nama');
        $param = Parameter::pluck('id', 'nama');

        $relasi = [
            ['Gilingan 1', 'Rotation Speed'],
            ['Gilingan 2', 'Rotation Speed'],
            ['Gilingan 3', 'Rotation Speed'],
            ['Gilingan 4', 'Rotation Speed'],
            ['Gilingan 5', 'Rotation Speed'],
        ];

        $insert = [];

        foreach ($relasi as [$titikNama, $paramNama]) {
            if (isset($titik[$titikNama], $param[$paramNama])) {
                $insert[] = [
                    'titik_pengamatan_id' => $titik[$titikNama],
                    'parameter_id' => $param[$paramNama],
                ];
            }
        }

        // Insert ke tabel pivot parameter_titik_pengamatan
        ParameterTitikPengamatan::insert($insert);
    }
}
