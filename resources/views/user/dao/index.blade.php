@extends('layouts.dasht')
@section('title', 'DAO Pools')
@section('content')

<x-danger-alert />
<x-success-alert />
<x-notify-alert />

<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">DAO Pools</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Stake once. Earn immediately. AI-managed pool strategies.</p>
    </div>

    @if($pools->count() === 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 text-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No DAO pools available</h3>
            <p class="text-gray-600 dark:text-gray-400">Please add pools in the database and set active = 1.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pools as $pool)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $pool->name }}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400 break-all">{{ $pool->contract_address }}</div>
                        </div>
                        <span class="px-2 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
                            Active
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">APY</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $pool->apy }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Lock</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $pool->lock_days }} days</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">TVL</span>
                            <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($pool->tvl, 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <a href="#"
                           class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                            Start AI Stake
                        </a>
                        <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            View Vault Strategy
                        </button>
                    </div>

                    @if(!empty($pool->strategy_summary))
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">{{ $pool->strategy_summary }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
