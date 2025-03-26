<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $mentorRole = Role::firstOrCreate(['name' => 'mentor']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);


        $permissions = [
            'view courses',
            'manage tags', 
            'view stats',
            'manage categories', 
            'manage sub-categories', 
            'enroll in courses',
            'create courses',
            'update courses',
            'delete courses',
            'add videos',
            'approve enrollments',
            'track progress',
            'view videos'
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate(['name' => $permission]);
        }


        $adminRole->givePermissionTo([
            'view courses',
            'view stats',
            'view videos',
            'manage tags',
            'manage categories',
            'manage sub-categories',
        ]);


        $mentorRole->givePermissionTo([
            'create courses',
            'update courses',
            'delete courses',
            'view courses',
            'add videos',
            'approve enrollments',
        ]);


        $studentRole->givePermissionTo([
            'enroll in courses',
            'track progress',
            'view videos'
        ]);
    }
}
