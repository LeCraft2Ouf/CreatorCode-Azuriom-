<?php

namespace Azuriom\Plugin\CreatorCodes\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property float $percentage
 * @property bool $is_enabled
 * @property \Azuriom\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder enabled()
 */
class Creator extends Model
{
    use HasTablePrefix;
    use Loggable;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'creatorcodes_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'code', 'percentage', 'is_enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'percentage' => 'float',
        'is_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class, 'creator_id');
    }

    public function scopeEnabled(Builder $query): void
    {
        $query->where('is_enabled', true);
    }

    public static function findByCode(string $code): ?self
    {
        return static::enabled()
            ->with('user')
            ->whereRaw('UPPER(code) = ?', [strtoupper(trim($code))])
            ->first();
    }
}
