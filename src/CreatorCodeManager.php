<?php

namespace Azuriom\Plugin\CreatorCodes;

use Azuriom\Models\User;
use Azuriom\Notifications\AlertNotification;
use Azuriom\Plugin\CreatorCodes\Models\Creator;
use Azuriom\Plugin\CreatorCodes\Models\Reward;
use Azuriom\Plugin\Shop\Models\Offer;
use Azuriom\Plugin\Shop\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CreatorCodeManager
{
    public const SESSION_KEY = 'creatorcodes.code';

    public function apply(string $code, ?User $user = null): Creator
    {
        $creator = Creator::findByCode($code);

        if ($creator === null) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'creator_code' => trans('creatorcodes::messages.errors.invalid'),
            ]);
        }

        Session::put(self::SESSION_KEY, $creator->code);

        if ($user !== null) {
            $this->bindUser($user, $creator);
        }

        return $creator;
    }

    public function remove(?User $user = null): void
    {
        Session::forget(self::SESSION_KEY);

        if ($user !== null) {
            DB::table('creatorcodes_bindings')->where('user_id', $user->id)->delete();
        }
    }

    public function current(?User $user = null): ?Creator
    {
        $code = Session::get(self::SESSION_KEY);

        if (is_string($code) && $code !== '') {
            $creator = Creator::findByCode($code);

            if ($creator !== null) {
                return $creator;
            }

            Session::forget(self::SESSION_KEY);
        }

        if ($user === null) {
            return null;
        }

        $binding = DB::table('creatorcodes_bindings')->where('user_id', $user->id)->first();

        if ($binding === null) {
            return null;
        }

        return Creator::enabled()->with('user')->find($binding->creator_id);
    }

    public function attachToPayment(Payment $payment): void
    {
        if ($payment->user_id === null) {
            return;
        }

        if (DB::table('creatorcodes_payments')->where('payment_id', $payment->id)->exists()) {
            return;
        }

        $creator = $this->current($payment->user);

        if ($creator === null) {
            return;
        }

        DB::table('creatorcodes_payments')->insert([
            'payment_id' => $payment->id,
            'creator_id' => $creator->id,
            'code' => $creator->code,
            'percentage' => $creator->percentage,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function rewardPayment(Payment $payment): void
    {
        $payment->refresh();

        if (! $payment->isCompleted() || $payment->isWithSiteMoney()) {
            return;
        }

        if ($payment->id !== null && Reward::where('payment_id', $payment->id)->exists()) {
            return;
        }

        $this->attachToPayment($payment);

        $link = DB::table('creatorcodes_payments')->where('payment_id', $payment->id)->first();
        $creator = $link !== null
            ? Creator::enabled()->find($link->creator_id)
            : $this->current($payment->user);

        if ($creator === null) {
            return;
        }

        if ((int) $creator->user_id === (int) $payment->user_id) {
            return;
        }

        $neosBought = $this->neosBought($payment);

        if ($neosBought <= 0) {
            return;
        }

        $percentage = $link->percentage ?? $creator->percentage;
        $rewarded = round($neosBought * ((float) $percentage / 100), 2);

        if ($rewarded <= 0) {
            return;
        }

        $creator->user->addMoney($rewarded);

        Reward::create([
            'creator_id' => $creator->id,
            'buyer_id' => $payment->user_id,
            'payment_id' => $payment->id,
            'code' => $creator->code,
            'percentage' => $percentage,
            'neos_bought' => $neosBought,
            'neos_rewarded' => $rewarded,
        ]);

        $notification = new AlertNotification(trans('creatorcodes::messages.notification', [
            'amount' => format_money($rewarded),
            'buyer' => $payment->user->name,
            'code' => $creator->code,
        ]));

        $creator->user->notifications()->create($notification->toArray());
    }

    public function rememberMoneyDelta(User $user, float $delta): void
    {
        if ($delta <= 0) {
            return;
        }

        app()->instance('creatorcodes.money_delta.'.$user->id, $delta);
    }

    private function bindUser(User $user, Creator $creator): void
    {
        DB::table('creatorcodes_bindings')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'creator_id' => $creator->id,
                'code' => $creator->code,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    private function neosBought(Payment $payment): float
    {
        $neos = 0.0;

        foreach ($payment->items as $item) {
            $buyable = $item->buyable;

            if ($buyable instanceof Offer) {
                $neos += ((float) $buyable->money) * $item->quantity;
            }
        }

        if ($neos > 0) {
            return $neos;
        }

        $key = 'creatorcodes.money_delta.'.$payment->user_id;

        return app()->bound($key) ? (float) app($key) : 0.0;
    }
}
