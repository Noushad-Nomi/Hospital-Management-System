<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientSessionController extends Controller
{
    public function show($id)
    {
        // Patient basic info
        $patient = DB::table('patients')->where('id', $id)->first();

        // Sessions + checkup + doctor info
        $sessions = DB::table('treatment_sessions')
            ->join('checkups', 'treatment_sessions.checkup_id', '=', 'checkups.id')
            ->join('doctors', 'treatment_sessions.doctor_id', '=', 'doctors.id')
            ->where('checkups.patient_id', $id)
            ->select(
                'treatment_sessions.*',
                'doctors.name as doctor_name',
                'checkups.diagnosis',
                'checkups.date as checkup_date'
            )
            ->orderBy('treatment_sessions.session_date', 'asc')
            ->get();

        return view('patients.sessions', compact('patient', 'sessions'));
    }
}
