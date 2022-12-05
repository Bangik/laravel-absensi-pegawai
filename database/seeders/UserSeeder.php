<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'Admin',
            'nrp' => '1234567890',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'role_id' => 2,
            'name' => 'Pegawai',
            'nrp' => '0987654321',
            'email' => 'pegawai@localhost',
            'password' => bcrypt('password'),
        ]);
    }
}
