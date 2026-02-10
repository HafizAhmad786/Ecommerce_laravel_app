<?php

namespace App\Services;

class StripePaymentServices implements PaymentServices
{
    public function pay($price, $stripeToken)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe.secret'));
        $result = $stripe->charges->create([
            'amount' => $price * 100,
            'currency' => 'usd',
            'source' => $stripeToken,
            'description' => 'Payment from customer',
        ]);
        return $result;
    }
}
