@extends('layouts.dasht')
@section('title', $title)

@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">
<div class="flex justify-center mb-6">
    <div class="premium-check">
        <svg viewBox="0 0 52 52">
            <circle class="check-circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="check-path" fill="none"
                  d="M14 27 l7 7 l17 -17"/>
        </svg>
    </div>
</div>
<style>
/* Premium Exchange Checkmark */

.premium-check {
    width: 72px;
    height: 72px;
}

.premium-check svg {
    width: 100%;
    height: 100%;
}

.check-circle {
    stroke: #22c55e;
    stroke-width: 1.8;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: circleDraw 0.6s ease-out forwards;
    opacity: 0.35;
}

.check-path {
    stroke: #22c55e;
    stroke-width: 2.6;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: checkDraw 0.35s ease-out forwards;
    animation-delay: 0.45s;
}

@keyframes circleDraw {
    to {
        stroke-dashoffset: 0;
    }
}

@keyframes checkDraw {
    to {
        stroke-dashoffset: 0;
    }
}
</style>
    <!-- Status -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full
            {{ $withdrawal->status === 'Processed'
                ? 'bg-green-500/20 text-green-400'
                : ($withdrawal->status === 'Rejected'
                    ? 'bg-red-500/20 text-red-400'
                    : 'bg-yellow-500/20 text-yellow-400') }}">
            <i data-lucide="clock" class="w-4 h-4"></i>
            <span class="text-sm font-medium">{{ ucfirst($withdrawal->status) }}</span>
        </div>

        <h1 class="mt-4 text-2xl font-semibold text-white">
            Withdrawal Request Submitted
        </h1>

        <p class="text-gray-400 mt-2">
            Your withdrawal is under review and will be processed shortly.
        </p>
    </div>

    <!-- Receipt Card -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-6">

        <!-- Amount -->
        <div class="text-center">
            <p class="text-sm text-gray-400">Amount</p>
            <p class="text-3xl font-bold text-white">
                {{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}
            </p>
        </div>

        <hr class="border-gray-800">

        <!-- Details -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-400">Method</p>
                <p class="text-white font-medium">
                    {{ $withdrawal->payment_mode }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Destination</p>
                <p class="text-white font-medium truncate">
                    {{ \Illuminate\Support\Str::limit($withdrawal->paydetails ?? 'Hidden', 18) }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Request Date</p>
                <p class="text-white font-medium">
                    {{ $withdrawal->created_at->format('M d, Y • h:i A') }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Reference ID</p>
                <p class="text-white font-medium">
                    WD-{{ str_pad($withdrawal->id, 8, '0', STR_PAD_LEFT) }}
                </p>
            </div>

        </div>

        <!-- Info -->
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-4 text-sm text-gray-300">
            <div class="flex gap-3">
                <i data-lucide="info" class="w-4 h-4 mt-0.5 text-blue-400"></i>
                <p>
                    Withdrawals are processed after verification.
                    You will be notified once completed.
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('withdrawalsdeposits') }}"
               class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3
                      bg-gray-800 hover:bg-gray-700 text-white rounded-xl transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Withdrawals
            </a>

            <a href="{{ route('dashboard') }}"
               class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-3
                      bg-gray-800 hover:bg-gray-700 text-white rounded-xl transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Dashboard
            </a>
            
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});
</script>

@endsection
