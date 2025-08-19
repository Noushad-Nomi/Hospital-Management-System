<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
      public function index()
    {
        $invoices = Invoice::with('patient', 'doctor')->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('invoices.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required|date',
            'fee' => 'required|numeric',
        ]);

        $invoice = Invoice::create($request->all());

        return redirect()->route('invoices.show', $invoice->id);
    }

    public function show($id)
    {
        $invoice = Invoice::with('patient', 'doctor')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

}
