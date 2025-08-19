<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Checkup;

class CheckupController extends Controller
{
    // 1️⃣ Show all checkups
    public function index() 
    {
        $checkups = DB::table('checkups')
            ->join('patients', 'checkups.patient_id', '=', 'patients.id')
            ->join('doctors', 'checkups.doctor_id', '=', 'doctors.id')
            ->select(
                'checkups.*',
                'patients.name as patient_name',
                'patients.gender',
                'patients.phone as patient_phone',
                'doctors.name as doctor_name'
            )
            ->orderBy('checkups.date', 'desc')
            ->get();

        return view('checkups.index', compact('checkups'));
    }

    // 2️⃣ Show form to create new checkup
    public function create()
    {
        $patients = DB::table('patients')->select('id', 'name', 'phone', 'branch_id')->get();
        $doctors = DB::table('doctors')->select('id', 'name')->get();

        $defaultFee = 0;

        if ($patients->count() > 0) {
            $firstPatient = $patients->first();
            if ($firstPatient->branch_id) {
                $setting = DB::table('general_settings')
                    ->where('branch_id', $firstPatient->branch_id)
                    ->first();
                $defaultFee = $setting ? $setting->default_checkup_fee : 0;
            }
        }

        return view('checkups.create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'defaultFee' => $defaultFee,
        ]);
    }

    // 3️⃣ Store new checkup
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'diagnosis' => 'required|string',
            'note' => 'nullable|string', // ✅ validate note
        ]);

        $patient = DB::table('patients')->where('id', $request->patient_id)->first();
        if (!$patient) {
            return back()->with('error', 'Patient not found.');
        }

        $setting = DB::table('general_settings')->where('branch_id', $patient->branch_id)->first();
        $checkupFee = $setting ? $setting->default_checkup_fee : 0;

        Checkup::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'branch_id' => $patient->branch_id,
            'date' => $request->date,
            'diagnosis' => $request->diagnosis,
            'fee' => $checkupFee,
            'note' => $request->note, // ✅ note added
        ]);

        return redirect()->route('checkups.index')->with('success', 'Checkup added successfully.');
    }

    // 4️⃣ Edit form
    public function edit($id)
    {
        $checkup = Checkup::findOrFail($id);

        $patients = DB::table('patients')->select('id', 'name')->get();
        $doctors = DB::table('doctors')->select('id', 'name')->get();

        return view('checkups.edit', compact('checkup', 'patients', 'doctors'));
    }

    // 5️⃣ Update checkup
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'diagnosis' => 'required|string',
            'fee' => 'required|numeric|min:0',
            'note' => 'nullable|string', // ✅ validate note
        ]);

        DB::table('checkups')->where('id', $id)->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'diagnosis' => $request->diagnosis,
            'fee' => $request->fee,
            'note' => $request->note, // ✅ note updated
            'updated_at' => now(),
        ]);

        return redirect()->route('checkups.index')->with('success', 'Checkup updated successfully.');
    }

    // 6️⃣ Delete checkup
    public function destroy($id)
    {
        DB::table('checkups')->where('id', $id)->delete();
        return redirect()->route('checkups.index')->with('success', 'Checkup deleted successfully.');
    }

    // 7️⃣ Show checkup detail
    public function show($id)
    {
        $checkup = DB::table('checkups')
            ->join('patients', 'checkups.patient_id', '=', 'patients.id')
            ->join('doctors', 'checkups.doctor_id', '=', 'doctors.id')
            ->select(
                'checkups.*',
                'patients.name as patient_name',
                'patients.phone as patient_phone',
                'patients.gender',
                'doctors.name as doctor_name'
            )
            ->where('checkups.id', $id)
            ->first();

        if (!$checkup) {
            abort(404);
        }

        return view('checkups.show', compact('checkup'));
    }

    // 8️⃣ Print slip
    public function printSlip($id)
    {
        $checkup = Checkup::with(['patient', 'doctor'])->findOrFail($id);
        return view('checkups.print', compact('checkup'));
    }

    // 9️⃣ Ajax: Get fee based on patient's branch
    public function getCheckupFee($patientId)
    {
        $patient = DB::table('patients')->where('id', $patientId)->first();
        if (!$patient) {
            return response()->json(['fee' => 0]);
        }

        $setting = DB::table('general_settings')->where('branch_id', $patient->branch_id)->first();
        $fee = $setting ? $setting->default_checkup_fee : 0;

        return response()->json(['fee' => $fee]);
    }
}
