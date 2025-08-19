<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'view_dashboard',
            'manage_appointments',
            'manage_sessions',
            'manage_payments',
            'view_reports',
            'create_patients',
            'book_appointments',
            'view_schedule',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        Role::firstOrCreate(['name' => 'Super Admin'])->givePermissionTo(Permission::all());

        Role::firstOrCreate(['name' => 'Branch Admin'])->givePermissionTo([
            'view_dashboard',
            'manage_appointments',
            'manage_sessions',
            'manage_payments',
            'view_reports',
        ]);

        Role::firstOrCreate(['name' => 'Doctor'])->givePermissionTo([
            'manage_appointments',
            'manage_sessions',
        ]);

        Role::firstOrCreate(['name' => 'Cashier'])->givePermissionTo([
            'manage_payments',
        ]);

        Role::firstOrCreate(['name' => 'View-Only Admin'])->givePermissionTo([
            'view_dashboard',
            'view_reports',
        ]);

        Role::firstOrCreate(['name' => 'Receptionist'])->givePermissionTo([
            'create_patients',
            'book_appointments',
            'view_schedule',
        ]);
    }
    }

