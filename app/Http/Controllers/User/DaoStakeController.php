<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DaoPool;
use App\Models\User_plans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DaoStakeController extends Controller
{
    /**
     * DAO Pools Listing (replaces trading markets)
     */
    public function index()
    {
        $pools = DaoPool::where('active', 1)->orderByDesc('tvl')->get();

        return view('user.dao.index', [
            'title' => 'DAO Staking Pools',
            'pools' => $pools
        ]);
    }

    /**
     * Single DAO Pool
     */
    public function single($id)
    {
        $pool = DaoPool::findOrFail($id);

        // Check if user already staked once
        $alreadyStaked = User_plans::where('user', auth()->id())
            ->where('type', 'dao')
            ->exists();

        return view('user.dao.single', [
            'title' => $pool->name,
            'pool' => $pool,
            'alreadyStaked' => $alreadyStaked
        ]);
    }

    /**
     * Start DAO Stake (ONE TIME)
     */
    public function stake(Request $request, $id)
    {
        $pool = DaoPool::findOrFail($id);

        // One-time staking enforcement
        $alreadyStaked = User_plans::where('user', auth()->id())
            ->where('type', 'dao')
            ->exists();

        if ($alreadyStaked) {
            return redirect()->route('dao.index')
                ->with('error', 'You have already used the instant AI stake. Please subscribe to continue.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);

        $expireDate = Carbon::now()->addDays($pool->duration_days);

        User_plans::create([
            'plan' => 0,
            'user' => auth()->id(),
            'amount' => $request->amount,
            'active' => 'yes',
            'assets' => $pool->symbol,
            'type' => 'dao',
            'inv_duration' => $pool->duration_days . ' days',
            'expire_date' => $expireDate,
            'activated_at' => now(),
            'last_growth' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'DAO stake activated. Earnings started immediately.');
    }
}
