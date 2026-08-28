<?php

namespace Azuriom\Plugin\CreatorCodes\Observers;

use Azuriom\Models\User;
use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;

class UserObserver
{
    public function updated(User $user): void
    {
        if (! $user->wasChanged('money')) {
            return;
        }

        $delta = (float) $user->money - (float) $user->getOriginal('money');

        app(CreatorCodeManager::class)->rememberMoneyDelta($user, $delta);
    }
}
