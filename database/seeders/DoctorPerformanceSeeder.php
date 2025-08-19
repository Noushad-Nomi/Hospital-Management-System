<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorPerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('doctor_performances')->insert([
            [
                'doctor_id' => 1,
                'patients_seen' => 25,
                'rating' => 4.5,
                'remarks' => 'Excellent performance in outpatient department.',
                'report_date' => Carbon::now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => 2,
                'patients_seen' => 18,
                'rating' => 3.9,
                'remarks' => 'Good effort, needs slight improvement in follow-ups.',
                'report_date' => Carbon::now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id' => 1,
                'patients_seen' => 30,
                'rating' => 4.8,
                'remarks' => 'Handled emergency ward excellently.',
                'report_date' => Carbon::now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
