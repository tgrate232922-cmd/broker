<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deposit extends Model
{
    use HasFactory;

    protected $table = 'deposits';

    protected $fillable = [
        'amount',
        'payment_mode',
        'status',
        'proof',
        'user',
        'signals',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    /**
     * User who made the deposit
     * Used in ADMIN as: $deposit->duser
     */
    public function duser()
    {
        return $this->belongsTo(User::class, 'user', 'id')->withDefault();
    }
}
