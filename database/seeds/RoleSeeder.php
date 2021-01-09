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
     
        ];
        foreach ($statusPegawai as $status) {
	        DB::table('roles')->insert(array_merge($status, [
                'created_at' => Carbon::now(),
            ]));
        }
    }
}
