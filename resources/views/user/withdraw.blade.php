@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10"
     x-data="{ showConfirmModal: false, amount: '' }">

    <div class="max-w-5xl mx-auto px-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Withdraw Funds</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Secure and fast withdrawal processing
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5
                      bg-gray-200 hover:bg-gray-300
                      dark:bg-gray-700 dark:hover:bg-gray-600
                      text-gray-700 dark:text-gray-300
                      rounded-lg text-sm font-medium transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back
            </a>
        </div>

        <!-- Alerts -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Withdrawal Card -->
        <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-xl max-w-3xl mx-auto">

            <!-- Card Header -->
            <div class="p-6 border-b border-gray-700 flex items-center gap-4">
                <div class="p-3 rounded-full bg-blue-500/20">
                    <i data-lucide="wallet" class="w-6 h-6 text-blue-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">
                        {{ $payment_mode }} Withdrawal
                    </h3>
                    <p class="text-sm text-gray-400">
                        Complete your withdrawal request
                    </p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST"
                  action="{{ route('completewithdrawal') }}"
                  id="withdrawalForm"
                  class="p-6 space-y-6">
                @csrf

                <input type="hidden" name="method" value="{{ $payment_mode }}">

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Withdrawal Amount ({{ Auth::user()->currency }})
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-400 text-sm">
                            {{ $settings->currency }}
                        </span>
                        <input type="number"
                               name="amount"
                               required
                               min="1"
                               x-model="amount"
                               class="pl-10 w-full rounded-xl bg-gray-800 border border-gray-600
                                      text-white py-3 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        Available balance:
                        {{ Auth::user()->currency }}
                        {{ number_format(Auth::user()->account_bal, 2) }}
                    </p>
                </div>

                <!-- Wallet / Bank Details -->
                @if($payment_mode === 'Bank Transfer')
                    <div class="bg-gray-800 rounded-xl p-4 space-y-4">
                        <h4 class="text-white font-medium">Bank Details</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <input name="bank_name" placeholder="Bank Name" class="input-dark">
                            <input name="account_name" placeholder="Account Name" class="input-dark">
                            <input name="account_no" placeholder="Account Number" class="input-dark">
                            <input name="swiftcode" placeholder="Swift Code" class="input-dark">
                        </div>
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            {{ $payment_mode }} Wallet Address
                        </label>
                        <input name="details"
                               required
                               placeholder="Enter wallet address"
                               class="w-full rounded-xl bg-gray-800 border border-gray-600
                                      text-white py-3 px-4 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-400 mt-2">
                            Please double-check address before submitting
                        </p>
                    </div>
                @endif

                <!-- Submit -->
                <button type="button"
                        @click="showConfirmModal = true"
                        class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                               text-white font-medium transition flex items-center justify-center gap-2">
                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                    Continue
                </button>
            </form>
        </div>

        <!-- Info Card -->
        <div class="max-w-3xl mx-auto mt-6 bg-gray-900 border border-gray-700 rounded-xl p-6">
            <h4 class="text-white font-semibold mb-3 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-blue-400"></i>
                Withdrawal Notes
            </h4>
            <ul class="space-y-2 text-sm text-gray-300">
                <li>• Processing time: up to 24 hours</li>
                <li>• Minimum withdrawal: {{ Auth::user()->currency }}50</li>
                <li>• Flat withdrawal fee: {{ Auth::user()->currency }}5</li>
            </ul>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showConfirmModal"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">

        <div class="bg-gray-900 rounded-2xl p-6 max-w-md w-full text-center">
            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-blue-500/20">
                <i data-lucide="alert-circle" class="w-8 h-8 text-blue-400"></i>
            </div>

            <h3 class="text-xl font-semibold text-white mb-2">
                Confirm Withdrawal
            </h3>

            <p class="text-gray-400 mb-6">
                Withdraw {{ Auth::user()->currency }}<span x-text="amount"></span>
                via {{ $payment_mode }}?
            </p>

            <div class="flex gap-4 justify-center">
                <button @click="showConfirmModal = false"
                        class="px-4 py-2 bg-gray-700 rounded-lg text-gray-300">
                    Cancel
                </button>

                <button
                    @click="
                        showConfirmModal = false;
                        document.getElementById('withdrawalForm').submit();
                    "
                    class="px-4 py-2 bg-blue-600 rounded-lg text-white">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
