<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NotifikasiGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('notifikasi_groups')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'name' => 'semua', 'display_name' => 'Semua', 'description' => 'Semua user yang sudah login di MyDuma'],
            ['id' => 2, 'name' => 'calon_nasabah', 'display_name' => 'Calon Nasabah', 'description' => 'Customer yang sudah login namun belum mendaftar tabungan haji/umrah.'],
            ['id' => 3, 'name' => 'nasabah_pasif', 'display_name' => 'Nasabah Pasif', 'description' => 'Customer yang sudah terdaftar sebagai nasabah tabungan haji/umrah, namun belum melakukan transaksi apapun.'],
            ['id' => 4, 'name' => 'nasabah_aktif', 'display_name' => 'Nasabah Aktif', 'description' => 'Nasabah yang sudah menabung / melakukan setoran awal'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('notifikasi_groups')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
