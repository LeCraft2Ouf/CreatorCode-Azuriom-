<?php

namespace Azuriom\Plugin\CreatorCodes\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\CreatorCodes\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('creatorcodes::admin.index', [
            'creators' => Creator::with('user')->withSum('rewards', 'neos_rewarded')->orderBy('code')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'pseudo' => 'required|string|max:32',
            'code' => ['required', 'string', 'max:32', 'alpha_dash', Rule::unique('creatorcodes_creators', 'code')],
            'percentage' => 'required|numeric|min:0.01|max:100',
        ]);

        $user = User::whereRaw('LOWER(name) = ?', [strtolower($validated['pseudo'])])->first();

        if ($user === null) {
            return back()->withInput()->withErrors([
                'pseudo' => trans('creatorcodes::admin.errors.user'),
            ]);
        }

        if (Creator::where('user_id', $user->id)->exists()) {
            return back()->withInput()->withErrors([
                'pseudo' => trans('creatorcodes::admin.errors.duplicate_user'),
            ]);
        }

        Creator::create([
            'user_id' => $user->id,
            'code' => strtoupper($validated['code']),
            'percentage' => $validated['percentage'],
            'is_enabled' => true,
        ]);

        return redirect()->route('creatorcodes.admin.index')
            ->with('success', trans('creatorcodes::admin.created'));
    }

    public function edit(Creator $creator)
    {
        $creator->load('user');

        return view('creatorcodes::admin.edit', [
            'creator' => $creator,
        ]);
    }

    public function update(Request $request, Creator $creator)
    {
        $validated = $this->validate($request, [
            'pseudo' => 'required|string|max:32',
            'code' => ['required', 'string', 'max:32', 'alpha_dash', Rule::unique('creatorcodes_creators', 'code')->ignore($creator->id)],
            'percentage' => 'required|numeric|min:0.01|max:100',
        ]);

        $user = User::whereRaw('LOWER(name) = ?', [strtolower($validated['pseudo'])])->first();

        if ($user === null) {
            return back()->withInput()->withErrors([
                'pseudo' => trans('creatorcodes::admin.errors.user'),
            ]);
        }

        if (Creator::where('user_id', $user->id)->where('id', '!=', $creator->id)->exists()) {
            return back()->withInput()->withErrors([
                'pseudo' => trans('creatorcodes::admin.errors.duplicate_user'),
            ]);
        }

        $creator->update([
            'user_id' => $user->id,
            'code' => strtoupper($validated['code']),
            'percentage' => $validated['percentage'],
        ]);

        return redirect()->route('creatorcodes.admin.index')
            ->with('success', trans('creatorcodes::admin.updated'));
    }

    public function toggle(Creator $creator)
    {
        $creator->update(['is_enabled' => ! $creator->is_enabled]);

        return redirect()->route('creatorcodes.admin.index')
            ->with('success', trans('creatorcodes::admin.updated'));
    }

    public function destroy(Creator $creator)
    {
        $creator->delete();

        return redirect()->route('creatorcodes.admin.index')
            ->with('success', trans('creatorcodes::admin.deleted'));
    }
}
