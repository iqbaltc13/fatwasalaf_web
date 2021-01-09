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
           
        ];

        foreach ($statusPembayaran as $status) {
	        DB::table('notifikasi_groups')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
