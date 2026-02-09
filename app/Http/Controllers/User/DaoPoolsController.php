<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaoPoolsController extends Controller
{
    public function live(Request $request)
    {
        // Demo pools (NO dexkchain)
        $pools = [
            ['name' => 'Arbitrum DAO Vault',      'symbol' => 'ARB-DAO',  'apy' => 14.60, 'change24h' => 1.20,  'tvl' => 128400000],
            ['name' => 'Optimism Governance Pool','symbol' => 'OP-GOV',   'apy' => 11.30, 'change24h' => -0.60, 'tvl' => 86400000],
            ['name' => 'Uniswap DAO Staking',     'symbol' => 'UNI-DAO',  'apy' => 9.80,  'change24h' => 0.30,  'tvl' => 172900000],
            ['name' => 'Aave Governance Vault',   'symbol' => 'AAVE-GOV', 'apy' => 8.50,  'change24h' => 0.90,  'tvl' => 64200000],
        ];

        // 30-day demo series (stable “live-like”)
        $base = 10.5;
        $series = [];
        for ($i=0; $i<30; $i++) {
            $wiggle = sin(($i+1) * 0.55) * 1.2 + cos(($i+1) * 0.21) * 0.8;
            $series[] = round($base + $wiggle + (rand(-30, 30) / 100), 2);
        }

        return response()->json([
            'ok' => true,
            'meta' => [
                'source' => 'demo',
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ],
            'pools' => $pools,
            'chart' => [
                'series' => $series
            ],
        ]);
    }
}
