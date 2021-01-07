<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('faqs')->truncate();
        Schema::enableForeignKeyConstraints();
        $datas = [
            ['nomor' => 1, 'judul' => 'Kenapa harus nabung di MyDuma?','konten' => '<html>Karena di MyDuma,#DumaFriends bukan hanya dapat layanan menabung, tapi MyDuma juga melakukan proses quality control pada MitraTravel sehingga pelayanan perjalanannya pun akan relevan dan aman bagi #DumaFriends.</html>'],
            
            ['nomor' => 2, 'judul' => 'Aman nggak nih nabung di MyDuma?','konten' => '<html>InsyaAllah aman dong, karena MyDuma bekerja sama dengan Bank Mega Syariah untuk menampung uang #DumaFriends di rekening escrow. Dan tentunya berada dibawah pengawasan OJK (Otoritas Jasa Keuangan).</html>'],
            
            ['nomor' => 3, 'judul' => 'Apa aja sih komponen yang kita tabung di MyDuma untuk tabungan umrah 30 juta itu?','konten' => '<html>- Biaya umrah, yang dijamin MyDuma akan melakukan efisiensi biaya dan tetap dengan standard perjalanan yang kekinian namun tetap fokus pada nilai ibadah. Besaran nilai yang akan ditabung Rp.25.000.000.<br><br>- Uang saku (living cost), jadi #DumaFriends tidak perlu pusing lagi untuk mikir anggaran nya karena sudah ditabung sejak awal. Besaran yang akan ditabung untuk uang saku adalah Rp.1.500.000.<br><br>- Biaya Administrasi dan Travel Dokumen, komponen ini terdiri dari beberapa hal yaitu asuransi perjalanan, vaksin, dan visa. Besaran nya adalah Rp.1.500.000.<br><br>- Mitigasi Inflasi sebesar Rp.1.000.000, seperti yang kita tahu jika inflasi memingkinkan terjadi karena beberapa faktor yaitu karena pelemahan mata rupiah atau kenaikan harga dasar. Maka, perlu ada dana yang ditabung untuk mengantisipasi hal tersebut. Namun jika tidak terjadi inflasi, maka nominal tersebut akan menjadi tambahan uang saku.<br><br>- Service charge, dengan besaran nilai Rp.1.000.000 sebagai biaya pelayanan yang akan didapatkan #DumaFriends sejak memulai menabung hingga melaksanakan perjalanan ibadah nya.<br><br>Jadi intinya adalah ketika #DumaFriends mulai menabung maka #DumaFriends sudah tidak perlu berpikir apapun lagi sampai realisasi perjalanan umrah nya. Tetap istiqomah ya!</html>'],
            
            ['nomor' => 4, 'judul' => 'Apa aja sih komponen yang kita tabung di MyDuma untuk tabungan haji?','konten' => '<html>- Biaya porsi haji, biaya porsi ini merupakan biaya awal sebagai calon jama’ah haji untuk mendapatkan nomor porsi (kuota). Besarannya adalah Rp.25.000.000 untuk haji regular dan Rp.65.000.000 untuk haji plus.<br><br>- Service charge, dengan besaran nilai Rp.1.000.000 untuk biaya pelayanan yang akan didapatkan sejak awal menabung hingga mendapatkan nomor porsi haji nya.<br><br>Jadi intinya adalah ketika #DumaFriends mulai menabung maka #DumaFriends sudah tidak perlu berpikir apapun lagi sampai realisasi pembelian nomor porsi haji (kuota).</html>'],

            ['nomor' => 5, 'judul' => 'Bagaimana kalau ditengah-tengah proses menabung lalu batal?','konten' => '<html>Semua setoran nominal tabungan akan kembali 100% dan MyDuma point bisa ditransfer ke user lain atau masih bisa berlaku 12 bulan setelah pembatalan.</html>'],
            
            ['nomor' => 6, 'judul' => 'Kalau berubah target waktu menabungnya gimana?','konten' => '<html>Aman kok, nabung di MyDuma fleksibel. Yang penting tetep istiqomah yaa!</html>'],

            ['nomor' => 7, 'judul' => 'Proses quality control nya gimana untuk Mitra Travel?','konten' => '<html>Untuk proses ini kita ada 3 macam. Pertama, proses seleksi Mitra Travel. Kedua, proses persiapan keberangkatan. Ketiga, proses ketika lagi melaksanakan ibadah di Arab Saudi yang ada fitur Personal Guard di aplikasi MyDuma.</html>'],
            
            ['nomor' => 8, 'judul' => 'Bagaimana standarisasi perjalanan umrah yang akan diberikan MyDuma?','konten' => '<html>Dengan target tabungan tersebut, MyDuma memiliki standarisasi pelayanan perjalanan baik itu dari akomodasi dan hal penunjang lainnya. Seperti pesawat yang maksimal transit harus 1x, dan akomodasi hotel yang digunakan harus berjarak maksimal 100 meter dari masjid dan/atau akomodasi hotel yang tergabung pada jaringan hotel internasional seperti Hilton, Sheraton, dll</html>'],
            
            ['nomor' => 9, 'judul' => 'Gimana tuh fitur personal guard?','konten' => '<html>Personal guard akan membantu #DumaFriends jika ada sesuatu hal yang kurang baik dari Mitra Travel. Maka tim MyDuma yang berada di Arab Saudi akan membantu untuk menyelesaikannya.</html>'],
            
            ['nomor' => 10, 'judul' => 'Apa yang menjadi target MyDuma?','konten' => '<html>Target MyDuma adalah menjadikan ibadah umrah itu murah, nyaman dan mudah bagi #DumaFriends. Dan tentunya aman, karena MyDuma sebagai pihak ketiga yang akan selalu mengawasi pelayanan yang akan didapatkan oleh #DumaFriends dan MitraTravel yang akan memberikan pelayanan.</html>'],

            ['nomor' => 11, 'judul' => 'Apasih voucher tabungan itu?','konten' => '<html>Voucher tabungan adalah voucher yang memiliki nomer kode unik yang memiliki nilai uang yang sesuai tertera pada voucher tersebut.</html>'],

            ['nomor' => 12, 'judul' => 'Apa itu MyDuma Point?','konten' => '<html>MyDuma Point adalah nominal uang yang berupa point dan tentunya juga akan menjadi saldo tabungan umrah dan haji. Duma Point didapatkan ketika melalukan setoran tabungan awal.</html>'],

            ['nomor' => 13, 'judul' => 'Apakah ada dokumen bukti pembayaran ketika sudah memenuhi target tabungannya?','konten' => '<html>Semua pengeluaran yang akan dilakukan tentunya akan ada dokumen bukti pembayaran, yang dijelaskan pada komponen tabungan (baca: FAQ no 3 dan no 4) menjadi acuan.</html>'],
        ];

        foreach ($datas as $data) {
	        DB::table('faqs')->insert(array_merge($data, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
