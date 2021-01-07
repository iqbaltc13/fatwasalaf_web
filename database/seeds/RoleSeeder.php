<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();
        $statusPegawai = [
            ['id' => 1, 'name' => 'super-admin','display_name' => 'Super Admin','description'=>'Super Admin'],
            ['id' => 2, 'name' => 'admin-all','display_name' => 'Admin All','description'=>'Admin All'],
            ['id' => 3, 'name' => 'customer','display_name' => 'Customer','description'=>'Customer'],
            ['id' => 4, 'name' => 'kbih','display_name' => 'Kbih','description'=>'Kbih'],
            ['id' => 5, 'name' => 'admin-cs','display_name' => 'Admin CS','description'=>'Admin CS'],
            ['id' => 6, 'name' => 'admin-pembayaran','display_name' => 'Admin Pembayaran','description'=>'Admin Pembayaran'],
            ['id' => 7, 'name' => 'admin-konten','display_name' => 'Admin Konten','description'=>'Admin Konten'],
        ];
        foreach ($statusPegawai as $status) {
	        DB::table('roles')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
            ]));
        }
    }
}
