<?php

namespace Azuriom\Plugin\CreatorCodes\View\Composers;

use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class LayoutComposer
{
    /**
     * Inject the creator code box on shop purchase pages, without editing themes.
     */
    public function compose(View $view): void
    {
        if (app()->bound('creatorcodes.layout_injected')) {
            return;
        }

        if (! Route::is(['shop.offers.*', 'paysafecardmanual.*'])) {
            return;
        }

        app()->instance('creatorcodes.layout_injected', true);

        $creatorCode = app(CreatorCodeManager::class)->current(auth()->user());

        view('creatorcodes::shop.inject', [
            'appliedCode' => $creatorCode?->code,
        ])->render();
    }
}
