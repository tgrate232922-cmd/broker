<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_plans extends Model
{
    use HasFactory;

    protected $table = 'user_plans';

    protected $fillable = [
        'plan',
        'user',
        'amount',
        'activate',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'assets',
        'type',
        'leverage',
        'profit_earned',
        'active',
        'symbol',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'last_growth'  => 'datetime',
        'expire_date'  => 'datetime',
    ];

    /**
     * ✅ This is what TradesController uses: ->with('user')
     * Note: your FK column is `user` (not user_id), so keep it like this.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    /**
     * Optional: plan relation (only if you use it in blades)
     */
    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan', 'id');
    }
}
