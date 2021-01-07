<?php

use Illuminate\Database\Seeder;

class MasterPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('disabling foreignkeys check');
        Schema::disableForeignKeyConstraints();
        $this->command->info('truncating master_pendidikan...');
        DB::table('master_pendidikan')->truncate();
        Schema::enableForeignKeyConstraints();

        $datas = [
            'SD',
            'SLTP',
            'SLTA',
            'D1/D2/D3/SM',
            'S1',
            'S2',
            'S3'
        ];

        foreach($datas as $data){
            $this->command->info('creating pendidikan: '.$data);
            \App\Models\MasterPendidikan::create([
                'nama'          => $data,
                'is_active'     => 1,
            ]);
        }
    }
}
