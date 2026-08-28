<?php

namespace Azuriom\Plugin\CreatorCodes\Listeners;

use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Azuriom\Plugin\Shop\Events\PaymentPaid;

class RewardCreatorOnPaymentPaid
{
    public function __construct(
        private CreatorCodeManager $manager
    ) {
    }

    public function handle(PaymentPaid $event): void
    {
        $this->manager->rewardPayment($event->payment);
    }
}
