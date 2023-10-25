<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stripe;
use Throwable;
use App\Helpers\ApiResponse;

class StripeController extends Controller
{
    public function paymentStripe(Request $request)
    {
        try {

             

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
             $res =    $stripe->tokens->create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->expired_month,
                    'exp_year' => $request->expired_year,
                    'cvc' => $request->cvc,
                ],

            ]);

            new \Stripe\StripeClient(env('STRIPE_SECRET'));
               $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'USD',
                'source' => $res->id,
                'description' => $request->description,
            ]);

            return ApiResponse::sendResponse(200, 'Your payment has been successfully processed ', );
        } catch (Throwable $e) {
            return ApiResponse::sendResponse(404, 'payment failed', $e->getMessage());
        }
    }
}
