<?php

namespace Azuriom\Plugin\CreatorCodes\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\CreatorCodes\CreatorCodeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CreatorCodeController extends Controller
{
    public function apply(Request $request, CreatorCodeManager $manager)
    {
        $this->ensureIsNotRateLimited($request);
        RateLimiter::hit($this->rateLimitKey($request), 60);

        $invalid = trans('creatorcodes::messages.errors.invalid');

        $validated = $this->validate($request, [
            'creator_code' => ['required', 'string', 'max:32', 'regex:/^[A-Za-z0-9_-]+$/'],
        ], [
            'creator_code.required' => $invalid,
            'creator_code.regex' => $invalid,
            'creator_code.max' => $invalid,
        ]);

        $manager->apply($validated['creator_code'], $request->user());

        return back()->with('success', trans('creatorcodes::messages.applied', [
            'money' => money_name(),
        ]));
    }

    public function remove(Request $request, CreatorCodeManager $manager)
    {
        $manager->remove($request->user());

        return back()->with('success', trans('creatorcodes::messages.removed'));
    }

    private function ensureIsNotRateLimited(Request $request): void
    {
        $key = $this->rateLimitKey($request);

        if (! RateLimiter::tooManyAttempts($key, 20)) {
            return;
        }

        throw ValidationException::withMessages([
            'creator_code' => trans('creatorcodes::messages.errors.too_many'),
        ]);
    }

    private function rateLimitKey(Request $request): string
    {
        return 'creatorcodes.apply:'.$request->user()->id;
    }
}
