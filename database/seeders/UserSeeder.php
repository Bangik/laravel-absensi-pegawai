<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user1 = User::create([
            'name' => 'Admin',
            'nrp' => '1234567890',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ]);
        $user2 = User::create([
            'name' => 'Pegawai',
            'nrp' => '0987654321',
            'email' => 'pegawai@localhost',
            'password' => bcrypt('password'),
        ]);

        $role1 = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $permission = Permission::pluck('id', 'id')->all();

        $role1->syncPermissions($permission);
        $user1->assignRole([$role1->id]);

        $role2 = Role::create(['name' => 'pegawai', 'guard_name' => 'web']);
        $permission = Permission::whereNotIn('name', ['user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create', 'role-edit', 'role-delete'])->pluck('id', 'id')->all();

        $role2->syncPermissions($permission);
        $user2->assignRole([$role2->id]);
    }
}
