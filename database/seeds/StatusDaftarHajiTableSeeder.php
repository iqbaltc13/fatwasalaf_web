<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusDaftarHajiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('status_daftar_hajis')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'display_name' => 'Pendaftaran berhasil', 'name' => 'pendaftaran_berhasil','note' => '-'],
            ['id' => 2, 'display_name' => 'Data jamaah perlu direvisi', 'name' => 'data_jamaah_perlu_direvisi','note' => '-'],
            ['id' => 3, 'display_name' => 'Pendaftaran disetujui', 'name' => 'pendaftaran_disetujui_admin','note' => '-'],
            ['id' => 4, 'display_name' => 'Biaya administrasi sudah dibayar', 'name' => 'biaya_administrasi_terbayar','note' => '-'],
            ['id' => 5, 'display_name' => 'Diproses kbih', 'name' => 'diproses_kbih','note' => '-'],
            ['id' => 6, 'display_name' => 'Nomor porsi sudah didapat', 'name' => 'nomor_porsi_didapat','note' => '-'],
            ['id' => 7, 'display_name' => 'Dikirim ke Sisprohaj', 'name' => 'mengirim_ke_sisprohaj','note' => '-'],
            ['id' => 8, 'display_name' => 'Proses pelunasan setoran', 'name' => 'proses_pelunasan_setoran','note' => '-'],
            ['id' => 9, 'display_name' => 'Setoran Lunas', 'name' => 'setoran_lunas','note' => '-'],
            ['id' => 10, 'display_name' => 'Proses pelunasan total', 'name' => 'proses_pelunasan_total','note' => '-'],
            ['id' => 11, 'display_name' => 'Biaya total lunas', 'name' => 'biaya_total_lunas','note' => '-'],
            ['id' => 12, 'display_name' => 'Selesai', 'name' => 'selesai','note' => '-'],

            ['id' => 13, 'display_name' => 'Pendaftaran ditolak', 'name' => 'gagal ditolak_admin','note' => '-'],
            ['id' => 14, 'display_name' => 'Proses dibatalkan customer', 'name' => 'gagal dibatalkan_customer','note' => '-'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('status_daftar_hajis')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
