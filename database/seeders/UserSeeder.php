<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->roles()->attach(Role::where('name', 'manager')->first());

        $staff1 = User::create([
            'name' => 'Staff User 1',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff2 = User::create([
            'name' => 'Staff User 2',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
        ]);
        $staffRole = Role::where('name', 'staff')->first();
        $staff1->roles()->attach($staffRole);
        $staff2->roles()->attach($staffRole);
    }
}
