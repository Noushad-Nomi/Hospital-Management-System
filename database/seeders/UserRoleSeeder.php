<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use App\Models\User;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user = User::where('email', 'admin@example.com')->first();
        if ($user) {
            $user->assignRole('Super Admin');
        }
    }
    }

