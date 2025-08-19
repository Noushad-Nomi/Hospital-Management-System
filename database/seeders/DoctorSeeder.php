<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorAvailability;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Doctor 1
    $doctor1 = Doctor::create([
    'name' => 'Dr. Noushad Nomi',
    'email' => 'nomi@example.com',
    'phone' => '03123456789',
    'specialization' => 'Physiotherapist',
]);


        DoctorAvailability::create([
            'doctor_id' => $doctor1->id,
            'date' => '2025-06-17',
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);

        DoctorAvailability::create([
            'doctor_id' => $doctor1->id,
            'date' => '2025-06-18',
            'start_time' => '14:00:00',
            'end_time' => '17:00:00',
        ]);

        // ✅ Doctor 2
        $doctor2 = Doctor::create([
            'name' => 'Dr. Sarah Ahmed',
            'email' => 'sarah@example.com',
            'phone' => '03123456780',
            'specialization' => 'Orthopedic',
        ]);

        DoctorAvailability::create([
            'doctor_id' => $doctor2->id,
            'date' => '2025-06-19',
            'start_time' => '10:00:00',
            'end_time' => '13:00:00',
        ]);
     
    }
}
