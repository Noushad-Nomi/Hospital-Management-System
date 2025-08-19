<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Branch;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('branch');

        if ($request->filled('search_id')) {
            $query->where('id', $request->search_id);
        }

        $patients = $query->get();

        return view('patients.indexx', compact('patients'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('patients.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'guardian_name' => 'required|string|max:255',
            'age' => 'required|numeric',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'branch_id' => 'required|exists:branches,id',
        ]);

        Patient::create($request->only(
            'name',
            'gender',   // ✅ Added gender here
            'guardian_name',
            'age',
            'phone',
            'address',
            'branch_id'
        ));

        return redirect('/patients')->with('success', 'Patient added successfully!');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $branches = Branch::all();
        return view('patients.edit', compact('patient', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'guardian_name' => 'required|string|max:255',
            'age' => 'required|numeric',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($request->only(
            'name',
            'gender',   // ✅ Added gender here
            'guardian_name',
            'age',
            'phone',
            'address',
            'branch_id'
        ));

        return redirect('/patients')->with('success', 'Patient updated successfully!');
    }

    public function show($id)
    {
        $patient = Patient::with('branch', 'checkups')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect('/patients')->with('success', 'Patient deleted successfully!');
    }
}
