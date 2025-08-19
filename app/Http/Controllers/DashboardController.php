<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Checkup;
use App\Models\TreatmentSession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        $totalCheckups = Checkup::count();

        // ✅ Aaj ke sessions ka count (created_at)
        $totalSessionsToday = TreatmentSession::whereDate('created_at', Carbon::today())->count();

        // ✅ Aaj ke checkups ki payment
        $checkupPaymentsToday = Checkup::whereDate('created_at', Carbon::today())->sum('fee');

        // ✅ Aaj ke sirf paid sessions ki payment
        $sessionPaymentsToday = TreatmentSession::whereDate('created_at', Carbon::today())
            ->where('payment_status', 'paid')
            ->sum('session_fee');

        // ✅ Aaj ki total paid payment
        $totalPaymentsToday = $checkupPaymentsToday + $sessionPaymentsToday;

        return view('dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalCheckups',
            'totalSessionsToday',
            'totalPaymentsToday'
        ));
    }
}
