<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaketTabunganUmrahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('paket_tabungan_umrahs')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'nama' => 'Dana Umrah Rp.30.000.000', 'deskripsi' => '(Estimasi biaya umrah, duit saku, dokumen perjalanan, asuransi dan administrasi)','biaya_administrasi' => '500000','nominal_tabungan' => '30000000','is_default' => '1','created_by_name' => 'seeder'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('paket_tabungan_umrahs')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
