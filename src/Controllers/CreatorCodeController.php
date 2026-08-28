<?php

namespace Azuriom\Plugin\CreatorCodes\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\Http\Request;

class CreatorCodeController extends Controller
{
    public function apply(Request $request, CreatorCodeManager $manager)
    {
        $invalid = trans('creatorcodes::messages.errors.invalid');

        $validated = $this->validate($request, [
            'creator_code' => ['required', 'string', 'max:32', 'regex:/^[A-Za-z0-9_-]+$/'],
        ], [
            'creator_code.required' => $invalid,
            'creator_code.regex' => $invalid,
            'creator_code.max' => $invalid,
        ]);

        $manager->apply($validated['creator_code'], $request->user());

        return back();
    }

    public function remove(Request $request, CreatorCodeManager $manager)
    {
        $manager->remove($request->user());

        return back();
    }
}
