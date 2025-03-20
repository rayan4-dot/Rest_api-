<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $adminRoleWeb = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRoleApi = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        

        $manageTagsWeb = Permission::firstOrCreate(['name' => 'manage-tags', 'guard_name' => 'web']);
        $manageTagsApi = Permission::firstOrCreate(['name' => 'manage-tags', 'guard_name' => 'api']);
        

        $adminRoleWeb->givePermissionTo($manageTagsWeb);


        $adminRoleApi->givePermissionTo($manageTagsApi);


        $manageCategoriesWeb = Permission::firstOrCreate(['name' => 'manage-categories', 'guard_name' => 'web']);
        $adminRoleWeb->givePermissionTo($manageCategoriesWeb);
    }
}
