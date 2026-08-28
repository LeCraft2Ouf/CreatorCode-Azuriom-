<?php

namespace Azuriom\Plugin\CreatorCodes\Observers;

use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Azuriom\Plugin\Shop\Models\Payment;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        app(CreatorCodeManager::class)->attachToPayment($payment);
    }
}
