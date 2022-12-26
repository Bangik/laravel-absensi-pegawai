<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name' => 'site_name',
            'value' => 'Sistem Informasi Prista Jaya',
            'type' => 'text',
            'description' => 'Site Name',
            'status' => 'active',
        ]);

        Setting::create([
            'name' => 'latitude',
            'value' => '3.075037',
            'type' => 'text',
            'description' => 'Latitude of the location',
            'status' => 'active',
        ]);

        Setting::create([
            'name' => 'longitude',
            'value' => '101.551629',
            'type' => 'text',
            'description' => 'Longitude of the location',
            'status' => 'active',
        ]);
        
        Setting::create([
            'name' => 'time_in',
            'value' => '09:00',
            'type' => 'time',
            'description' => 'Jam Masuk',
            'status' => 'active',
        ]);

        Setting::create([
            'name' => 'time_out',
            'value' => '17:00',
            'type' => 'time',
            'description' => 'Jam Keluar',
            'status' => 'active',
        ]);

        Setting::create([
            'name' => 'radius',
            'value' => '500',
            'type' => 'number',
            'description' => 'Radius',
            'status' => 'active',
        ]);
    }
}
