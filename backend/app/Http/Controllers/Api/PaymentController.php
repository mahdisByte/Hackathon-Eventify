<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function addPayment(Request $request)
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
            return response()->json([
                'success' => true,
                'message' => 'Payment saved successfully!',
                'payment' => $payment
            ], 201); 
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Operation failed. Please try again.'
            ], 500);
        }
    }

    
}
