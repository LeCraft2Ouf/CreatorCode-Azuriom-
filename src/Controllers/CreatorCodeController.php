<?php

namespace Azuriom\Plugin\CreatorCodes\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\Http\Request;

class CreatorCodeController extends Controller
{
    public function apply(Request $request, CreatorCodeManager $manager)
    {
        $validated = $this->validate($request, [
            'creator_code' => 'required|string|max:32',
        ]);

        $manager->apply($validated['creator_code'], $request->user());

        return back()->with('success', trans('creatorcodes::messages.applied'));
    }

    public function remove(Request $request, CreatorCodeManager $manager)
    {
        $manager->remove($request->user());

        return back()->with('success', trans('creatorcodes::messages.removed'));
    }
}
