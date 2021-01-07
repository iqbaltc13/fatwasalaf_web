<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatusTabunganUmrahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('status_tabungan_umrahs')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'display_name' => 'Berhasil dibuat', 'name' => 'dibuat','note' => '-'],
            ['id' => 2, 'display_name' => 'Biaya Administrasi terbayar', 'name' => 'biaya_administrasi_terbayar','note' => '-'],
            ['id' => 3, 'display_name' => 'Proses Menabung', 'name' => 'proses_menabung','note' => '-'],
            ['id' => 4, 'display_name' => 'Selesai', 'name' => 'selesai','note' => '-'],
            ['id' => 5, 'display_name' => 'Dibatalkan Customer', 'name' => 'dibatalkan_customer','note' => '-'],
            ['id' => 6, 'display_name' => 'Dibatalkan Admin', 'name' => 'dibatalkan_admin','note' => '-'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('status_tabungan_umrahs')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
