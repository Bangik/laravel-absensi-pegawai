<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'present-list',
            'present-create',
            'present-edit',
            'present-delete',
        ];

        foreach ($permissions as $permission) {
            $permissionn = new \Spatie\Permission\Models\Permission();
            $permissionn->name = $permission;
            $permissionn->save();
        }
    }
}
