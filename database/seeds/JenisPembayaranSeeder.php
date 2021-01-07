<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JenisPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('jenis_pembayarans')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'display_name' => 'Biaya Administrasi', 'name' => 'biaya_administrasi','note' => '-'],
            ['id' => 2, 'display_name' => 'Tabungan', 'name' => 'tabungan','note' => '-'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('jenis_pembayarans')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
