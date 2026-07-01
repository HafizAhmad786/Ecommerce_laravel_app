<?php

namespace App\Services;

Interface PaymentServices{
    public function payViaApi($price); 
    public function payViaWeb($price,$stripeToken); 
    public function retrievePaymentIntent($id);     
}