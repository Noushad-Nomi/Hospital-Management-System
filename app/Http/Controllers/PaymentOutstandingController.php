<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\TreatmentSession;


class PaymentOutstandingController extends Controller
{
      public function index()
    {
        // Sirf woh sessions jinka payment remaining ho
       $outstandings = TreatmentSession::with(['patient', 'installments'])

            ->get()
            ->filter(function ($session) {
                return $session->remainingAmount() > 0;
            });

        return view('payments.outstandings', compact('outstandings'));
    }
}
