<?php

namespace Azuriom\Plugin\CreatorCodes\View\Composers;

use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\View\View;

class ShopViewComposer
{
    public function compose(View $view): void
    {
        $view->with('appliedCode', app(CreatorCodeManager::class)->current(auth()->user())?->code);
    }
}
