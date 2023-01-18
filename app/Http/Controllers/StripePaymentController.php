<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use \Stripe;

class StripePaymentController extends Controller
{
    public function create(Request $request) {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $amount = $request->amount * 100;
        
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'rub',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
        
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            
            return response()->json([$output], 201);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
}
