<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function showForm()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        Charge::create([
            'amount' => 1000, // amount in cents, so this is $10
            'currency' => 'usd',
            'description' => 'Test Payment',
            'source' => $request->stripeToken,
        ]);

        return back()->with('success', 'Payment successful!');
    }
}
