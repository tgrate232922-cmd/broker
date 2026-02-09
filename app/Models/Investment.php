<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    /**
     * Explicit table name (after renaming user_plans -> investments)
     */
    protected $table = 'investments';

    /**
     * Eager-load relations used in the Blade (prevents N+1 and ensures non-null uplan)
     */
    protected $with = ['uplan', 'puser'];

    /**
     * Mass-assignable fields (adjust to your columns as needed)
     */
    protected $fillable = [
        // common columns you likely have — add/remove to fit your schema
        'user', 'plan', 'amount', 'active', 'expiration', 'expire_date',
        'created_at', 'updated_at',
    ];
    
    public function dplan()
{
    return $this->uplan();
}

    /**
     * Attribute casting
     */
    protected $casts = [
        'activated_at' => 'datetime',
        'last_growth'  => 'datetime',
        'expire_date'  => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'amount'       => 'float',
    ];

    /**
     * Relationship to the Plan model used in Blade as $plan->uplan->name, increment_amount, etc.
     * NOTE: If your plan FK column is `plan_id` (not `plan`), change the 2nd argument to 'plan_id'.
     * Also, if Plan model class is named `Plan` (singular), change `Plans::class` to `Plan::class`.
     */
    public function uplan()
    {
        return $this->belongsTo(Plans::class, 'plan', 'id')
            // If your Plans model uses SoftDeletes and you want soft-deleted plans to still show, uncomment next line:
            // ->withTrashed()
            ->withDefault(); // prevents "Attempt to read property 'name' on null" in Blade
    }

    /**
     * Owner of the investment
     * NOTE: If your FK is `user_id` (not `user`), change the 2nd argument to 'user_id'.
     */
    public function puser()
    {
        return $this->belongsTo(User::class, 'user', 'id')->withDefault();
    }

    /**
     * Scope: only current user’s investments (handy in controllers)
     */
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user', $userId);
        // If your FK is user_id: return $query->where('user_id', $userId);
    }
}
