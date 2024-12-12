<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_role = Role::create(['name' => 'super-admin']);
        $edit_permission = Permission::create(['name' => 'edit contacts']);
        $delete_permission = Permission::create(['name' => 'delete contacts']);

        $super_admin_role->givePermissionTo($edit_permission);
        $super_admin_role->givePermissionTo($delete_permission);
    }
}
