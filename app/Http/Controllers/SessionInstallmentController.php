<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentSession;
use App\Models\SessionInstallment;

class SessionInstallmentController extends Controller
{
    /**
     * Show the form to create a new installment
     */
    public function create($sessionId)
    {
        // Treatment session load karo installments ke sath
        $session = TreatmentSession::with('installments')->findOrFail($sessionId);

        // Blade view ko session data bhejo
        return view('installments.create', compact('session'));
    }

    /**
     * Store the new installment and update session payment info
     */
    public function store(Request $request)
    {
        // Treatment session nikal lo with installments
        $session = TreatmentSession::with('installments')->findOrFail($request->session_id);

        $totalFee  = $session->session_fee; // total session fee
        $totalPaid = $session->installments->sum('amount'); // already paid
        $remaining = max(0, $totalFee - $totalPaid); // remaining balance

        // Validation
        $request->validate([
            'session_id'     => 'required|exists:treatment_sessions,id',
            'amount'         => "required|numeric|min:1|max:$remaining",
            'payment_date'   => 'required|date',
            'payment_method' => 'nullable|string|max:50',
        ], [
            'amount.max' => "❌ Payment cannot exceed the remaining balance of Rs. $remaining",
        ]);

        $newPayment = $request->amount;

        // Installment save kar do
        SessionInstallment::create([
            'session_id'     => $request->session_id,
            'amount'         => $newPayment,
            'payment_date'   => $request->payment_date,
            'payment_method' => $request->payment_method,
        ]);

        // Installments reload karo
        $session->load('installments');

        // Recalculate total paid & dues
        $updatedTotalPaid = $session->installments->sum('amount');
        $updatedDues      = max(0, $totalFee - $updatedTotalPaid);

        // Update parent treatment session
        $session->update([
            'paid_amount' => $updatedTotalPaid,
            'dues_amount' => $updatedDues,
        ]);

        // Success message ke sath redirect karo
        return redirect()->route('treatment-sessions.index')
            ->with('success', '✅ Installment added successfully!');
    }
}
