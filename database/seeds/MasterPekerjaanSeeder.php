<?php

use Illuminate\Database\Seeder;

class MasterPekerjaanSeeder extends Seeder
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
        $this->command->info('truncating master_pekerjaan...');
        DB::table('master_pekerjaan')->truncate();
        Schema::enableForeignKeyConstraints();

        $datas = [
            'Pegawai Negeri Sipil',
            'TNI/Polri',
            'Dagang',
            'Tani/Nelayan',
            'Swasta',
            'Ibu Rumah Tangga',
            'Pelajar/Mahasiswa',
            'BUMN/BUMD',
            'Pensiunan',
        ];

        foreach($datas as $data){
            $this->command->info('creating pekerjaan: '.$data);
            \App\Models\MasterPekerjaan::create([
                'nama'          => $data,
                'is_active'     => 1,
            ]);
        }
    }
}
