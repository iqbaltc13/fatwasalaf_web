<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaketTabunganHajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('paket_tabungan_hajis')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'nama' => 'Tabungan Porsi Haji Reguler', 'deskripsi' => 'Rp. 25.000.000 + Rp. 1.000.000 (biaya administrasi)','biaya_administrasi' => '500000','nominal_tabungan' => '26000000','is_default' => '1','created_by_name' => 'seeder'],
            ['id' => 2, 'nama' => 'Tabungan Porsi Haji Plus', 'deskripsi' => 'Rp. 65.000.000 + Rp. 1.000.000 (biaya administrasi)','biaya_administrasi' => '500000','nominal_tabungan' => '66000000','is_default' => '0','created_by_name' => 'seeder'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('paket_tabungan_hajis')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
