<?php

namespace App\Http\Controllers\Doctors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\DoctorPerformance;

class DoctorController extends Controller
{
      public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
         return view('doctors.create');
    }

    public function store(Request $request)
    {
         Doctor::create($request->all());
        return redirect()->route('doctors.index');
    }

    public function edit($id)
    {
       $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return redirect()->route('doctors.index');
    }

    public function availability($id)
    {
        $doctor = Doctor::with('availabilities')->findOrFail($id);
        return view('doctors.availability', compact('doctor'));
    }

    public function performance($id)
    {
        $doctor = Doctor::with('performances')->findOrFail($id);
        return view('doctors.performance', compact('doctor'));
    }

}
