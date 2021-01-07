<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CaraMenabungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cara_menabungs')->truncate();
        Schema::enableForeignKeyConstraints();
        $datas = [
            ['nomor' => 1, 'judul' => 'Masuk ke dalam fitur “Tabungan Umrah” atau “Tabungan Haji”','konten' => '-'],            
            ['nomor' => 2, 'judul' => 'Isi E-Form Registration dan lengkapi data yang dibutuhkan ya!','konten' => '-'],            
            ['nomor' => 3, 'judul' => 'Pilih paket tabungan yang sesuai buat #DumaFriends','konten' => '-'],            
            ['nomor' => 4, 'judul' => 'Silahkan melakukan pembayaran pembelian MyDuma Point, dan MyDuma Point tersebut yang akan menjadi saldo awal.','konten' => '-'],
            ['nomor' => 5, 'judul' => '#DumaFriends akan mendapatkan nomer ID dan bisa mulai menabung. Selalu istiqomah ya, Allah SWT pasti senang melihat niat baik #DumaFriends yang istiqomah.','konten' => '-'],        
            ['nomor' => 6, 'judul' => 'Ketika tabungan #DumaFriends sudah mencapai 70% dari target tabungan, tim MyDuma Indonesia akan melakukan konfirmasi ulang untuk persiapan dan finalisasi biaya.','konten' => '-'],        
            ['nomor' => 7, 'judul' => 'Jika #DumaFriends menyepakati untuk dilakukan persiapan dan finalisasi biaya, maka tim MyDuma Indonesia akan melanjutkan proses.','konten' => '-'],        
            ['nomor' => 8, 'judul' => '#DumaFriends akan bisa memilih travel agent yang sudah lolos dari penilaian tim MyDuma Indonesia dan tentunya yang akan sesuai dengan keinginan.','konten' => '-'],        
            ['nomor' => 9, 'judul' => 'Tim MyDuma Indonesia akan menjadi personal assitance dan bertanggung jawab penuh mulai dari persiapan keberangkatan hingga selesai.','konten' => '-'],        
            ['nomor' => 10, 'judul' => 'Proses Monitoring dan Quality Control juga terus berjalan melalu applikasi MyDuma. Semoga amal ibadah #DumaFriends diterima disisi Allah.','konten' => '-'],        
        ];

        foreach ($datas as $data) {
	        DB::table('cara_menabungs')->insert(array_merge($data, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
