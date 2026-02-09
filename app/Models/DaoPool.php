<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaoPool extends Model
{
    use HasFactory;

    protected $table = 'dao_pools';

    protected $fillable = [
        'name',
        'symbol',
        'type',
        'strategy_summary',
        'contract_address',
        'apy',
        'tvl',
        'risk_level',
        'logo',
        'active',
        'duration_days',
    ];

    protected $casts = [
        'apy' => 'float',
        'tvl' => 'float',
        'active' => 'boolean',
        'duration_days' => 'integer',
    ];
}
