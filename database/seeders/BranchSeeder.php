<?php

namespace Database\Seeders;
use App\Models\Branch;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Branch::create(['name' => 'Main Branch Rawalpindi']);
    Branch::create(['name' => 'islmabad Clinic']);
     Branch::create(['name' => 'Attock Clinic']);
    }
}
