<?php

namespace Azuriom\Plugin\CreatorCodes\View\Composers;

use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class LayoutComposer
{
    /**
     * Inject the creator code box on shop purchase pages, without editing themes.
     */
    public function compose(View $view): void
    {
        if (! Route::is(['shop.offers.*', 'shop.cart.*', 'paysafecardmanual.*'])) {
            return;
        }

        $creatorCode = app(CreatorCodeManager::class)->current(auth()->user());

        ViewFacade::startPush('footer-scripts', view('creatorcodes::shop.inject', [
            'creatorCode' => $creatorCode,
        ])->render());
    }
}
