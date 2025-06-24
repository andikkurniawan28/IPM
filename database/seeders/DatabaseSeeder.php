<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;
use App\Models\Satuan;
use App\Models\Parameter;
use App\Models\TitikPengamatan;
use App\Models\KategoriParameter;
use App\Models\ParameterTitikPengamatan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        // Simpan id kategori dan satuan
        $kategori = KategoriParameter::pluck('id', 'nama');
        $satuan = Satuan::pluck('id', 'simbol');

        // Insert parameter
        Parameter::insert([
            [
                'nama' => 'Rotation Speed',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['RPM'],
                'simbol' => 'Rpm',
                'keterangan' => 'Kecepatan putaran peralatan dalam satuan RPM.'
            ],
            [
                'nama' => 'Electric Current',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['A'],
                'simbol' => 'Amp',
                'keterangan' => 'Besarnya arus listrik pada peralatan.'
            ],
            [
                'nama' => 'Voltage',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['V'],
                'simbol' => 'Volt',
                'keterangan' => 'Tegangan kerja sistem atau alat.'
            ],
            [
                'nama' => 'Pressure',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['bar'],
                'simbol' => 'Press',
                'keterangan' => 'Tekanan sistem dalam satuan bar.'
            ],
            [
                'nama' => 'Temperature',
                'kategori_parameter_id' => $kategori['Peralatan'],
                'satuan_id' => $satuan['°C'],
                'simbol' => 'Temp',
                'keterangan' => 'Suhu pengamatan dalam satuan derajat Celsius.'
            ],
            [
                'nama' => 'Product Count',
                'kategori_parameter_id' => $kategori['Produksi'],
                'satuan_id' => $satuan['unit'],
                'simbol' => 'Qty',
                'keterangan' => 'Jumlah unit produk yang dihasilkan.'
            ],
            [
                'nama' => 'Flow',
                'kategori_parameter_id' => $kategori['Produksi'],
                'satuan_id' => $satuan['m³/h'],
                'simbol' => 'flow',
                'keterangan' => 'Jumlah aliran.'
            ]
        ]);

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
        // ParameterTitikPengamatan::create($insert);
        foreach ($insert as $data) {
            ParameterTitikPengamatan::create($data); // ✅ Akan memicu event model 'created'
        }
    }
}
