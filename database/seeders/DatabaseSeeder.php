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
            ['nama' => 'Pemimpin'],
            ['nama' => 'Kabag Pabrikasi'],
            ['nama' => 'Kabag Teknik'],
            ['nama' => 'Kasie Pabrikasi'],
            ['nama' => 'Kasie Teknik'],
            ['nama' => 'Kasubsie Pabrikasi'],
            ['nama' => 'Kasubsie Teknik'],
            ['nama' => 'Mandor Pabrikasi'],
            ['nama' => 'Mandor Teknik'],
            ['nama' => 'Tanaman'],
            ['nama' => 'TUK'],
            ['nama' => 'Tamu'],
        ]);

        User::insert([
            [
                'role_id' => 1,
                'name' => ucwords('arifin'),
                'email' => "arifin@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 2,
                'name' => ucwords('tri sunu hardi'),
                'email' => "sunu@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 3,
                'name' => ucwords('agung nugroho'),
                'email' => "agung@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 4,
                'name' => ucwords('sri winarno'),
                'email' => "win@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 4,
                'name' => ucwords('tataq seviarto'),
                'email' => "tataq@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 6,
                'name' => ucwords('firmansyah agil saputra'),
                'email' => "agil@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 6,
                'name' => ucwords('faiz'),
                'email' => "faiz@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 6,
                'name' => ucwords('m aulia ramadhan'),
                'email' => "rama@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 6,
                'name' => ucwords('yanuar'),
                'email' => "yanuar@mdp.com",
                'password' => bcrypt('password'),
            ],
            [
                'role_id' => 6,
                'name' => ucwords('vicky dwi putra'),
                'email' => "vicky@mdp.com",
                'password' => bcrypt('password'),
            ],
        ]);

        // Insert kategori parameter
        KategoriParameter::insert([
            ['nama' => 'Proses'],
            ['nama' => 'Utilitas'],
            // ['nama' => 'Lingkungan'],
        ]);

        // Insert satuan
        Satuan::insert([
            ['nama' => 'Persen', 'simbol' => '%'],
            ['nama' => 'ICUMSA', 'simbol' => 'IU'],
            ['nama' => 'Derajat Pol', 'simbol' => '°ZK'],
            ['nama' => 'pH', 'simbol' => 'pH'],
            ['nama' => 'Nephelometric Turbidity Unit', 'simbol' => 'NTU'],
            ['nama' => 'PPM', 'simbol' => 'ppm'],
            ['nama' => 'Milimeter', 'simbol' => 'mm'],
            ['nama' => 'Celcius', 'simbol' => '°C'],
            ['nama' => 'Kilogram', 'simbol' => 'kg'],
            ['nama' => 'Gram', 'simbol' => 'g'],
            ['nama' => 'Ton', 'simbol' => 't'],
            ['nama' => 'Kuintal', 'simbol' => 'ku'],
            // ['nama' => 'Kelvin', 'simbol' => 'K'],
            // ['nama' => 'Ampere', 'simbol' => 'A'],
            // ['nama' => 'Volt', 'simbol' => 'V'],
            // ['nama' => 'Watt', 'simbol' => 'W'],
            // ['nama' => 'Kilowatt', 'simbol' => 'kW'],
            // ['nama' => 'Megawatt', 'simbol' => 'MW'],
            // ['nama' => 'Kilowatt-hour', 'simbol' => 'kWh'],
            // ['nama' => 'Putaran per Menit', 'simbol' => 'Persen'],
            // ['nama' => 'Pascal', 'simbol' => 'Pa'],
            // ['nama' => 'Kilopascal', 'simbol' => 'kPa'],
            // ['nama' => 'Bar', 'simbol' => 'bar'],
            // ['nama' => 'Liter', 'simbol' => 'L'],
            // ['nama' => 'Mililiter', 'simbol' => 'mL'],
            // ['nama' => 'Meter Kubik', 'simbol' => 'm³'],
            // ['nama' => 'Meter Kubik per Jam', 'simbol' => 'm³/h'],
            // ['nama' => 'Liter per Menit', 'simbol' => 'L/min'],
            // ['nama' => 'Persentase', 'simbol' => '%'],
            // ['nama' => 'Newton', 'simbol' => 'N'],
            // ['nama' => 'Kilonewton', 'simbol' => 'kN'],
            // ['nama' => 'Meter', 'simbol' => 'm'],
            // ['nama' => 'Centimeter', 'simbol' => 'cm'],
            // ['nama' => 'Jam', 'simbol' => 'h'],
            // ['nama' => 'Menit', 'simbol' => 'min'],
            // ['nama' => 'Detik', 'simbol' => 's'],
            // ['nama' => 'Lux', 'simbol' => 'lx'],
            // ['nama' => 'Decibel', 'simbol' => 'dB'],
            // ['nama' => 'Hz', 'simbol' => 'Hz'],
            // ['nama' => 'Ohm', 'simbol' => 'Ω'],
            // ['nama' => 'Siklus', 'simbol' => 'cycle'],
            // ['nama' => 'Jumlah', 'simbol' => 'unit'],
            // ['nama' => 'Kalori', 'simbol' => 'cal'],
            // ['nama' => 'Joule', 'simbol' => 'J'],
            // ['nama' => 'Kandungan Air', 'simbol' => '%RH'],
            // ['nama' => 'pH', 'simbol' => 'pH'],
            // ['nama' => 'Brix', 'simbol' => '°Bx'],
            // ['nama' => 'Tegangan', 'simbol' => 'MPa'],
            // ['nama' => 'Kecepatan Alir', 'simbol' => 'm/s'],
            // ['nama' => 'Frekuensi', 'simbol' => '1/s'],
            // ['nama' => 'Energi Termal', 'simbol' => 'BTU'],
            // ['nama' => 'Lumen', 'simbol' => 'lm'],
            // ['nama' => 'Density', 'simbol' => 'kg/m³'],
            // ['nama' => 'Konsentrasi', 'simbol' => 'mol/L'],
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
            // ['keterangan' => 'Hijau'],
            // ['keterangan' => 'Kuning'],
            // ['keterangan' => 'Merah'],

            // Untuk parameter_id 6 → mode kerja
            // ['keterangan' => 'Manual'],
            // ['keterangan' => 'Otomatis'],

            // Untuk parameter_id 7 → validasi
            // ['keterangan' => 'Valid'],
            // ['keterangan' => 'Tidak Valid'],

            // Untuk parameter_id 8 → keputusan
            // ['keterangan' => 'Disetujui'],
            // ['keterangan' => 'Ditolak'],
            // ['keterangan' => 'Revisi'],

            // Untuk parameter_id 9 → koneksi
            // ['keterangan' => 'Terkoneksi'],
            // ['keterangan' => 'Tidak Terkoneksi'],
        ]);

        // Simpan id kategori dan satuan
        $kategori = KategoriParameter::pluck('id', 'nama');
        $satuan = Satuan::pluck('id', 'nama');
        $parameters = [
            [
                'nama' => 'Brix',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'brix',
                'keterangan' => '%Brix',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Pol',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'pol',
                'keterangan' => '%Pol',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Pol Baca',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Derajat Pol'],
                'simbol' => 'polB',
                'keterangan' => 'Pol Baca',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'HK',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'hk',
                'keterangan' => '%HK',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Rendemen',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'r',
                'keterangan' => 'Rendemen',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'ICUMSA',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['ICUMSA'],
                'simbol' => 'IU',
                'keterangan' => 'Warna Larutan',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Moisture Content',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'mc',
                'keterangan' => 'Kadar Cairan',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Zat Kering',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'zk',
                'keterangan' => 'Zat Kering',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'CaO',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'caO',
                'keterangan' => 'Kadar CaO',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Keasaman',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['pH'],
                'simbol' => 'pH',
                'keterangan' => 'Keasaman',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Turbidity',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Nephelometric Turbidity Unit'],
                'simbol' => 'turb',
                'keterangan' => 'Kekeruhan',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'TDS',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['PPM'],
                'simbol' => 'tds',
                'keterangan' => 'Jumlah Padatan Terlarut',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Hardness',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['PPM'],
                'simbol' => 'sadah',
                'keterangan' => 'Kesadahan',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Fosfor Pentoksida',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['PPM'],
                'simbol' => 'p2O5',
                'keterangan' => 'Fosfor Pentoksida',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Sulfur Dioksida',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'so2',
                'keterangan' => 'Sulfur Dioksida',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Sugar Diameter',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Milimeter'],
                'simbol' => 'bjb',
                'keterangan' => 'Diameter Kristal',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Total Sugar As Invert',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'tsai',
                'keterangan' => 'Total Sugar As Invert',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Succrose',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'succrose',
                'keterangan' => 'Succrose',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Fructose',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'fructose',
                'keterangan' => 'Fructose',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Glucose',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'glucose',
                'keterangan' => 'Glucose',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Temperatur',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Celcius'],
                'simbol' => 'suhu',
                'keterangan' => 'Temperatur',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Preparation Index',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'pi',
                'keterangan' => 'Preparation Index',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Kadar Sabut',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'sabut',
                'keterangan' => 'Kadar Sabut',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Kadar Kapur',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'kapur',
                'keterangan' => 'Kadar Kapur',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Pol Ampas',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'polA',
                'keterangan' => 'Pol Ampas',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Fosfat',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'fosfat',
                'keterangan' => 'Kadar Fosfat',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Gula Reduksi',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'gured',
                'keterangan' => 'Gula Reduksi',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Saccharosa',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'saccharosa',
                'keterangan' => 'Saccharosa',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Optical Density',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'od',
                'keterangan' => 'Optical Density',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Dextran',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'dext',
                'keterangan' => 'Dextran',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Berat Kg',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Kilogram'],
                'simbol' => 'berat',
                'keterangan' => 'Berat dalam Kg',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Dispersitas',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'disp',
                'keterangan' => 'Dispersitas',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Silika',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'silika',
                'keterangan' => 'Silika',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => '%Ampas',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'ampas',
                'keterangan' => '%Ampas',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
            [
                'nama' => 'Brixwegger',
                'kategori_parameter_id' => $kategori['Proses'],
                'satuan_id' => $satuan['Persen'],
                'simbol' => 'brixw',
                'keterangan' => 'Brixwegger',
                'metode_agregasi' => 'avg',
                'jenis' => 'kuantitatif',
            ],
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
            ['kode' => 'TNGK', 'nama' => 'Tangki Tetes'],
        ]);

        $zona = Zona::pluck('id', 'kode');
        TitikPengamatan::insert([
            ['urutan' => 1, 'nama' => 'Gilingan 1', 'kode' => 'G1', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 1'],
            ['urutan' => 2, 'nama' => 'Gilingan 2', 'kode' => 'G2', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 2'],
            ['urutan' => 3, 'nama' => 'Gilingan 3', 'kode' => 'G3', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 3'],
            ['urutan' => 4, 'nama' => 'Gilingan 4', 'kode' => 'G4', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 4'],
            ['urutan' => 5, 'nama' => 'Gilingan 5', 'kode' => 'G5', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Gilingan 5'],
            ['urutan' => 6, 'nama' => 'Cane Cutter', 'kode' => 'CC', 'zona_id' => $zona['GIL'], 'keterangan' => 'Mesin Pencacah Tebu'],
            ['urutan' => 7, 'nama' => 'Nira Mentah', 'kode' => 'NM', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Mentah'],
            ['urutan' => 8, 'nama' => 'Nira Reaction', 'kode' => 'NR', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira di Reaction Tank'],
            ['urutan' => 9, 'nama' => 'Nira Tapis', 'kode' => 'NT', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Tapis'],
            ['urutan' => 10, 'nama' => 'Nira Encer', 'kode' => 'NE', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Encer'],
            ['urutan' => 11, 'nama' => 'Nira Defekasi', 'kode' => 'ND', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Defekasi'],
            ['urutan' => 12, 'nama' => 'Nira Kotor', 'kode' => 'Nirkot', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Kotor'],
            ['urutan' => 13, 'nama' => 'Nira Pre Liming', 'kode' => 'NPL', 'zona_id' => $zona['PMN'], 'keterangan' => 'Nira Pre Liming'],
            ['urutan' => 14, 'nama' => 'RVF1', 'kode' => 'RVF1', 'zona_id' => $zona['PMN'], 'keterangan' => 'RVF1'],
            ['urutan' => 15, 'nama' => 'RVF2', 'kode' => 'RVF2', 'zona_id' => $zona['PMN'], 'keterangan' => 'RVF2'],
            ['urutan' => 16, 'nama' => 'RVF3', 'kode' => 'RVF3', 'zona_id' => $zona['PMN'], 'keterangan' => 'RVF3'],
            ['urutan' => 17, 'nama' => 'RVF4', 'kode' => 'RVF4', 'zona_id' => $zona['PMN'], 'keterangan' => 'RVF4'],
            ['urutan' => 18, 'nama' => 'Blotong Decanter 1', 'kode' => 'BDEC1', 'zona_id' => $zona['PMN'], 'keterangan' => 'Blotong Decanter 1'],
            ['urutan' => 19, 'nama' => 'Blotong Decanter 2', 'kode' => 'BDEC2', 'zona_id' => $zona['PMN'], 'keterangan' => 'Blotong Decanter 2'],
            ['urutan' => 20, 'nama' => 'Blotong Decanter 3', 'kode' => 'BDEC3', 'zona_id' => $zona['PMN'], 'keterangan' => 'Blotong Decanter 3'],
            ['urutan' => 21, 'nama' => 'Blotong Decanter 4', 'kode' => 'BDEC4', 'zona_id' => $zona['PMN'], 'keterangan' => 'Blotong Decanter 4'],
            ['urutan' => 22, 'nama' => 'Filtrat Decanter 1', 'kode' => 'FDEC1', 'zona_id' => $zona['PMN'], 'keterangan' => 'Filtrat Decanter 1'],
            ['urutan' => 23, 'nama' => 'Filtrat Decanter 2', 'kode' => 'FDEC2', 'zona_id' => $zona['PMN'], 'keterangan' => 'Filtrat Decanter 2'],
            ['urutan' => 24, 'nama' => 'Filtrat Decanter 3', 'kode' => 'FDEC3', 'zona_id' => $zona['PMN'], 'keterangan' => 'Filtrat Decanter 3'],
            ['urutan' => 25, 'nama' => 'Filtrat Decanter 4', 'kode' => 'FDEC4', 'zona_id' => $zona['PMN'], 'keterangan' => 'Filtrat Decanter 4'],
            ['urutan' => 26, 'nama' => 'Nira Kental', 'kode' => 'NK1', 'zona_id' => $zona['UAP'], 'keterangan' => 'Nira Kental'],
            ['urutan' => 27, 'nama' => 'Lamela In', 'kode' => 'LMI', 'zona_id' => $zona['UAP'], 'keterangan' => 'Lamela In'],
            ['urutan' => 28, 'nama' => 'Lamela Out', 'kode' => 'LMO', 'zona_id' => $zona['UAP'], 'keterangan' => 'Lamela Out'],
            ['urutan' => 29, 'nama' => 'Magma A Raw', 'kode' => 'MGAR', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma A Raw'],
            ['urutan' => 30, 'nama' => 'Magma Avinasi', 'kode' => 'MGAV', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma Avinasi'],
            ['urutan' => 31, 'nama' => 'Magma C', 'kode' => 'MGC', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma C (Einwuurf C)'],
            ['urutan' => 32, 'nama' => 'Magma D1', 'kode' => 'MGD1', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma D1'],
            ['urutan' => 33, 'nama' => 'Magma D2', 'kode' => 'MGD2', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma D2 (Einwuurf D)'],
            ['urutan' => 34, 'nama' => 'Magma RS', 'kode' => 'MGRS', 'zona_id' => $zona['MSK'], 'keterangan' => 'Magma RS'],
            ['urutan' => 35, 'nama' => 'Masakan A', 'kode' => 'MSKA', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan A'],
            ['urutan' => 36, 'nama' => 'Masakan A Raw', 'kode' => 'MSKAr', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan A Raw'],
            ['urutan' => 37, 'nama' => 'Masakan C', 'kode' => 'MSKC', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan C'],
            ['urutan' => 38, 'nama' => 'Masakan D1', 'kode' => 'MSKD1', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan D1'],
            ['urutan' => 39, 'nama' => 'Masakan D2', 'kode' => 'MSKD2', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan D2'],
            ['urutan' => 40, 'nama' => 'Masakan R1', 'kode' => 'MSKR1', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan R1'],
            ['urutan' => 41, 'nama' => 'Masakan R2', 'kode' => 'MSKR2', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan R2'],
            ['urutan' => 42, 'nama' => 'Masakan R3', 'kode' => 'MSKR3', 'zona_id' => $zona['MSK'], 'keterangan' => 'Masakan R3'],
            ['urutan' => 43, 'nama' => 'CVP A', 'kode' => 'CVPA', 'zona_id' => $zona['MSK'], 'keterangan' => 'CVP A'],
            ['urutan' => 44, 'nama' => 'CVP C', 'kode' => 'CVPC', 'zona_id' => $zona['MSK'], 'keterangan' => 'CVP C'],
            ['urutan' => 45, 'nama' => 'CVP D', 'kode' => 'CVPD', 'zona_id' => $zona['MSK'], 'keterangan' => 'CVP D'],
            ['urutan' => 46, 'nama' => 'Klare RS', 'kode' => 'KLRS', 'zona_id' => $zona['PTR'], 'keterangan' => 'Klare RS'],
            ['urutan' => 47, 'nama' => 'Klare SHS', 'kode' => 'KLSH', 'zona_id' => $zona['PTR'], 'keterangan' => 'Klare SHS'],
            ['urutan' => 48, 'nama' => 'Klare D', 'kode' => 'KLD', 'zona_id' => $zona['PTR'], 'keterangan' => 'Klare D'],
            ['urutan' => 49, 'nama' => 'Stroop A Bawah', 'kode' => 'SAB', 'zona_id' => $zona['PTR'], 'keterangan' => 'Stroop A Bawah'],
            ['urutan' => 50, 'nama' => 'Stroop C Bawah', 'kode' => 'SCB', 'zona_id' => $zona['PTR'], 'keterangan' => 'Stroop C Bawah'],
            ['urutan' => 51, 'nama' => 'R1 Mol Bawah', 'kode' => 'R1B', 'zona_id' => $zona['PTR'], 'keterangan' => 'R1 Mol Bawah'],
            ['urutan' => 52, 'nama' => 'R2 Mol Bawah', 'kode' => 'R2B', 'zona_id' => $zona['PTR'], 'keterangan' => 'R2 Mol Bawah'],
            ['urutan' => 53, 'nama' => 'Remelter A Bawah', 'kode' => 'RAB', 'zona_id' => $zona['PTR'], 'keterangan' => 'Remelter A Bawah'],
            ['urutan' => 54, 'nama' => 'Remelter C/D Bawah', 'kode' => 'RCDB', 'zona_id' => $zona['PTR'], 'keterangan' => 'Remelter C/D Bawah'],
            ['urutan' => 55, 'nama' => 'Tetes Puteran', 'kode' => 'TTSP', 'zona_id' => $zona['PTR'], 'keterangan' => 'Tetes Puteran'],
            ['urutan' => 56, 'nama' => 'Material Siwaran', 'kode' => 'MTS', 'zona_id' => $zona['PTR'], 'keterangan' => 'Material Siwaran'],
            ['urutan' => 57, 'nama' => 'RS Kedatangan', 'kode' => 'RSK', 'zona_id' => $zona['PTR'], 'keterangan' => 'RS Kedatangan'],
            ['urutan' => 58, 'nama' => 'Gula RS In', 'kode' => 'RSI', 'zona_id' => $zona['PTR'], 'keterangan' => 'RS In'],
            ['urutan' => 59, 'nama' => 'GKP', 'kode' => 'GKP', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula Kristal Putih'],
            ['urutan' => 60, 'nama' => 'Gula Premium', 'kode' => 'GP', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula Premium'],
            ['urutan' => 61, 'nama' => 'Gula R2', 'kode' => 'GR2', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula R2'],
            ['urutan' => 62, 'nama' => 'Gula A Raw', 'kode' => 'GAr', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula A Raw'],
            ['urutan' => 63, 'nama' => 'Gula C', 'kode' => 'GC', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula C'],
            ['urutan' => 64, 'nama' => 'Gula D1', 'kode' => 'GD1', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula D1'],
            ['urutan' => 65, 'nama' => 'Gula D2', 'kode' => 'GD2', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula D2'],
            ['urutan' => 66, 'nama' => 'Gula RS Produk', 'kode' => 'GRS', 'zona_id' => $zona['PTR'], 'keterangan' => 'Gula RS Produk'],
            ['urutan' => 67, 'nama' => 'Tetes Tangki 1', 'kode' => 'TT1', 'zona_id' => $zona['TNGK'], 'keterangan' => 'Tetes Tangki 1'],
            ['urutan' => 68, 'nama' => 'Tetes Tangki 2', 'kode' => 'TT2', 'zona_id' => $zona['TNGK'], 'keterangan' => 'Tetes Tangki 2'],
            ['urutan' => 69, 'nama' => 'Tetes Tangki 3', 'kode' => 'TT3', 'zona_id' => $zona['TNGK'], 'keterangan' => 'Tetes Tangki 3'],
            ['urutan' => 70, 'nama' => 'Tetes Kumpulan', 'kode' => 'TK', 'zona_id' => $zona['TNGK'], 'keterangan' => 'Tetes Kumpulan'],
            ['urutan' => 71, 'nama' => 'Jiangxian Jianglian', 'kode' => 'JJ', 'zona_id' => $zona['KTL'], 'keterangan' => 'JJ'],
            ['urutan' => 72, 'nama' => 'Yoshimine 1', 'kode' => 'Y1', 'zona_id' => $zona['KTL'], 'keterangan' => 'Yoshimine 1'],
            ['urutan' => 73, 'nama' => 'Yoshimine 2', 'kode' => 'Y2', 'zona_id' => $zona['KTL'], 'keterangan' => 'Yoshimine 2'],
            ['urutan' => 74, 'nama' => 'WTP', 'kode' => 'WTP', 'zona_id' => $zona['KTL'], 'keterangan' => 'WTP'],
            ['urutan' => 75, 'nama' => 'HW', 'kode' => 'HW', 'zona_id' => $zona['KTL'], 'keterangan' => 'HW'],
            ['urutan' => 76, 'nama' => 'Daerator JJ', 'kode' => 'DJJ', 'zona_id' => $zona['KTL'], 'keterangan' => 'DJJ'],
            ['urutan' => 77, 'nama' => 'Daerator Yoshimine 1', 'kode' => 'DY1', 'zona_id' => $zona['KTL'], 'keterangan' => 'D Yoshimine 1'],
            ['urutan' => 78, 'nama' => 'Daerator Yoshimine 2', 'kode' => 'DY2', 'zona_id' => $zona['KTL'], 'keterangan' => 'D Yoshimine 2'],
            // ['urutan' => 79, 'nama' => 'Daerator Yoshimine 2', 'kode' => 'DY2', 'zona_id' => $zona['KTL'], 'keterangan' => 'D Yoshimine 2'],
        ]);


        // Mapping titik dan parameter ke relasi
        $titik = TitikPengamatan::pluck('id', 'nama');
        $param = Parameter::pluck('id', 'nama');

        $relasi = [
            ['Gilingan 1', 'Brix'],
            ['Gilingan 1', 'Pol'],
            ['Gilingan 1', 'HK'],
            ['Gilingan 1', 'Keasaman'],
            ['Gilingan 1', 'Rendemen'],
            ['Gilingan 1', 'ICUMSA'],
            ['Gilingan 2', 'Brix'],
            ['Gilingan 2', 'Pol'],
            ['Gilingan 2', 'HK'],
            ['Gilingan 2', 'Keasaman'],
            ['Gilingan 3', 'Brix'],
            ['Gilingan 3', 'Pol'],
            ['Gilingan 3', 'HK'],
            ['Gilingan 3', 'Keasaman'],
            ['Gilingan 4', 'Brix'],
            ['Gilingan 4', 'Pol'],
            ['Gilingan 4', 'HK'],
            ['Gilingan 4', 'Keasaman'],
            ['Gilingan 5', 'Brix'],
            ['Gilingan 5', 'Pol'],
            ['Gilingan 5', 'HK'],
            ['Gilingan 5', 'Keasaman'],
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
