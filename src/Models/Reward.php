<?php

namespace Azuriom\Plugin\CreatorCodes\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Azuriom\Plugin\Shop\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'creatorcodes_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creator_id', 'buyer_id', 'payment_id', 'code', 'percentage',
        'neos_bought', 'neos_rewarded',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'percentage' => 'float',
        'neos_bought' => 'float',
        'neos_rewarded' => 'float',
    ];

    public function creator()
    {
        return $this->belongsTo(Creator::class, 'creator_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
