<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $staff = Role::create(['name' => 'staff']);

        $permissions = [
            'users.manage',
            'products.create', 'products.update', 'products.delete',
            'category.create', 'category.update', 'category.delete',
        ];
        foreach ($permissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        $admin->permissions()->sync(Permission::all());

        $manager->permissions()->sync(
            Permission::whereIn('name', [
                'products.create', 'products.update', 'products.delete',
                'category.create', 'category.update', 'category.delete',
            ])->pluck('id')
        );

        $staff->permissions()->sync(
            Permission::whereIn('name', [
                'products.create', 'products.update',
                'category.create', 'category.update',
            ])->pluck('id')
        );
    }
}
