@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-900" x-cloak>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="space-y-4 mb-6">
            <x-danger-alert />
            <x-success-alert />
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">
               Processing...
            </h1>
            <p class="text-gray-300">
                Transaction in progress! Blockchain validation is underway. <br>This may take a few minutes.
            </p>
        </div>

        <!-- Progress Steps (Step 3 active) -->
        <div class="flex items-center justify-center mb-8 sm:mb-12 overflow-x-auto pb-4">
            <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-8 min-w-max">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-blue-400 hidden sm:inline">Payment Method</span>
                </div>

                <div class="w-8 h-0.5 bg-blue-500"></div>

                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-blue-400 hidden sm:inline">Send Payment</span>
                </div>

                <div class="w-8 h-0.5 bg-green-500"></div>

                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500/20 border-2 border-green-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold text-green-300">3</span>
                    </div>
                    <span class="ml-3 text-sm font-medium text-white hidden sm:inline">Confirmation</span>
                </div>
            </div>
        </div>

        <!-- Receipt Card -->
        <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-b border-gray-800 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="receipt" class="w-6 h-6 text-blue-400"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Deposit Receipt</h2>
                            <p class="text-sm text-gray-400">Reference: DEP-{{ str_pad($deposit->id, 6, '0', STR_PAD_LEFT) }}
</span></p>
                        </div>
                    </div>

                    @php
                        $statusRaw = $deposit->status ?? 'pending';
                        $status = strtolower($statusRaw);

                        $badge = 'bg-amber-500/15 text-amber-300 border-amber-500/30';
                        $label = 'Pending';

                        if (in_array($status, ['approved','success','successful','completed','confirmed'])) {
                            $badge = 'bg-green-500/15 text-green-300 border-green-500/30';
                            $label = 'Confirmed';
                        } elseif (in_array($status, ['declined','failed','rejected','cancelled','canceled'])) {
                            $badge = 'bg-red-500/15 text-red-300 border-red-500/30';
                            $label = 'Failed / Declined';
                        }
                    @endphp

                </div>
            </div>

            <div class="p-5 sm:p-6 space-y-6">

                <!-- Amount highlight -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-xl"></div>
                    <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-5 sm:p-8 border border-gray-700">
                        <div class="text-center">
                            <div class="inline-flex items-center gap-2 text-sm text-gray-400 mb-2">
                                <i data-lucide="banknote" class="w-4 h-4"></i>
                                <span>Deposit Amount</span>
                            </div>
                            <div class="text-3xl sm:text-5xl font-bold text-white break-all">
                                {{ Auth::user()->currency }}{{ number_format((float)($deposit->amount ?? 0), 2, '.', ',') }}
                            </div>
                            <p class="text-xs sm:text-sm text-gray-400 mt-3">
                                If pending, the system will validate and credit your balance after confirmation.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-800/30 rounded-2xl p-4 border border-gray-700">
                        <p class="text-xs text-gray-400">Username</p>
                        <p class="text-sm font-semibold text-white mt-1">{{ auth()->user()->name }}</p>
                       
                    </div>

                    <div class="bg-gray-800/30 rounded-2xl p-4 border border-gray-700">
                        <p class="text-xs text-gray-400">Date & Time</p>
                        <p class="text-sm font-semibold text-white mt-1">
                            {{ \Carbon\Carbon::parse($deposit->created_at)->format('D, M d, Y h:i A') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Receipt ID: #{{ $deposit->id }}</p>
                    </div>
                </div>

                <div class="bg-gray-800/30 rounded-2xl p-4 border border-gray-700 space-y-3">
                    <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
    <span class="text-sm text-gray-500 dark:text-gray-400">
        Deposit Status:
    </span>
      <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium border {{ $badge }}">
                        <span class="w-2 h-2 rounded-full {{ str_contains($badge,'green') ? 'bg-green-400' : (str_contains($badge,'red') ? 'bg-red-400' : 'bg-amber-400') }}"></span>
                        {{ $label }}
                    </span>
</div>

                   
                </div>



 <div class="bg-gray-800/30 rounded-2xl p-4 border border-gray-700 space-y-3">
                    <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
    <span class="text-sm text-gray-500 dark:text-gray-400">
        Payment Asset:
    </span>
    <span class="text-sm font-semibold text-gray-900 dark:text-white">
        {{ $deposit->payment_mode }}
    </span>
</div>

                   
                </div>
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                    <a href="{{ route('deposits') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-gray-800 hover:bg-gray-700 text-white font-semibold transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Back to Deposits
                    </a>

                    <div class="flex gap-3">
                        <a href="{{ route('support') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                            <i data-lucide="life-buoy" class="w-4 h-4"></i>
                            Support
                        </a>

                       
                    </div>
                </div>

                <p class="text-center text-xs text-gray-500">
                    This receipt confirms your deposit request was recorded on the platform.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) lucide.createIcons();
    });
</script>

@endsection
