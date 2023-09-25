<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\PaymentIntent;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $checkSlot = Booking::where('slot_id',$request->slot_id)->where('date',$request->date)->first();

        if($checkSlot)
        {
            return response()->json(['message'=>'this slot is already booked!']);
        }
        // Get the token, amount, and name from the request's input data
        $token = $request->input('token');
        $amount = $request->input('amount');
        $name = $request->input('name');

        // Set the Stripe API secret key from the configuration
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // // Create a customer with Stripe
            // $customer = Customer::create([
            //     'email' => $token['email'],
            //     'source' => $token['id'],
            //     'name' => $name,
            // ]);

            // // Charge the customer's card
            // $charge = Charge::create([
            //     'customer' => $customer->id,
            //     'amount' => $amount * 100, // Stripe uses smallest currency unit (cents)
            //     'currency' => 'usd',
            //     'description' => 'Dragonautomart-website-payment',
            //     'receipt_email' => $token['email'],
            // ]);

            // // Return a JSON response indicating success (HTTP status 201)
            // return response()->json(['success' => true], 201);


            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'statement_descriptor_suffix' => 'Payment using Stripe',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
    
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);


        } catch (\Exception $e) {
            // Return a JSON response indicating failure (HTTP status 500)
            return response()->json(['success' => false, 'message' => 'Payment failed'], 500);
        }
    }
}
