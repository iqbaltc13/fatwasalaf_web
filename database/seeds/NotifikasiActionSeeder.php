<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NotifikasiActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('notifikasi_actions')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'name' => 'dashboard', 'display_name' => 'Beranda', 'description' => 'Halaman utama'],
            ['id' => 2, 'name' => 'play_store', 'display_name' => 'Play Store / App Store', 'description' => 'Navigasi ke halaman playstore (android) atau appstore (ios)'],
            ['id' => 3, 'name' => 'artikel_detail', 'display_name' => 'Artikel', 'description' => 'Navigasi ke halaman detail artikel, berdasarkan id artikel terlampir'],
           

            ['id' => 12, 'name' => 'setting_pin', 'display_name' => 'Setting PIN', 'description' => 'Navigasi ke menu Setting PIN'],
           
            ['id' => 15, 'name' => 'edit_profile', 'display_name' => 'Edit Profile', 'description' => 'Navigasi ke menu Edit Profile'],
            ['id' => 16, 'name' => 'ubah_kata_sandi', 'display_name' => 'Ubah Kata Sandi', 'description' => 'Navigasi ke menu Ubah Kata Sandi'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('notifikasi_actions')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
