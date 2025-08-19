<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Checkup;
use App\Models\SessionTime;
use App\Models\TreatmentSession;
use App\Models\SessionInstallment;
use Illuminate\Http\Request;

class TreatmentSessionController extends Controller
{
    public function index()
    {
        $sessions = TreatmentSession::with(['doctor', 'patient', 'sessionTimes', 'installments', 'checkup'])
            ->orderByDesc('created_at')
            ->get();

        $doctors = Doctor::all();

        return view('treatment_sessions.index', compact('sessions', 'doctors'));
    }

    public function create()
    {
        $checkups = Checkup::with('patient', 'doctor')->orderBy('date', 'desc')->get();
        $doctors  = Doctor::all();
        $patients = $checkups->pluck('patient')->unique('id'); // ✅ patients variable

        return view('treatment_sessions.create', compact('checkups', 'doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'checkup_id'      => 'required|exists:checkups,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'session_fee'     => 'required|numeric|min:0',
            'paid_amount'     => 'required|numeric|min:0',
            'sessions'        => 'nullable|array',
            'sessions.*.date' => 'nullable|date',
            'sessions.*.time' => 'nullable|date_format:H:i',
        ]);

        $checkup = Checkup::findOrFail($request->checkup_id);

        $sessionCount = $request->has('sessions') ? count($request->sessions) : 0;
        $totalFee     = $request->session_fee * $sessionCount;
        $paidAmount   = $request->paid_amount;
        $duesAmount   = $totalFee - $paidAmount;

        $session = TreatmentSession::create([
            'patient_id'    => $checkup->patient_id,
            'checkup_id'    => $request->checkup_id,
            'doctor_id'     => $request->doctor_id,
            'session_fee'   => $request->session_fee,
            'session_count' => $sessionCount,
            'paid_amount'   => $paidAmount,
            'dues_amount'   => $duesAmount,
        ]);

        if ($request->has('sessions')) {
            foreach ($request->sessions as $time) {
                if (!empty($time['date']) && !empty($time['time'])) {
                    $sessionDatetime = $time['date'] . ' ' . $time['time'];
                    SessionTime::create([
                        'treatment_session_id' => $session->id,
                        'session_datetime'     => $sessionDatetime,
                    ]);
                }
            }
        }

        if ($paidAmount > 0) {
            SessionInstallment::create([
                'session_id'     => $session->id,
                'amount'         => $paidAmount,
                'payment_date'   => now(),
                'payment_method' => 'cash',
            ]);
        }

        return redirect()->route('treatment-sessions.index')
            ->with('success', 'Treatment session created successfully.');
    }

    public function edit($id)
    {
        $session  = TreatmentSession::with(['checkup', 'doctor', 'sessionTimes'])->findOrFail($id);
        $checkups = Checkup::with('patient', 'doctor')->orderBy('date', 'desc')->get();
        $doctors  = Doctor::all();
        $patients = $checkups->pluck('patient')->unique('id'); // ✅ patients variable

        return view('treatment_sessions.edit', compact('session', 'checkups', 'doctors', 'patients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'checkup_id'      => 'required|exists:checkups,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'session_fee'     => 'required|numeric|min:0',
            'paid_amount'     => 'required|numeric|min:0',
            'sessions'        => 'nullable|array',
            'sessions.*.date' => 'nullable|date',
            'sessions.*.time' => 'nullable|date_format:H:i',
        ]);

        $session = TreatmentSession::findOrFail($id);
        $checkup = Checkup::findOrFail($request->checkup_id);

        $sessionCount = $request->has('sessions') ? count($request->sessions) : 0;
        $totalFee     = $request->session_fee * $sessionCount;
        $paidAmount   = $request->paid_amount;
        $duesAmount   = $totalFee - $paidAmount;

        $session->update([
            'patient_id'    => $checkup->patient_id,
            'checkup_id'    => $request->checkup_id,
            'doctor_id'     => $request->doctor_id,
            'session_fee'   => $request->session_fee,
            'session_count' => $sessionCount,
            'paid_amount'   => $paidAmount,
            'dues_amount'   => $duesAmount,
        ]);

        if ($request->has('sessions')) {
            $session->sessionTimes()->delete();

            foreach ($request->sessions as $time) {
                if (!empty($time['date']) && !empty($time['time'])) {
                    $sessionDatetime = $time['date'] . ' ' . $time['time'];
                    SessionTime::create([
                        'treatment_session_id' => $session->id,
                        'session_datetime'     => $sessionDatetime,
                    ]);
                }
            }
        }

        return redirect()->route('treatment-sessions.index')
            ->with('success', 'Treatment session updated successfully.');
    }

    public function markCompleted(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'work_done' => 'nullable|string|max:255',
        ]);

        $sessionTime = SessionTime::findOrFail($id);

        $sessionTime->update([
            'is_completed'            => true,
            'completed_by_doctor_id'  => $request->doctor_id,
            'work_done'               => $request->work_done ?? null,
        ]);

        $sessionTime->treatmentSession->refreshStatus();

        return redirect()->back()->with('success', 'Session marked completed successfully.');
    }

    public function destroy($id)
    {
        $session = TreatmentSession::findOrFail($id);
        $session->sessionTimes()->delete();
        $session->installments()->delete();
        $session->delete();

        return redirect()->route('treatment-sessions.index')
            ->with('success', 'Treatment session deleted successfully.');
    }
}

