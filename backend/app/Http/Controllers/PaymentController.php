<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;


class PaymentController extends Controller
{
    //
    function addPayment(Request $request)
    {
        $request->validate([
            'booking_id'     => 'required|integer',
            'payment_method' => 'required|string',
            'amount_paid'    => 'required|numeric',
        ]);

        $payment = new Payment();
        $payment->booking_id = $request->booking_id;
        $payment->payment_method = $request->payment_method;
        $payment->amount_paid = $request->amount_paid;
        $payment->save();

        if($payment){
            return redirect()->back()->with('success', 'Payment saved successfully!');
        } else {
            return redirect()->back()->with('error', 'Operation failed');
        }
    }

    
}
