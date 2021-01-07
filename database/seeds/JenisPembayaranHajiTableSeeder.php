<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JenisPembayaranHajiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('jenis_pembayaran_hajis')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'display_name' => 'Biaya Administrasi', 'name' => 'biaya_administrasi','note' => '-'],
            ['id' => 2, 'display_name' => 'Pelunasan Setoran', 'name' => 'pelunasan_setoran','note' => '-'],
            ['id' => 3, 'display_name' => 'Pelunasan Total', 'name' => 'pelunasan_total','note' => '-'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('jenis_pembayaran_hajis')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
