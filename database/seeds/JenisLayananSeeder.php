<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JenisLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('jenis_layanans')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPembayaran = [
            ['id' => 1, 'display_name' => 'Tabungan Haji', 'name' => 'tabungan_haji','note' => '-'],
            ['id' => 2, 'display_name' => 'Tabungan Umrah', 'name' => 'tabungan_umrah','note' => '-'],
            ['id' => 3, 'display_name' => 'Haji Muda', 'name' => 'haji_muda','note' => '-'],
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('jenis_layanans')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
