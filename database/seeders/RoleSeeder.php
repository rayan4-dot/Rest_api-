<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des rôles avec guard_name
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        // Créer des permissions avec guard_name
        $manageTags = Permission::firstOrCreate(['name' => 'manage-tags', 'guard_name' => 'web']);
        $manageCategories = Permission::firstOrCreate(['name' => 'manage-categories', 'guard_name' => 'web']);
        $manageSubcategories = Permission::firstOrCreate(['name' => 'manage-subcategories', 'guard_name' => 'web']);

        // Assigner des permissions aux rôles
        $adminRole->givePermissionTo([$manageCategories, $manageSubcategories]);
        $adminRole->givePermissionTo($manageTags); // Seul l'admin peut gérer les tags
    }
}