<?php

namespace App\Services;

Interface PaymentServices{
    public function pay($price, $stripeToken);        
}