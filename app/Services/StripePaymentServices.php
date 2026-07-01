<?php

namespace App\Services;

class StripePaymentServices implements PaymentServices
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('stripe.stripe.secret'));
    }

    public function payViaApi($price)
    {
        return $this->stripe->paymentIntents->create([
            'amount' => $price * 100, // Amount in cents
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
        ]);
    }

    public function retrievePaymentIntent($id){
        return $this->stripe->charges->retrieve($id);
    }

    public function payViaWeb($price,$stripeToken){
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