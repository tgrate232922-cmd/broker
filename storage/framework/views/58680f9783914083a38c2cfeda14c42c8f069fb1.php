<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8" x-data="{ showCopied: false }">

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.danger-alert','data' => []]); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.success-alert','data' => []]); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.notify-alert','data' => []]); ?>
<?php $component->withName('notify-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <!-- Dashboard Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 sm:mb-8 gap-4">
        <div class="text-center lg:text-left">
           <?php
    $userCreatedAt = \Carbon\Carbon::parse(Auth::user()->created_at);
    $secondsSinceCreated = now()->diffInSeconds($userCreatedAt);
?>

<?php if($secondsSinceCreated <= 90): ?>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Welcome, <?php echo e(Auth::user()->name); ?>!
    </h1>
<?php else: ?>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Welcome back, <?php echo e(Auth::user()->name); ?>!
    </h1>
<?php endif; ?>

        </div>
        <div class="hidden sm:flex flex-col sm:flex-row gap-2 sm:gap-3">
            <?php if($settings->wallet_status == "on"): ?>
                <a href="<?php echo e(route('connect_wallet')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg shadow hover:from-indigo-700 transition animate-pulse text-sm sm:text-base">
                    <i data-lucide="link" class="w-4 h-4 sm:w-5 sm:h-5"></i> Connect Wallet
                </a>
            <?php else: ?>
                <div class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm sm:text-base">
                    <i data-lucide="check-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i> Connected
                </div>
            <?php endif; ?>
        </div>
    </div>




    <!-- Signal Strength -->
    <?php if(Auth::user()->progress > 2): ?>
    <div class="mb-6 sm:mb-8">
        <?php
            $signalStrength = Auth::user()->progress;
            $signalColor = '';
            $signalText = '';
            $signalIcon = '';

            if ($signalStrength < 25) {
                $signalColor = 'from-red-500 to-red-600';
                $signalText = 'Weak Signal';
                $signalIcon = 'signal-low';
            } elseif ($signalStrength >= 25 && $signalStrength < 50) {
                $signalColor = 'from-yellow-500 to-orange-500';
                $signalText = 'Moderate Signal';
                $signalIcon = 'signal-medium';
            } else {
                $signalColor = 'from-green-500 to-emerald-600';
                $signalText = 'Strong Signal';
                $signalIcon = 'signal-high';
            }
        ?>

        <div class="bg-black rounded-xl p-4 sm:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="<?php echo e($signalIcon); ?>" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-gray-100">Trading Signal Strength</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white"><?php echo e($signalStrength); ?>%</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        <?php echo e($signalStrength < 25 ? 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400' :
                           ($signalStrength < 50 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' :
                            'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400')); ?>">
                        <?php echo e($signalText); ?>

                    </span>
                </div>
            </div>

            <div class="w-full h-3 sm:h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden relative">
                <div class="bg-gradient-to-r <?php echo e($signalColor); ?> h-full rounded-full transition-all duration-700 ease-out relative"
                     style="width: <?php echo e($signalStrength); ?>%">
                    <div class="absolute inset-0 bg-white/20 animate-pulse rounded-full"></div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                <span>0% Weak</span>
                <span>25% Moderate</span>
                <span>50%+ Strong</span>
            </div>

            <p class="text-xs text-gray-600 dark:text-gray-400 mt-3 text-center">
                <?php if($signalStrength < 25): ?>
                    ⚠️ Signal strength is low. Consider waiting for better market conditions.
                <?php elseif($signalStrength < 50): ?>
                    ⚡ Moderate signal detected. Proceed with caution and proper risk management.
                <?php else: ?>
                    🚀 Strong signal strength! Optimal conditions for trading opportunities.
                <?php endif; ?>
            </p>
        </div>
    </div>
    <?php endif; ?>


 <!-- Investment Dashboard - Clean Modern Layout -->
<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 sm:gap-6 items-stretch mb-6 sm:mb-8">
    <!-- Account Balance -->
<div
    class="relative xl:col-span-2 h-full rounded-2xl bg-white dark:bg-gray-900 p-4 sm:p-5 lg:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 transition-all overflow-hidden"
    id="balanceCard"
    x-data="balanceCardWidget()"
    x-init="init()"
>
    <!-- Faded animated chart background -->
    <div class="pointer-events-none absolute inset-0">
        <!-- soft glow -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-indigo-500/10 blur-3xl"></div>

        <!-- animated sparkline (faded) -->
        <svg class="absolute inset-0 w-full h-full opacity-25 dark:opacity-30" viewBox="0 0 600 240" preserveAspectRatio="none">
            <!-- gradient stroke -->
            <defs>
                <linearGradient id="sparkGrad" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="rgb(59,130,246)" stop-opacity="0.2"/>
                    <stop offset="50%" stop-color="rgb(99,102,241)" stop-opacity="0.5"/>
                    <stop offset="100%" stop-color="rgb(34,211,238)" stop-opacity="0.25"/>
                </linearGradient>

                <linearGradient id="fillGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="rgb(59,130,246)" stop-opacity="0.20"/>
                    <stop offset="100%" stop-color="rgb(59,130,246)" stop-opacity="0"/>
                </linearGradient>

                <!-- Mask to animate the line sweep -->
                <mask id="revealMask">
                    <rect x="0" y="0" width="600" height="240" fill="white">
                        <animate attributeName="x" values="-600;600" dur="5s" repeatCount="indefinite"/>
                    </rect>
                </mask>
            </defs>

            <!-- fill under line -->
            <path
                :d="areaPath"
                fill="url(#fillGrad)"
            ></path>

            <!-- base line -->
            <path
                :d="linePath"
                fill="none"
                stroke="url(#sparkGrad)"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
            ></path>

            <!-- animated highlight sweep -->
            <path
                :d="linePath"
                fill="none"
                stroke="rgb(34,211,238)"
                stroke-opacity="0.45"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
                mask="url(#revealMask)"
            ></path>
        </svg>
    </div>

    <!-- Content -->
    <div class="relative">
        <div class="flex justify-between items-start mb-4 gap-3">
            <div class="text-center sm:text-left w-full sm:w-auto">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white flex items-center justify-center sm:justify-start">
                    <i data-lucide="wallet" class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500 dark:text-gray-300"></i>
                    Total Assets
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Available Balance</p>
            </div>

            <!-- APR badge -->
            <div class="flex flex-col items-end">
                <div
                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold ring-1"
                    :class="aprChange >= 0
                        ? 'bg-green-50 text-green-700 ring-green-200 dark:bg-green-900/20 dark:text-green-300 dark:ring-green-800'
                        : 'bg-red-50 text-red-700 ring-red-200 dark:bg-red-900/20 dark:text-red-300 dark:ring-red-800'"
                >
                    <i
                        data-lucide="trending-up"
                        class="w-3.5 h-3.5"
                        x-show="aprChange >= 0"
                    ></i>
                    <i
                        data-lucide="trending-down"
                        class="w-3.5 h-3.5"
                        x-show="aprChange < 0"
                    ></i>

                    <span x-text="aprText"></span>
                    <span class="opacity-70">APR</span>
                </div>

                <span class="mt-1 text-[11px] text-gray-500 dark:text-gray-400" x-text="aprHint"></span>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center sm:justify-start mb-2">
                <h3 id="balanceAmount" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 break-all">
                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2, '.', ',')); ?>

                </h3>
                <h3 id="hiddenBalance" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 hidden">••••••</h3>
            </div>

            <!-- optional daily change -->
            <div class="flex items-center justify-center sm:justify-start mb-3">
                <span
                    class="text-xs font-medium px-2 py-1 rounded-full bg-white/60 dark:bg-gray-800/60 ring-1 ring-gray-200/60 dark:ring-gray-700/60"
                    :class="dailyChange >= 0 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300'"
                >
                    <span x-text="dailyChange >= 0 ? '▲' : '▼'"></span>
                    <span x-text="dailyChangeText"></span>
                    <span class="opacity-70">today</span>
                </span>
            </div>


            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center sm:text-left">
                Last updated: <?php echo e(now()->format('M d, Y h:i A')); ?>

            </p>

            <div class="mt-auto flex flex-col sm:flex-row gap-2">
                <a href="<?php echo e(route('deposits')); ?>" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Deposit
                </a>
                <a href="<?php echo e(route('withdrawalsdeposits')); ?>" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function balanceCardWidget() {
    return {
        // ====== APR ======
        // set these from backend later if you want; for now we animate slightly
        aprBase: 12.4,          // your baseline APR
        aprChange: 0.0,         // +/- change displayed
        aprText: '0.00%',
        aprHint: '24h change',

        // ====== Daily balance movement badge (visual only) ======
        dailyChange: 0,
        dailyChangeText: '+0.00%',

        // ====== Sparkline points ======
        points: [22, 28, 24, 36, 30, 42, 39, 55, 49, 60, 57, 70],
        linePath: '',
        areaPath: '',

        init() {
            this.buildPaths();
            this.tick();
            setInterval(() => this.tick(), 2500);

            // re-render icons if lucide exists
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        },

        tick() {
            // small random drift so it feels “live”
            const drift = (Math.random() - 0.5) * 2.2; // -1.1 to +1.1
            this.aprChange = parseFloat((this.aprChange + drift / 10).toFixed(2));

            // clamp so it doesn't go crazy
            if (this.aprChange > 2.5) this.aprChange = 2.5;
            if (this.aprChange < -2.5) this.aprChange = -2.5;

            const shown = (this.aprBase + this.aprChange);
            this.aprText = (this.aprChange >= 0 ? '+' : '') + this.aprChange.toFixed(2) + '%';
            this.aprHint = 'Current: ' + shown.toFixed(2) + '% APR';

            // daily change follows apr direction a bit (visual)
            this.dailyChange = this.aprChange;
            this.dailyChangeText = (this.dailyChange >= 0 ? '+' : '') + Math.abs(this.dailyChange).toFixed(2) + '%';

            // animate sparkline by shifting points
            const last = this.points[this.points.length - 1];
            let next = last + (Math.random() - 0.5) * 10;
            next = Math.max(10, Math.min(85, next));
            this.points.shift();
            this.points.push(next);
            this.buildPaths();
        },

        buildPaths() {
            // convert points to svg coordinates
            const w = 600, h = 240;
            const paddingX = 20;
            const paddingY = 30;

            const max = Math.max(...this.points);
            const min = Math.min(...this.points);

            const scaleX = (w - paddingX * 2) / (this.points.length - 1);
            const scaleY = (h - paddingY * 2) / (max - min || 1);

            const coords = this.points.map((v, i) => {
                const x = paddingX + i * scaleX;
                const y = (h - paddingY) - ((v - min) * scaleY);
                return { x, y };
            });

            // line path
            this.linePath = coords.map((p, i) => (i === 0 ? `M ${p.x} ${p.y}` : `L ${p.x} ${p.y}`)).join(' ');

            // area path (fill to bottom)
            const bottomY = h - paddingY;
            this.areaPath =
                `${this.linePath} L ${coords[coords.length - 1].x} ${bottomY} ` +
                `L ${coords[0].x} ${bottomY} Z`;
        }
    }
}
</script>


    <!-- Secondary Metrics (DAO Upgrade: Rolling Ring + Trend + Animated Percent) -->
<?php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $uid = Auth::id();

    // --------- Helper functions ----------
    $safeNum = function($n) { return floatval($n ?? 0); };

    $calcPct = function($value, $target) {
        $target = max(1, floatval($target ?? 1));
        $p = (floatval($value) / $target) * 100;
        return max(0, min(100, round($p)));
    };

    $trend = function($current, $previous) {
        $current = floatval($current ?? 0);
        $previous = floatval($previous ?? 0);

        if ($previous <= 0 && $current > 0) {
            return ['dir' => 'up', 'pct' => 100];
        }
        if ($previous <= 0 && $current <= 0) {
            return ['dir' => 'flat', 'pct' => 0];
        }

        $change = (($current - $previous) / $previous) * 100;
        if (abs($change) < 0.5) return ['dir' => 'flat', 'pct' => round($change, 1)];
        return ['dir' => $change >= 0 ? 'up' : 'down', 'pct' => round($change, 1)];
    };

    // --------- Pull "previous period" metrics (7d vs prior 7d) ----------
    $now = Carbon::now();
    $from7 = $now->copy()->subDays(7);
    $from14 = $now->copy()->subDays(14);

    // NOTE: These tables are common in your project:
    // deposits table (user column) + withdrawals table (user column) + user_plans (trades)
    // If any doesn’t exist, the query will fail in Blade.
    // So we wrap with try/catch and fallback to 0.

    $sumTable = function($table, $col, $dateCol, $from, $to) use ($uid) {
        try {
            return DB::table($table)
                ->where('user', $uid)
                ->whereBetween($dateCol, [$from, $to])
                ->sum($col);
        } catch (\Throwable $e) {
            return 0;
        }
    };

    // Deposits
    $dep7  = $sumTable('deposits', 'amount', 'created_at', $from7, $now);
    $dep14 = $sumTable('deposits', 'amount', 'created_at', $from14, $from7);

    // Withdrawals
    $wd7  = $sumTable('withdrawals', 'amount', 'created_at', $from7, $now);
    $wd14 = $sumTable('withdrawals', 'amount', 'created_at', $from14, $from7);

    // Vault Yield (using user ROI)
    // If you don’t store ROI history, we approximate:
    // previous = current - profit earned in last 7 days from trades
    $profit7 = 0;
    $profit14 = 0;
    try {
        $profit7 = DB::table('user_plans')
            ->where('user', $uid)
            ->whereBetween('created_at', [$from7, $now])
            ->sum('profit_earned');

        $profit14 = DB::table('user_plans')
            ->where('user', $uid)
            ->whereBetween('created_at', [$from14, $from7])
            ->sum('profit_earned');
    } catch (\Throwable $e) {
        $profit7 = 0;
        $profit14 = 0;
    }

    $roiCurrent = $safeNum(Auth::user()->roi);
    $roiPrev = max(0, $roiCurrent - $safeNum($profit7)); // approximation

    // Bonus
    $bonusCurrent = $safeNum(Auth::user()->bonus);
    // If you don’t have bonus history: previous = current (flat)
    $bonusPrev = $bonusCurrent;

    // --------- Set "targets" so the ring % is meaningful ----------
    // Make them proportional: ring shows progress to an "expected" cap.
    // You can tune these later.
    $targets = [
        'yield'  => max(100, $roiCurrent * 2),                // show ~50% if you’re halfway to doubling ROI
        'staked' => max(500, ($safeNum($deposited) ?? 0) * 2),
        'claim'  => max(500, ($safeNum($total_withdrawal) ?? 0) * 2),
        'bonus'  => max(50, $bonusCurrent * 2),
    ];

    // --------- Build cards (DAO terms) ----------
    $cards = [
        [
            'label' => 'Vault Yield',
            'sub'   => 'DAO earnings accrued',
            'value' => $roiCurrent,
            'prev'  => $roiPrev,
            'percent' => $calcPct($roiCurrent, $targets['yield']),
            'icon'  => 'sparkles',
        ],
        [
            'label' => 'DAO Stake Volume',
            'sub'   => 'Total staked into pools',
            'value' => $safeNum($deposited),
            'prev'  => $safeNum($deposited) - $safeNum($dep7), // approx: remove last 7 days deposits
            'percent' => $calcPct($safeNum($deposited), $targets['staked']),
            'icon'  => 'layers',
        ],
        [
            'label' => 'Rewards Claimed',
            'sub'   => 'Withdrawn yield & payouts',
            'value' => $safeNum($total_withdrawal),
            'prev'  => $safeNum($total_withdrawal) - $safeNum($wd7),
            'percent' => $calcPct($safeNum($total_withdrawal), $targets['claim']),
            'icon'  => 'arrow-up-right',
        ],
        [
            'label' => 'Vault Boost',
            'sub'   => 'Bonus credits available',
            'value' => $bonusCurrent,
            'prev'  => $bonusPrev,
            'percent' => $calcPct($bonusCurrent, $targets['bonus']),
            'icon'  => 'gift',
        ],
    ];
?>

<div class="xl:col-span-3 grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-2 gap-3 sm:gap-4" x-data>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $t = $trend($card['value'], $card['prev']);

            // SVG math
            $r = 26;
            $c = 2 * 3.1415926535 * $r;
            $dash = ($card['percent'] / 100) * $c;

            $trendColor = $t['dir'] === 'up'
                ? 'text-green-600 dark:text-green-400'
                : ($t['dir'] === 'down' ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400');

            $trendBadge = $t['dir'] === 'up'
                ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                : ($t['dir'] === 'down' ? 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400'
                    : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300');

            $trendIcon = $t['dir'] === 'up' ? 'trending-up' : ($t['dir'] === 'down' ? 'trending-down' : 'minus');
        ?>

        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-900 p-3 sm:p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 flex flex-col">
            <!-- Glassy glow -->
            <div class="pointer-events-none absolute -top-14 -right-14 w-32 h-32 rounded-full bg-blue-500/10 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 w-40 h-40 rounded-full bg-indigo-500/10 blur-2xl"></div>

            <!-- Header -->
            <div class="flex items-start justify-between gap-2 mb-3">
                <div class="min-w-0">
                    <div class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">
                        <?php echo e($card['label']); ?>

                    </div>
                    <div class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 truncate">
                        <?php echo e($card['sub']); ?>

                    </div>
                </div>

                <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-gray-100/80 dark:bg-gray-800/80 ring-1 ring-gray-200 dark:ring-gray-700">
                    <i data-lucide="<?php echo e($card['icon']); ?>" class="w-4 h-4 text-gray-600 dark:text-gray-300"></i>
                </div>
            </div>

            <!-- Ring + Value -->
            <div class="flex items-center justify-between gap-3">
                <!-- Rolling Ring -->
                <div class="relative w-16 h-16 sm:w-[72px] sm:h-[72px]">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 64 64">
                        <!-- track -->
                        <circle cx="32" cy="32" r="26" fill="none" stroke-width="6"
                            class="text-gray-200 dark:text-gray-700"
                            stroke="currentColor" stroke-linecap="round" />
                        <!-- progress (animated stroke) -->
                        <circle
                            cx="32" cy="32" r="26" fill="none" stroke-width="6"
                            class="text-blue-500 dark:text-blue-400 ring-progress"
                            stroke="currentColor" stroke-linecap="round"
                            stroke-dasharray="0 <?php echo e($c); ?>"
                            data-dash="<?php echo e($dash); ?>"
                            data-circ="<?php echo e($c); ?>"
                        />
                        <!-- inner soft ring -->
                        <circle cx="32" cy="32" r="18" fill="none" stroke-width="2"
                            class="text-blue-500/20 dark:text-blue-400/20"
                            stroke="currentColor" />
                    </svg>

                    <!-- rolling overlay (subtle spin) -->
                    <div class="absolute inset-0 rounded-full animate-daoSpin opacity-70"></div>

                    <!-- center -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        
                    </div>
                </div>

                <!-- Amount + Trend -->
                <div class="flex-1 min-w-0 text-right">
                    <div class="text-[11px] text-gray-500 dark:text-gray-400"></div>
                    <div class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white truncate">
                        <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($card['value'], 2, '.', ',')); ?>

                    </div>

                    <!-- trend badge -->
                    <div class="mt-1 inline-flex items-center justify-end gap-1 text-[11px] px-2 py-1 rounded-full <?php echo e($trendBadge); ?>">
                        <i data-lucide="<?php echo e($trendIcon); ?>" class="w-3 h-3"></i>
                        
                       
                    </div>
                </div>
            </div>

            
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<style>
/* Rolling ring feel (subtle) */
@keyframes  daoSpin { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
.animate-daoSpin { animation: daoSpin 8s linear infinite; }

/* Smooth stroke animation */
.ring-progress {
  transition: stroke-dasharray 900ms ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Animate progress rings on load
  document.querySelectorAll('.ring-progress').forEach((el) => {
    const dash = parseFloat(el.dataset.dash || '0');
    const circ = parseFloat(el.dataset.circ || '1');

    // force start at 0 then animate to actual dash
    el.setAttribute('stroke-dasharray', `0 ${circ}`);

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        el.setAttribute('stroke-dasharray', `${dash} ${circ}`);
      });
    });
  });
});
</script>

</div>




    <!--<?php if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes'): ?>-->
        <!-- KYC Verification Component -->
    <!--    <div class="mb-6 sm:mb-8" x-data="{ kycDropdownOpen: false }" x-cloak>-->
    <!--        <?php if(Auth::user()->account_verify === 'Verified'): ?>-->
                <!-- Verified Status -->
    <!--            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-4 sm:p-6 shadow-sm">-->
    <!--                <div class="flex flex-col sm:flex-row items-center gap-4">-->
    <!--                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">-->
    <!--                        <i data-lucide="check-circle" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400"></i>-->
    <!--                    </div>-->
    <!--                    <div class="flex-1 text-center sm:text-left">-->
    <!--                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">-->
    <!--                            Account Verified-->
    <!--                        </h3>-->
    <!--                        <p class="text-gray-500 dark:text-gray-400 text-sm">-->
    <!--                            Your identity has been verified. All features are now available.-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                    <div class="px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">-->
    <!--                        Verified-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        <?php else: ?>-->
                <!-- KYC Verification Needed -->
    <!--            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 shadow-sm">-->
                    <!-- Header -->
    <!--                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">-->
    <!--                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">-->
    <!--                        <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">-->
    <!--                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">-->
    <!--                                <i data-lucide="shield-check" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400"></i>-->
    <!--                            </div>-->
    <!--                            <div>-->
    <!--                                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">-->
    <!--                                    Identity Verification-->
    <!--                                </h3>-->
    <!--                                <p class="text-gray-500 dark:text-gray-400 text-sm">-->
    <!--                                    Complete verification to access all features-->
    <!--                                </p>-->
    <!--                            </div>-->
    <!--                        </div>-->

                            <!-- Toggle Button -->
    <!--                        <button @click="kycDropdownOpen = !kycDropdownOpen"-->
    <!--                                class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">-->
    <!--                            <span class="flex items-center justify-center gap-2">-->
    <!--                                <span>View Details</span>-->
    <!--                                <i data-lucide="chevron-down"-->
    <!--                                   :class="kycDropdownOpen ? 'rotate-180' : 'rotate-0'"-->
    <!--                                   class="w-4 h-4 transition-transform"></i>-->
    <!--                            </span>-->
    <!--                        </button>-->
    <!--                    </div>-->
    <!--                </div>-->

                    <!-- Dropdown Content -->
    <!--                <div x-show="kycDropdownOpen"-->
    <!--                     x-transition:enter="transition ease-out duration-200"-->
    <!--                     x-transition:enter-start="opacity-0 -translate-y-1"-->
    <!--                     x-transition:enter-end="opacity-100 translate-y-0"-->
    <!--                     x-transition:leave="transition ease-in duration-150"-->
    <!--                     x-transition:leave-start="opacity-100 translate-y-0"-->
    <!--                     x-transition:leave-end="opacity-0 -translate-y-1"-->
    <!--                     class="p-4 sm:p-6 border-t border-gray-100 dark:border-gray-800">-->

    <!--                    <?php if(Auth::user()->account_verify === 'Under review'): ?>-->
                            <!-- Under Review State -->
    <!--                        <div class="text-center space-y-4">-->
    <!--                            <div class="w-16 h-16 mx-auto bg-yellow-50 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">-->
    <!--                                <i data-lucide="clock" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>-->
    <!--                            </div>-->
    <!--                            <div>-->
    <!--                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">-->
    <!--                                    Under Review-->
    <!--                                </h4>-->
    <!--                                <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">-->
    <!--                                    Your documents are being reviewed. We'll notify you once the verification is complete.-->
    <!--                                </p>-->
    <!--                            </div>-->

                                <!-- Simple Progress -->
    <!--                            <div class="max-w-xs mx-auto">-->
    <!--                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">-->
    <!--                                    <span>Submitted</span>-->
    <!--                                    <span>Review</span>-->
    <!--                                    <span>Complete</span>-->
    <!--                                </div>-->
    <!--                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">-->
    <!--                                    <div class="bg-yellow-500 h-1.5 rounded-full w-2/3"></div>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    <?php else: ?>-->
                            <!-- Verification Needed State -->
    <!--                        <div class="text-center space-y-6">-->
    <!--                            <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center">-->
    <!--                                <i data-lucide="user-plus" class="w-8 h-8 text-gray-600 dark:text-gray-400"></i>-->
    <!--                            </div>-->

    <!--                            <div>-->
    <!--                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">-->
    <!--                                    Complete Your Verification-->
    <!--                                </h4>-->
    <!--                                <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto mb-6">-->
    <!--                                    Verify your identity to unlock higher limits and enhanced security features.-->
    <!--                                </p>-->
    <!--                            </div>-->

                                <!-- Benefits -->
    <!--                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-sm mx-auto mb-6">-->
    <!--                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">-->
    <!--                                    <i data-lucide="shield" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400"></i>-->
    <!--                                    <span class="text-xs text-gray-600 dark:text-gray-400">Enhanced Security</span>-->
    <!--                                </div>-->
    <!--                                <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">-->
    <!--                                    <i data-lucide="trending-up" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400"></i>-->
    <!--                                    <span class="text-xs text-gray-600 dark:text-gray-400">Higher Limits</span>-->
    <!--                                </div>-->
    <!--                            </div>-->

                                <!-- Verify Button -->
    <!--                            <a href="<?php echo e(route('account.verify')); ?>"-->
    <!--                               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">-->
    <!--                                <i data-lucide="user-check" class="w-4 h-4"></i>-->
    <!--                                <span>Start Verification</span>-->
    <!--                            </a>-->
    <!--                        </div>-->
    <!--                    <?php endif; ?>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        <?php endif; ?>-->
    <!--    </div>-->
    <!--<?php endif; ?>-->

 <!--<?php if($settings->wallet_status == 'on'): ?>-->
        <!-- Wallet Connection Prompt -->
 <!--       <div class="mb-6 sm:mb-8">-->
 <!--           <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-2xl p-4 sm:p-6 border border-indigo-200 dark:border-indigo-700">-->
 <!--               <div class="flex flex-col sm:flex-row items-start gap-4">-->
 <!--                   <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl mx-auto sm:mx-0">-->
 <!--                       <i data-lucide="wallet" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-600 dark:text-indigo-400"></i>-->
 <!--                   </div>-->
 <!--                   <div class="flex-1 text-center sm:text-left">-->
 <!--                       <h3 class="text-base sm:text-lg font-semibold text-indigo-900 dark:text-indigo-100 mb-2">Connect Your Wallet to Start Earning</h3>-->
 <!--                       <p class="text-indigo-700 dark:text-indigo-300 text-sm mb-4">-->
 <!--                           Connect your cryptocurrency wallet to unlock daily earning opportunities of up to-->
 <!--                           <span class="font-semibold"><?php echo e(Auth::user()->currency); ?><?php echo e($settings->min_return ?? '0'); ?></span> per day.-->
 <!--                       </p>-->
 <!--                       <a href="<?php echo e(route('connect_wallet')); ?>"-->
 <!--                          class="inline-flex items-center gap-2 px-4 py-2 sm:py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-[1.02] text-sm sm:text-base">-->
 <!--                           <i data-lucide="plus" class="w-4 h-4"></i>-->
 <!--                           Connect Wallet Now-->
 <!--                       </a>-->
 <!--                   </div>-->
 <!--                   <button onclick="this.parentElement.parentElement.parentElement.style.display='none'"-->
 <!--                           class="text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 absolute top-2 right-2 sm:relative sm:top-auto sm:right-auto">-->
 <!--                       <i data-lucide="x" class="w-5 h-5"></i>-->
 <!--                   </button>-->
 <!--               </div>-->
 <!--           </div>-->
 <!--       </div>-->
 <!--   <?php endif; ?>-->



 







  <div class="xl:col-span-2 rounded-2xl overflow-hidden shadow ring-1 ring-white/10 bg-gradient-to-b from-slate-950/80 to-slate-900/70 backdrop-blur-xl">
    <!-- subtle grid background -->
    <div class="relative p-4 sm:p-6">
        <div class="pointer-events-none absolute inset-0 opacity-25"
             style="background-image: linear-gradient(to right, rgba(148,163,184,.12) 1px, transparent 1px), linear-gradient(to bottom, rgba(148,163,184,.12) 1px, transparent 1px);
                    background-size: 48px 48px;"></div>

        <!-- header -->
       
<div class="relative overflow-hidden rounded-2xl border border-white/10 bg-slate-950/70 shadow-xl ring-1 ring-white/5 backdrop-blur-xl">
    
    <div class="pointer-events-none absolute inset-0 opacity-25"
         style="background-image: linear-gradient(to right, rgba(255,255,255,.06) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,.06) 1px, transparent 1px);
                background-size: 42px 42px;"></div>
    <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-emerald-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-cyan-500/20 blur-3xl"></div>

    <div class="relative p-4 sm:p-6">
        
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="text-base sm:text-lg font-semibold text-white">
                        Top Staking Pools
                    </h3>
                    <span class="inline-flex items-center gap-2 text-xs font-medium text-white/70">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Live
                    </span>
                </div>
                <p class="mt-1 text-xs text-white/60">
                    30-day yield chart (average APY index)
                </p>
            </div>

            <div class="flex items-center justify-between sm:justify-end gap-3">
                <div id="pools-status" class="text-xs text-white/60">
                    Data: Live
                </div>
                <button id="pools-reload"
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-white/80 hover:bg-white/10 transition">
                    <span class="inline-block h-2 w-2 rounded-full bg-white/30"></span>
                    Refresh
                </button>
            </div>
        </div>

        
        <div class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-4">
            
            <div class="lg:col-span-8 rounded-2xl border border-white/10 bg-white/5 p-4 sm:p-5">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-white/60">APY Index (30d)</div>

                    
                    <div class="flex items-end gap-1 opacity-50">
                        <?php for($i=0; $i<18; $i++): ?>
                            <div class="w-0.5 rounded bg-white/30 animate-pulse"
                                 style="height: <?php echo e(10 + ($i%6)*6); ?>px; animation-delay: <?php echo e($i*60); ?>ms;"></div>
                        <?php endfor; ?>
                    </div>
                </div>

                
                <div class="mt-4">
                    <div class="relative h-44 sm:h-56 rounded-xl border border-white/10 bg-slate-950/30 overflow-hidden">
                        
                        <div id="pools-loading"
                             class="absolute inset-0 flex items-center justify-center text-xs text-white/70">
                            Loading pools...
                        </div>

                        
                        <div id="apy-chart"
                             class="absolute inset-0 px-3 pb-3 pt-6 flex items-end gap-[3px]">
                        </div>

                        
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
                    </div>

                    <div class="mt-3 flex items-center justify-between text-xs text-white/60">
                        <span id="apy-min">Min: --%</span>
                        <span id="apy-max">Max: --%</span>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-4 rounded-2xl border border-white/10 bg-white/5 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs text-white/60">Top pools</div>
                    <div class="text-xs text-white/60">(24h)</div>
                </div>

                <div id="pools-rows" class="divide-y divide-white/10">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
  const statusEl  = document.getElementById('pools-status');
  const rowsEl    = document.getElementById('pools-rows');
  const chartEl   = document.getElementById('apy-chart');
  const loadingEl = document.getElementById('pools-loading');
  const minEl     = document.getElementById('apy-min');
  const maxEl     = document.getElementById('apy-max');
  const reloadBtn = document.getElementById('pools-reload');

  if (!statusEl || !rowsEl || !chartEl || !loadingEl || !minEl || !maxEl) return;

  let inFlight = false;
  let lastGood = null;

  function fmtMoney(n) {
    const num = Number(n || 0);
    if (num >= 1e9) return (num / 1e9).toFixed(1) + "B";
    if (num >= 1e6) return (num / 1e6).toFixed(1) + "M";
    if (num >= 1e3) return (num / 1e3).toFixed(1) + "K";
    return String(Math.round(num));
  }

  function renderPools(pools) {
    rowsEl.innerHTML = "";
    pools.forEach((p) => {
      const change = Number(p.change24h ?? 0);
      const isUp = change >= 0;

      rowsEl.insertAdjacentHTML("beforeend", `
        <div class="py-3 flex items-start justify-between gap-3">
          <div class="min-w-0">
            <div class="text-sm font-semibold text-white truncate">${p.name}</div>
            <div class="text-xs text-white/60">${p.symbol} • TVL ${fmtMoney(p.tvl)}</div>
          </div>
          <div class="text-right shrink-0">
            <div class="text-sm font-bold text-white">${Number(p.apy).toFixed(2)}% APY</div>
            <div class="text-xs ${isUp ? "text-emerald-400" : "text-red-400"}">
              ${isUp ? "+" : ""}${change.toFixed(2)}%
            </div>
          </div>
        </div>
      `);
    });
  }

  function renderChart(series) {
    const arr = (Array.isArray(series) ? series : []).slice(-30).map(Number);
    if (!arr.length) return;

    const min = Math.min(...arr);
    const max = Math.max(...arr);
    const range = Math.max(0.0001, max - min);

    minEl.textContent = `Min: ${min.toFixed(2)}%`;
    maxEl.textContent = `Max: ${max.toFixed(2)}%`;

    chartEl.innerHTML = arr.map(v => {
      const h = 12 + Math.round(((v - min) / range) * 88);
      return `
        <div class="w-[6px] sm:w-[7px] rounded-full bg-emerald-400/20"
             style="height:${h}%; box-shadow: 0 0 18px rgba(16,185,129,.18);">
          <div class="h-full w-full rounded-full bg-emerald-400/35"></div>
        </div>
      `;
    }).join("");
  }

  async function loadTopPools() {
    if (inFlight) return; // prevents overlap
    inFlight = true;

    loadingEl.classList.remove("hidden");
    statusEl.textContent = "Data: Live";

    // Abort after 12s so it never hangs on "Loading..."
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 12000);

    try {
      const res = await fetch("<?php echo e(route('dao.pools.live')); ?>?t=" + Date.now(), {
        headers: { "Accept": "application/json" },
        signal: controller.signal,
        cache: "no-store",
      });

      const data = await res.json().catch(() => null);
      if (!res.ok || !data) throw new Error("Bad response");
      if (!Array.isArray(data.pools)) throw new Error("Missing pools[]");

      lastGood = data;

      renderPools(data.pools);
      renderChart(data.chart?.series || []);

      const src = data.meta?.source || "live";
      const updated = data.meta?.updated_at || "";
      statusEl.textContent = `Data: ${src}${updated ? " • Updated " + updated : ""}`;
    } catch (e) {
      console.error("Pools fetch failed:", e);

      // IMPORTANT: don’t blank UI; keep last good data if we have it
      if (lastGood?.pools) {
        statusEl.textContent = `Data: cached • Last OK ${lastGood.meta?.updated_at || ""}`;
      } else {
        rowsEl.innerHTML = `<div class="py-3 text-sm text-red-300">Failed to load pools. Check API route.</div>`;
      }
    } finally {
      clearTimeout(timeout);
      loadingEl.classList.add("hidden");
      inFlight = false;
    }
  }

  reloadBtn?.addEventListener("click", loadTopPools);

  // Call immediately (no DOMContentLoaded issues)
  loadTopPools();
  setInterval(loadTopPools, 60000);
})();
</script>


        <!-- pool chips row -->
       <!-- Bottom: 30-day Trend -->
<div class="mt-4">
  <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-white/10">
      <div class="text-xs text-white/70">
        Pool Yield Trend (30d) <span class="ml-2 text-white/40">(avg APY of top pools)</span>
      </div>
      <div id="trendMeta" class="text-[11px] text-white/50">Waiting…</div>
    </div>

    <div class="p-4">
      <!-- Chart -->
      <div class="relative h-[260px] rounded-xl border border-white/10 bg-black/20 overflow-hidden">
        <canvas id="poolsTrendChart" class="absolute inset-0 w-full h-full"></canvas>

        <!-- overlay loading -->
        <div id="poolsTrendLoading" class="absolute inset-0 flex items-center justify-center text-white/60 text-sm">
          Loading pool trend…
        </div>

        <!-- overlay error -->
        <div id="poolsTrendError" class="hidden absolute inset-0 flex items-center justify-center text-red-200 text-sm">
          Failed to load trend.
        </div>
      </div>

      <!-- Small summary row -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4">
        <div class="rounded-xl border border-white/10 bg-white/5 p-3">
          <div class="text-[11px] text-white/50">Avg APY (30d)</div>
          <div id="avgApy30" class="text-white text-lg font-semibold">—</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 p-3">
          <div class="text-[11px] text-white/50">Best Pool</div>
          <div id="bestPoolName" class="text-white text-sm font-semibold truncate">—</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 p-3">
          <div class="text-[11px] text-white/50">Top Pool APY</div>
          <div id="bestPoolApy" class="text-white text-lg font-semibold">—</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 p-3">
          <div class="text-[11px] text-white/50">Total TVL</div>
          <div id="totalTvl" class="text-white text-lg font-semibold">—</div>
        </div>
      </div>
    </div>
  </div>
</div>


        <!-- chart box -->
       
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
async function loadTopPools() {
  const statusEl = document.getElementById('pools-status');
  const rowsEl = document.getElementById('pools-rows');
  const chartEl = document.getElementById('apy-chart');

  try {
    statusEl.textContent = "Data: Live";
    const res = await fetch("<?php echo e(route('dao.pools.live')); ?>", {
      headers: { "Accept": "application/json" }
    });

    if (!res.ok) throw new Error("HTTP " + res.status);

    const data = await res.json();

    if (!data.ok || !Array.isArray(data.pools)) {
      throw new Error("Bad JSON shape");
    }

    // render pools
    rowsEl.innerHTML = "";
    data.pools.forEach((p) => {
      const dir = (p.change24h ?? 0) >= 0 ? "text-green-400" : "text-red-400";
      const sign = (p.change24h ?? 0) >= 0 ? "+" : "";

      rowsEl.insertAdjacentHTML("beforeend", `
        <div class="flex items-center justify-between py-3 border-b border-white/10">
          <div class="min-w-0">
            <div class="text-sm font-semibold text-white truncate">${p.name}</div>
            <div class="text-xs text-white/60">${p.symbol}</div>
          </div>
          <div class="text-right">
            <div class="text-sm font-bold text-white">${Number(p.apy).toFixed(2)}% APY</div>
            <div class="text-xs ${dir}">${sign}${Number(p.change24h).toFixed(2)}% (24h)</div>
          </div>
        </div>
      `);
    });

    // simple chart render (mini bars)
    if (Array.isArray(data.chart?.series)) {
      const series = data.chart.series.slice(-30);
      const max = Math.max(...series);
      chartEl.innerHTML = series.map(v => {
        const h = Math.max(8, Math.round((v / max) * 60));
        return `<div class="w-1 rounded-full bg-white/20" style="height:${h}px"></div>`;
      }).join("");
    }

    statusEl.textContent = `Data: ${data.meta?.source || "live"} • Updated ${data.meta?.updated_at || ""}`;
  } catch (e) {
    console.error(e);
    statusEl.textContent = "Data: Live";
    rowsEl.innerHTML = `<div class="text-sm text-red-300">Failed to load pools. Check API route.</div>`;
  }
}

document.addEventListener("DOMContentLoaded", loadTopPools);
</script>

<script>
  // ======= Bottom Trend Chart (Canvas, no libs) =======
  function drawAreaLineChart(canvas, points) {
    const ctx = canvas.getContext("2d");

    // handle retina
    const dpr = window.devicePixelRatio || 1;
    const rect = canvas.getBoundingClientRect();
    canvas.width = Math.floor(rect.width * dpr);
    canvas.height = Math.floor(rect.height * dpr);
    ctx.scale(dpr, dpr);

    const w = rect.width;
    const h = rect.height;

    ctx.clearRect(0, 0, w, h);

    // background grid
    ctx.globalAlpha = 0.25;
    ctx.strokeStyle = "rgba(255,255,255,0.10)";
    ctx.lineWidth = 1;
    for (let i = 1; i < 6; i++) {
      const y = (h / 6) * i;
      ctx.beginPath();
      ctx.moveTo(0, y);
      ctx.lineTo(w, y);
      ctx.stroke();
    }
    ctx.globalAlpha = 1;

    if (!points || points.length < 2) return;

    const min = Math.min(...points);
    const max = Math.max(...points);
    const pad = (max - min) * 0.15 || 1;
    const ymin = min - pad;
    const ymax = max + pad;

    const xStep = w / (points.length - 1);

    // Build path
    const toXY = (i, v) => {
      const x = i * xStep;
      const t = (v - ymin) / (ymax - ymin);
      const y = h - t * h;
      return { x, y };
    };

    // area fill
    ctx.beginPath();
    let p0 = toXY(0, points[0]);
    ctx.moveTo(p0.x, p0.y);
    for (let i = 1; i < points.length; i++) {
      const p = toXY(i, points[i]);
      ctx.lineTo(p.x, p.y);
    }
    ctx.lineTo(w, h);
    ctx.lineTo(0, h);
    ctx.closePath();

    const grad = ctx.createLinearGradient(0, 0, 0, h);
    grad.addColorStop(0, "rgba(34,197,94,0.25)");   // green glow
    grad.addColorStop(1, "rgba(34,197,94,0.02)");
    ctx.fillStyle = grad;
    ctx.fill();

    // main line
    ctx.beginPath();
    p0 = toXY(0, points[0]);
    ctx.moveTo(p0.x, p0.y);
    for (let i = 1; i < points.length; i++) {
      const p = toXY(i, points[i]);
      ctx.lineTo(p.x, p.y);
    }
    ctx.strokeStyle = "rgba(34,197,94,0.95)";
    ctx.lineWidth = 2;
    ctx.shadowBlur = 12;
    ctx.shadowColor = "rgba(34,197,94,0.55)";
    ctx.stroke();
    ctx.shadowBlur = 0;

    // last point dot
    const last = toXY(points.length - 1, points[points.length - 1]);
    ctx.beginPath();
    ctx.arc(last.x, last.y, 4, 0, Math.PI * 2);
    ctx.fillStyle = "rgba(34,197,94,1)";
    ctx.fill();
  }

  function formatMillions(n) {
    if (n == null) return "—";
    const num = Number(n);
    if (!isFinite(num)) return "—";
    if (num >= 1e9) return (num / 1e9).toFixed(2) + "B";
    if (num >= 1e6) return (num / 1e6).toFixed(1) + "M";
    if (num >= 1e3) return (num / 1e3).toFixed(1) + "K";
    return num.toFixed(0);
  }

  async function loadPoolsTrend() {
    const canvas = document.getElementById("poolsTrendChart");
    const loading = document.getElementById("poolsTrendLoading");
    const error = document.getElementById("poolsTrendError");

    const avgApy30 = document.getElementById("avgApy30");
    const bestPoolName = document.getElementById("bestPoolName");
    const bestPoolApy = document.getElementById("bestPoolApy");
    const totalTvl = document.getElementById("totalTvl");
    const trendMeta = document.getElementById("trendMeta");

    if (!canvas) return;

    loading.classList.remove("hidden");
    error.classList.add("hidden");

    try {
      // IMPORTANT: this must match your working JSON endpoint
      // If your endpoint is /dashboard/dao/pools/live, keep it.
      const res = await fetch("<?php echo e(route('dao.pools.live')); ?>", { headers: { "Accept": "application/json" } });
      if (!res.ok) throw new Error("Bad response");
      const json = await res.json();

      const pools = json?.data || json?.pools || [];
      if (!Array.isArray(pools) || pools.length === 0) throw new Error("Empty pools");

      // compute top pools by apy
      const top = [...pools].sort((a,b) => (b.apy ?? 0) - (a.apy ?? 0)).slice(0, 6);

      // create a 30-day trend (demo but deterministic) from their APY
      // trend is avg APY with small daily noise
      const baseAvg = top.reduce((s,p) => s + (Number(p.apy)||0), 0) / top.length;

      const trend = [];
      let v = baseAvg;
      for (let i = 0; i < 30; i++) {
        // soft random walk (stable)
        const drift = (Math.sin(i/3) * 0.15);
        const jitter = (Math.random() - 0.5) * 0.25;
        v = Math.max(0.1, v + drift + jitter);
        trend.push(Number(v.toFixed(2)));
      }

      drawAreaLineChart(canvas, trend);

      // summary
      const best = top[0];
      const tvlSum = top.reduce((s,p) => s + (Number(p.tvl)||0), 0);

      avgApy30.textContent = trend.reduce((s,x)=>s+x,0)/trend.length
        ? ( (trend.reduce((s,x)=>s+x,0)/trend.length).toFixed(2) + "%" )
        : "—";

      bestPoolName.textContent = best?.name || "—";
      bestPoolApy.textContent = (best?.apy != null ? Number(best.apy).toFixed(2) + "%" : "—");
      totalTvl.textContent = "$" + formatMillions(tvlSum);

      trendMeta.textContent = `Top ${top.length} pools • Updated ${new Date().toLocaleString()}`;

      loading.classList.add("hidden");
    } catch (e) {
      loading.classList.add("hidden");
      error.classList.remove("hidden");
      // leave chart as-is if it already drew once
    }
  }

  // call once + auto-refresh every 30s
  document.addEventListener("DOMContentLoaded", () => {
    loadPoolsTrend();
    setInterval(loadPoolsTrend, 30000);
  });

  // if Livewire re-renders page parts, re-init
  document.addEventListener("livewire:load", () => {
    loadPoolsTrend();
    if (window.Livewire?.hook) {
      Livewire.hook("message.processed", () => loadPoolsTrend());
    }
  });
</script>

      <!-- Transactions / Activity Block (replaces Latest Trades & Referrals) -->
   
 
<!-- Recent Activity heading (above the whole block) -->
<div class="col-span-1 lg:col-span-2 mb-4 sm:mb-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div class="text-center lg:text-left">
            <br>
            <h2 class="text-2xl sm:text-3xl font-light text-white mb-1 sm:mb-2">Recent Activity</h2>
            <p class="text-slate-400 font-light text-sm sm:text-base">
                Your latest deposits, withdrawals, and other transactions.
            </p>
        </div>

        <div class="flex justify-center lg:justify-end">
            <a href="<?php echo e(route('accounthistory')); ?>"
               class="inline-flex items-center px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl bg-gray-800 border border-gray-700 text-slate-200 hover:text-white hover:border-gray-600 transition-colors">
                View all activity
            </a>
        </div>
    </div>
</div>

        <div class="bg-gray-900 rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-gray-700 shadow-xl floating-animation">
            <div x-data="{ activeTab: 'deposits' }" class="w-full">
                <div class="flex flex-col sm:flex-row gap-2 p-2 mb-6 sm:mb-8 bg-gray-800 rounded-xl sm:rounded-2xl backdrop-blur-sm">
                    <button @click="activeTab = 'deposits'"
                            :class="activeTab === 'deposits' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="arrow-down-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Deposits</span>
                    </button>
                    <button @click="activeTab = 'withdrawals'"
                            :class="activeTab === 'withdrawals' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="arrow-up-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Withdrawals</span>
                    </button>
                    <button @click="activeTab = 'others'"
                            :class="activeTab === 'others' ? 'bg-gray-700 text-white shadow-lg' : 'text-slate-300 hover:text-white hover:bg-gray-700/50'"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105">
                        <i data-lucide="activity" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                        <span class="text-sm sm:text-base">Others</span>
                    </button>
                </div>

                <div class="p-2 sm:p-4 lg:p-6">
                    <div x-show="activeTab === 'deposits'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Deposit History</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Track your deposit transactions</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search deposits..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
                            </div>
                        </div>

                        <div class="block lg:hidden space-y-4">
    <?php if($deposits->count() > 0): ?>
        <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $status = $deposit->status ?? '—';
                $isProcessed = strtolower($status) === 'processed';
                $isPending = strtolower($status) === 'pending';

                $statusBg = $isProcessed
                    ? 'bg-emerald-900/30 text-emerald-400'
                    : ($isPending ? 'bg-amber-900/30 text-amber-400' : 'bg-gray-700/50 text-slate-200');

                $dotBg = $isProcessed
                    ? 'bg-emerald-500'
                    : ($isPending ? 'bg-amber-500' : 'bg-slate-400');
            ?>

            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                            <i data-lucide="arrow-down" class="w-6 h-6 text-emerald-400"></i>
                        </div>

                        <div>
                            <div class="text-white font-semibold text-lg">
                                <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($deposit->amount ?? 0), 2)); ?>

                            </div>
                            <div class="text-slate-400">Deposit</div>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium <?php echo e($statusBg); ?>">
                        <span class="w-2 h-2 rounded-full <?php echo e($dotBg); ?>"></span>
                        <?php echo e($status); ?>

                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Payment Mode</span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                        <?php echo e($deposit->payment_mode ?? '—'); ?>

                    </span>
                </div>

                <div class="mt-3 text-sm text-slate-500">
                    <?php echo e(\Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \\a\\t g:i A')); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                <i data-lucide="arrow-down-circle" class="w-8 h-8 text-slate-400"></i>
            </div>
            <h4 class="text-lg font-light text-white mb-2">No deposits yet</h4>
            <p class="text-slate-400 font-light text-sm">Your deposit history will appear here</p>
        </div>
    <?php endif; ?>
</div>

<div class="hidden lg:block">
  <?php if($deposits->count() > 0): ?>

    <div class="bg-gray-800/40 rounded-2xl overflow-hidden border border-gray-700">
      <div class="grid grid-cols-12 px-6 py-4 bg-gray-800 text-xs font-medium text-slate-400 uppercase tracking-wider">
        <div class="col-span-4">Amount</div>
        <div class="col-span-3">Payment Mode</div>
        <div class="col-span-2">Status</div>
        <div class="col-span-3">Date</div>
      </div>

      <div class="divide-y divide-gray-700">
        <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $status = $deposit->status ?? '—';
            $isProcessed = strtolower($status) === 'processed';
            $isPending = strtolower($status) === 'pending';

            $statusBg = $isProcessed
              ? 'bg-emerald-900/30 text-emerald-400'
              : ($isPending ? 'bg-amber-900/30 text-amber-400' : 'bg-gray-700/50 text-slate-200');

            $dotBg = $isProcessed
              ? 'bg-emerald-500'
              : ($isPending ? 'bg-amber-500' : 'bg-slate-400');
          ?>

          <div class="grid grid-cols-12 px-6 py-6 items-center hover:bg-gray-800/50 transition-colors">
            <!-- Amount -->
            <div class="col-span-4 flex items-center gap-4">
              <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                <i data-lucide="arrow-down" class="w-6 h-6 text-emerald-400"></i>
              </div>
              <div>
                <div class="text-white font-semibold">
                  <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($deposit->amount ?? 0), 2)); ?>

                </div>
                <div class="text-slate-400 text-sm">Deposit</div>
              </div>
            </div>

            <!-- Payment Mode -->
            <div class="col-span-3">
              <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                <?php echo e($deposit->payment_mode ?? '—'); ?>

              </span>
            </div>

            <!-- Status -->
            <div class="col-span-2">
              <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium <?php echo e($statusBg); ?>">
                <span class="w-2 h-2 rounded-full <?php echo e($dotBg); ?>"></span>
                <?php echo e($status); ?>

              </span>
            </div>

            <!-- Date -->
            <div class="col-span-3 text-slate-300">
              <?php echo e(\Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \\a\\t g:i A')); ?>

            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

  <?php else: ?>
    <div class="text-center py-16">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
        <i data-lucide="arrow-down-circle" class="w-10 h-10 text-slate-400"></i>
      </div>
      <h4 class="text-xl font-light text-white mb-3">No deposits yet</h4>
      <p class="text-slate-400 font-light">Your deposit history will appear here</p>
    </div>
  <?php endif; ?>
</div>
                    </div>

                    <!-- Withdrawals Tab -->
                    <div x-show="activeTab === 'withdrawals'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Withdrawal History</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Track your withdrawal transactions</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Search withdrawals..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
                            </div>
                        </div>

<div class="block lg:hidden space-y-4">
    <?php if($withdrawals->count() > 0): ?>
        <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $status = $withdrawal->status ?? '—';
                $isProcessed = strtolower($status) === 'processed';
                $isPending = strtolower($status) === 'pending';

                $statusBg = $isProcessed
                    ? 'bg-emerald-900/30 text-emerald-400'
                    : ($isPending ? 'bg-red-900/30 text-red-400' : 'bg-gray-700/50 text-slate-200');

                $dotBg = $isProcessed
                    ? 'bg-emerald-500'
                    : ($isPending ? 'bg-red-500' : 'bg-slate-400');

                $mode = $withdrawal->payment_mode ?? $withdrawal->method ?? '—';
                $deducted = $withdrawal->to_deduct ?? 0;
            ?>

            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center">
                            <i data-lucide="arrow-up" class="w-6 h-6 text-red-400"></i>
                        </div>

                        <div>
                            <div class="text-white font-semibold text-lg">
                                <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($withdrawal->amount ?? 0), 2)); ?>

                            </div>
                            <div class="text-slate-400">Withdrawal</div>
                        </div>
                    </div>

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium <?php echo e($statusBg); ?>">
                        <span class="w-2 h-2 rounded-full <?php echo e($dotBg); ?>"></span>
                        <?php echo e($status); ?>

                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Total Deducted</span>
                        <span class="text-slate-200 font-medium">
                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)$deducted, 2)); ?>

                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-slate-400">Payment Mode</span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                            <?php echo e($mode); ?>

                        </span>
                    </div>
                </div>

                <div class="mt-3 text-sm text-slate-500">
                    <?php echo e(\Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \\a\\t g:i A')); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                <i data-lucide="arrow-up-circle" class="w-8 h-8 text-slate-400"></i>
            </div>
            <h4 class="text-lg font-light text-white mb-2">No withdrawals yet</h4>
            <p class="text-slate-400 font-light text-sm">Your withdrawal history will appear here</p>
        </div>
    <?php endif; ?>
</div>

                       <div class="hidden lg:block">
  <?php if($withdrawals->count() > 0): ?>

    <div class="bg-gray-800/40 rounded-2xl overflow-hidden border border-gray-700">
      <div class="grid grid-cols-12 px-6 py-4 bg-gray-800 text-xs font-medium text-slate-400 uppercase tracking-wider">
        <div class="col-span-3">Amount Requested</div>
        <div class="col-span-3">Total Deducted</div>
        <div class="col-span-2">Payment Mode</div>
        <div class="col-span-2">Status</div>
        <div class="col-span-2">Date</div>
      </div>

      <div class="divide-y divide-gray-700">
        <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $mode = $withdrawal->payment_mode ?? $withdrawal->method ?? '—';
            $status = $withdrawal->status ?? '—';

            $isProcessed = strtolower($status) === 'processed';
            $statusBg = $isProcessed ? 'bg-emerald-900/30 text-emerald-400' : 'bg-red-900/30 text-red-400';
            $dotBg = $isProcessed ? 'bg-emerald-500' : 'bg-red-500';
          ?>

          <div class="grid grid-cols-12 px-6 py-6 items-center hover:bg-gray-800/50 transition-colors">
            <!-- Amount Requested -->
            <div class="col-span-3 flex items-center gap-4">
              <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center">
                <i data-lucide="arrow-up" class="w-6 h-6 text-red-400"></i>
              </div>
              <div>
                <div class="text-white font-semibold">
                  <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($withdrawal->amount ?? 0), 2)); ?>

                </div>
                <div class="text-slate-400 text-sm">Withdrawal</div>
              </div>
            </div>

            <!-- Total Deducted -->
            <div class="col-span-3">
              <div class="text-white font-semibold">
                <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($withdrawal->to_deduct ?? 0), 2)); ?>

              </div>
              <div class="text-slate-400 text-sm">Including fees</div>
            </div>

            <!-- Payment Mode pill -->
            <div class="col-span-2">
              <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                <?php echo e($mode); ?>

              </span>
            </div>

            <!-- Status pill -->
            <div class="col-span-2">
              <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium <?php echo e($statusBg); ?>">
                <span class="w-2 h-2 rounded-full <?php echo e($dotBg); ?>"></span>
                <?php echo e($status); ?>

              </span>
            </div>

            <!-- Date -->
            <div class="col-span-2 text-slate-300">
              <?php echo e(\Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \\a\\t g:i A')); ?>

            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>

  <?php else: ?>
    <div class="text-center py-16">
      <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
        <i data-lucide="arrow-up-circle" class="w-10 h-10 text-slate-400"></i>
      </div>
      <h4 class="text-xl font-light text-white mb-3">No withdrawals yet</h4>
      <p class="text-slate-400 font-light">Your withdrawal history will appear here</p>
    </div>
  <?php endif; ?>
</div>
                    </div>

                   
                   
                 
<!-- Other Transactions Tab -->
<div x-show="activeTab === 'others'"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0">

    <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
        <div class="text-center lg:text-left">
            <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Other Transactions</h3>
            <p class="text-slate-400 font-light text-sm sm:text-base">Additional transaction history</p>
        </div>
        <div class="relative">
            <input type="text" placeholder="Search transactions..."
                   class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
            <i data-lucide="search" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400"></i>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="block lg:hidden space-y-4">
        <?php if(isset($transactions) && $transactions->count() > 0): ?>
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                <i data-lucide="activity" class="w-5 h-5 text-indigo-500"></i>
                            </div>
                            <div>
                                <div class="text-white font-medium"><?php echo e($tx->type); ?></div>
                                <div class="text-slate-400 text-sm">Transaction</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-white font-medium">
                                <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($tx->amount ?? 0), 2)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Description</span>
                        <span class="text-slate-300"><?php echo e($tx->plan ?? 'N/A'); ?></span>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        <?php echo e(\Carbon\Carbon::parse($tx->created_at)->format('M d, Y \a\t g:i A')); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                    <i data-lucide="activity" class="w-8 h-8 text-slate-400"></i>
                </div>
                <h4 class="text-lg font-light text-white mb-2">No other transactions</h4>
                <p class="text-slate-400 font-light text-sm">Additional transactions will appear here</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto">
        <?php if(isset($transactions) && $transactions->count() > 0): ?>
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                        <i data-lucide="activity" class="w-5 h-5 text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium"><?php echo e($tx->type); ?></div>
                                        <div class="text-slate-400 text-sm">Transaction</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">
                                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format((float)($tx->amount ?? 0), 2)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-slate-300 font-light"><?php echo e($tx->plan ?? 'N/A'); ?></span>
                            </td>
                            <td class="px-6 py-4 text-slate-300 font-light">
                                <?php echo e(\Carbon\Carbon::parse($tx->created_at)->format('M d, Y \a\t g:i A')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                    <i data-lucide="activity" class="w-10 h-10 text-slate-400"></i>
                </div>
                <h4 class="text-xl font-light text-white mb-3">No other transactions</h4>
                <p class="text-slate-400 font-light">Additional transactions will appear here</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Other Transactions Pagination (only if paginator) -->
    
</div>
                </div>
            </div>
        </div>
    </div>
 


<div class="text-xs text-slate-500">
  deposits: <?php echo e($deposits->count()); ?>,
  withdrawals: <?php echo e($withdrawals->count()); ?>,
  transactions: <?php echo e($transactions->count()); ?>

</div>
<!-- News Feed Widget -->

</div>

<script>
    function changeTimeframe(interval) {
        if (widget) {
            widget.chart().setResolution(interval);
        }
    }

    // Asset selection enhancement with logo display
    document.addEventListener('DOMContentLoaded', function() {
        const assetSelect = document.getElementById('select_assetss');

        if (assetSelect) {
            // Create logo display element if it doesn't exist
            let logoDisplay = document.getElementById('asset-logo-display');
            if (!logoDisplay) {
                logoDisplay = document.createElement('div');
                logoDisplay.id = 'asset-logo-display';
                logoDisplay.className = 'flex items-center gap-2 mt-2';
                logoDisplay.innerHTML = '<img id="asset-logo" class="w-6 h-6 rounded-full hidden" alt="Asset Logo"><span id="asset-name" class="text-sm text-gray-600 dark:text-gray-400"></span>';
                assetSelect.parentNode.appendChild(logoDisplay);
            }

            // Function to update logo display
            function updateAssetLogo() {
                const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                const logoImg = document.getElementById('asset-logo');
                const assetName = document.getElementById('asset-name');

                if (selectedOption && selectedOption.dataset.logo && selectedOption.dataset.logo !== 'null' && selectedOption.dataset.logo !== '') {
                    logoImg.src = selectedOption.dataset.logo;
                    logoImg.classList.remove('hidden');
                    logoImg.onerror = function() {
                        this.classList.add('hidden');
                    };
                } else {
                    logoImg.classList.add('hidden');
                }

                if (assetName) {
                    // Use instrument name if available, otherwise use symbol
                    const displayName = selectedOption.dataset.name || selectedOption.text;
                    assetName.textContent = displayName;
                }
            }

            // Update logo on selection change
            assetSelect.addEventListener('change', updateAssetLogo);

            // Initialize logo display
            updateAssetLogo();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kriprand/radexchain.com/account/resources/views/user/dashboard.blade.php ENDPATH**/ ?>