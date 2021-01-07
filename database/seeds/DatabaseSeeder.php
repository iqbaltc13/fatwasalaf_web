<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BasicAuthenticationsSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(FileTypesSeeder::class);
        $this->call(ConfirmationTypeSeeder::class);
        $this->call(MasterPekerjaanSeeder::class);
        $this->call(MasterPendidikanSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(SyaratKetentuanSeeder::class);
        $this->call(CaraMenabungSeeder::class);
        $this->call(JenisLayananSeeder::class);
        $this->call(JenisPembayaranSeeder::class);
        $this->call(StatusTabunganHajiSeeder::class);
        $this->call(StatusTabunganUmrahSeeder::class);
        $this->call(StatusTabunganUmrahSeeder::class);
        $this->call(PaketTabunganHajiSeeder::class);
        $this->call(PaketTabunganUmrahSeeder::class);
        $this->call(NotifikasiGroupSeeder::class);
        $this->call(NotifikasiActionSeeder::class);
        $this->call(ProvinceSeeder::class);
    }
}
