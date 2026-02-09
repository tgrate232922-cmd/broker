<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TradeController extends Controller
{
    /**
     * Only allow DAO instruments to show on this page.
     * IMPORTANT: These must match what you store in instruments.type
     */
    private function daoTypes(): array
    {
        return [
            'dao_contract',
            'top_pool',
            // add more if you have them:
            // 'governance_pool',
            // 'validator_pool',
        ];
    }

    /**
     * Display the DAO markets page (DAO only)
     */
   public function index()
{
    $pools = DaoPool::where('active', 1)
        ->orderByDesc('tvl')
        ->get();

    return view('user.dao.index', [
        'title' => 'DAO Pools',
        'pools' => $pools
    ]);
}

    /**
     * Single DAO instrument page
     */
    public function single($id)
    {
        // Ensure the instrument is DAO-type only
        $instrument = Instrument::query()
            ->whereIn('type', $this->daoTypes())
            ->where('id', $id)
            ->firstOrFail();

        $searchTerms = [
            $instrument->symbol,
            strtolower($instrument->symbol),
            strtoupper($instrument->symbol),
            str_replace(['/', ' '], '', $instrument->symbol),
        ];

        if (!empty($instrument->name)) {
            $searchTerms[] = $instrument->name;
            $searchTerms[] = strtolower($instrument->name);
            $searchTerms[] = str_replace(' ', '', $instrument->name);
        }

        $searchTerms = array_filter(array_unique($searchTerms));

        $openTradesQuery = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where(function($query) use ($instrument, $searchTerms) {
                $query->where('assets', $instrument->symbol)
                      ->orWhere('symbol', $instrument->symbol);

                foreach ($searchTerms as $term) {
                    $query->orWhere('assets', 'like', "%{$term}%")
                          ->orWhere('symbol', 'like', "%{$term}%");
                }
            })
            ->where('active', 'yes')
            ->orderBy('created_at', 'desc');

        $openTrades = $openTradesQuery->get();

        $closedTradesQuery = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where(function($query) use ($instrument, $searchTerms) {
                $query->where('assets', $instrument->symbol)
                      ->orWhere('symbol', $instrument->symbol);

                foreach ($searchTerms as $term) {
                    $query->orWhere('assets', 'like', "%{$term}%")
                          ->orWhere('symbol', 'like', "%{$term}%");
                }
            })
            ->where('active', 'expired')
            ->orderBy('created_at', 'desc')
            ->limit(10);

        $closedTrades = $closedTradesQuery->get();

        return view('user.trade.single', [
            'title' => 'Stake ' . ($instrument->name ?? $instrument->symbol),
            'instrument' => $instrument,
            'openTrades' => $openTrades,
            'closedTrades' => $closedTrades
        ]);
    }

    /**
     * DAO instruments by type (API) - blocks non-DAO types
     */
    public function getByType($type)
    {
        if (!in_array($type, $this->daoTypes(), true)) {
            return response()->json([]); // return empty, don’t leak other markets
        }

        $instruments = Instrument::query()
            ->where('type', $type)
            ->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        return response()->json($instruments);
    }

    /**
     * Search DAO instruments only
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $type  = $request->get('type');

        $instruments = Instrument::query()->whereIn('type', $this->daoTypes());

        if ($query) {
            $instruments->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('symbol', 'LIKE', "%{$query}%");
            });
        }

        // Type filter (only DAO types allowed)
        if ($type && $type !== 'all') {
            if (!in_array($type, $this->daoTypes(), true)) {
                return response()->json([]);
            }
            $instruments->where('type', $type);
        }

        $results = $instruments
            ->orderBy('volume', 'desc')
            ->orderBy('market_cap', 'desc')
            ->get();

        return response()->json($results);
    }

    /**
     * Monitor page (kept same)
     */
    public function monitor($tradeId)
    {
        $trade = DB::table('user_plans')
            ->where('id', $tradeId)
            ->where('user', auth()->id())
            ->first();

        if (!$trade) {
            return redirect()->route('trade.index')->with('error', 'Stake not found or you do not have permission to view it.');
        }

        // DAO instrument lookup
        $instrument = Instrument::query()
            ->whereIn('type', $this->daoTypes())
            ->where('symbol', $trade->assets)
            ->orWhere('name', $trade->assets)
            ->first();

        $relatedTrades = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where('assets', $trade->assets)
            ->where('id', '!=', $tradeId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = DB::table('user_plans')
            ->where('user', auth()->id())
            ->where('assets', $trade->assets)
            ->selectRaw('
                COUNT(*) as total_trades,
                COUNT(CASE WHEN active = "expired" THEN 1 END) as completed_trades,
                COUNT(CASE WHEN active = "yes" THEN 1 END) as active_trades,
                SUM(amount) as total_invested,
                AVG(amount) as avg_trade_size
            ')
            ->first();

        $pnl = $this->calculateTradesPnL($trade, $instrument);

        $timeLeft = 'N/A';
        if ($trade->active === 'yes' && $trade->expire_date) {
            $now = Carbon::now();
            $expireDate = Carbon::parse($trade->expire_date);
            $timeLeft = $now < $expireDate ? $now->diffForHumans($expireDate) : 'Expired';
        }

        $title = 'Monitor Stake - ' . $trade->assets;

        return view('user.trade.monitor', compact('trade', 'instrument', 'relatedTrades', 'stats', 'pnl', 'timeLeft', 'title'));
    }

    // (kept your existing PnL methods as-is below)
    private function calculateTradesPnL($trade, $instrument = null)
    {
        // ... KEEP YOUR EXISTING METHOD BODY HERE (unchanged) ...
        // I’m not re-pasting to avoid breaking anything you already tested.

        // IMPORTANT: Don’t delete your existing calculateTradesPnL(), simulateTradeResult(), simulateActiveTradePnL()
        // Just keep them exactly as they are in your current file.

        return [
            'current_value' => 0,
            'profit_loss' => 0,
            'return_percentage' => 0,
            'is_profit' => false,
            'status' => 'pending'
        ];
    }
}
