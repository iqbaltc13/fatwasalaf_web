<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->command->info('disabling foreignkeys check');
        Schema::disableForeignKeyConstraints();
        $this->command->info('truncating tables...');
        DB::table('kelurahan')->truncate();
        DB::table('kecamatan')->truncate();
        DB::table('kota')->truncate();
        DB::table('provinsi')->truncate();
        Schema::enableForeignKeyConstraints();
        
        //Province
        $this->command->info('adding provinsi...');
        $provinsi = array_map('str_getcsv', file(database_path('excel/provinsi.csv')));
        foreach ($provinsi as $key => $value) {
	        DB::table('provinsi')->insert(['id' 	=> $value[0],
                                            'nama'	=> ucwords($value[1]),
                                            'created_at'    => Carbon::now(),
                                            'updated_at'    => Carbon::now()
                                        ]);
        }

        //Cities
        $this->command->info('adding kota...');
        $kota = array_map('str_getcsv', file(database_path('excel/kota.csv')));
        foreach ($kota as $key => $value) {
	        DB::table('kota')->insert(['id' 			=> $value[0],
                                        'provinsi_id' 	=> $value[1],
                                        'nama'			=> ucwords($value[2]),
                                        'created_at'    => Carbon::now(),
                                        'updated_at'    => Carbon::now()
                                    ]);
        }

        //Kecamatans
        $this->command->info('adding kecamatan...');
        $kecamatan = array_map('str_getcsv', file(database_path('excel/kecamatan.csv')));
        foreach ($kecamatan as $key => $value) {
	        DB::table('kecamatan')->insert([
	        								'id' 			=> $value[0],
                                        	'kota_id' 		=> $value[1],
                                        	'nama'			=> ucwords($value[2]),
                                            'created_at'    => Carbon::now(),
                                            'updated_at'    => Carbon::now()
                                    ]);
        }

        //Kelurahans
        $this->command->info('adding kelurahan...');
        $kelurahan = array_map('str_getcsv', file(database_path('excel/kelurahan.csv')));
        foreach ($kelurahan as $key => $value) {
	        DB::table('kelurahan')->insert([
	        							'id' 			=> $value[0],
                                        'kecamatan_id' => $value[1],
                                        'nama'			=> ucwords($value[2]),
                                        'created_at'    => Carbon::now(),
                                        'updated_at'    => Carbon::now()
                                    ]);
        }
    }
}
