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
            ['id' => 4, 'name' => 'setelah_menabung', 'display_name' => 'Setelah Menabung', 'description' => 'Navigasi ke menu Setelah Menabung'],
            ['id' => 5, 'name' => 'cara_menabung', 'display_name' => 'Cara Menabung', 'description' => 'Navigasi ke menu Cara Menabung'],
            ['id' => 6, 'name' => 'syarat_ketentuan', 'display_name' => 'Syarat & Ketentuan', 'description' => 'Navigasi ke menu Syarat & Ketentuan'],
            ['id' => 7, 'name' => 'faq', 'display_name' => 'FAQ', 'description' => 'Navigasi ke menu FAQ'],
            ['id' => 8, 'name' => 'mitra_duma', 'display_name' => 'Mitra Duma', 'description' => 'Navigasi ke menu Mitra Duma'],
            ['id' => 9, 'name' => 'tabungan_haji_create', 'display_name' => 'Tabungan Haji', 'description' => 'Navigasi ke halaman utama menu Tabungan Haji'],
            ['id' => 10, 'name' => 'tabungan_umrah_create', 'display_name' => 'Tabungan Umrah', 'description' => 'Navigasi ke halaman utama menu Tabungan Umrah'],
            ['id' => 11, 'name' => 'iumrah', 'display_name' => 'I-Umrah', 'description' => 'Navigasi ke halaman utama menu I-Umrah'],
            ['id' => 12, 'name' => 'setting_pin', 'display_name' => 'Setting PIN', 'description' => 'Navigasi ke menu Setting PIN'],
            ['id' => 13, 'name' => 'detail_saldo', 'display_name' => 'Detail Saldo', 'description' => 'Navigasi ke halaman Detail Saldo Customer'],
            ['id' => 14, 'name' => 'duma_card', 'display_name' => 'Duma Card', 'description' => 'Navigasi ke halaman yang menampilkan Duma Card'],
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
