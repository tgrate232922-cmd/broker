@php
      $captcha = strtoupper(substr(md5(rand()), 0, 6)); // Generate random text
@endphp
@extends('layouts.guest1')
@section('title', 'Create Account')
@section('content')


<div class="min-h-screen bg-gray-900 relative overflow-hidden py-8 sm:py-12">
    <div class="relative z-10 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">
          
            <div class="bg-gray-900 border border-gray-700 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-10 shadow-2xl"
                x-data="registrationForm({{ json_encode($errors->toArray()) }})" x-cloak>

          
                <div class="text-center mb-8">
                    
                    <div class="flex items-center justify-center mb-6">
                        <img src="{{ asset('storage/app/public/'.$settings->logo)}}"
                             class="h-12 sm:h-16 w-auto"
                             alt="{{ $settings->site_name }}" />
                    </div>

                  
                    <p class="text-gray-300 text-sm sm:text-base lg:text-lg mb-6">
    Begin your decentralized staking journey
</p>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 text-xs sm:text-sm">

    <div class="text-center p-3 bg-gray-800/50 rounded-xl border border-gray-700/50">
        <div class="flex items-center justify-center gap-1 text-cyan-400 mb-1">
            <i data-lucide="users" class="w-3 h-3"></i>
            <span class="font-semibold">1M+ Members</span>
        </div>
        <div class="text-gray-400">DAO Community</div>
    </div>

</div>

                </div>

           
                <div class="mb-8">
                    <div class="flex items-center justify-between sm:justify-center sm:space-x-8">
                        <template x-for="(step, index) in steps" :key="index">
                            <div class="flex flex-col items-center">
                            
                                <div class="relative mb-2">
                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full text-xs sm:text-sm font-bold transition-all duration-300"
                                         :class="currentStep > index ? 'bg-green-500 text-white' :
                                                currentStep === index ? 'bg-blue-500 text-white' :
                                                'bg-gray-700 text-gray-400'">
                                        <span x-show="currentStep <= index" x-text="index + 1"></span>
                                        <i x-show="currentStep > index" data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                                    </div>
                                  
                                    <div x-show="currentStep === index"
                                         class="absolute inset-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-500 animate-ping opacity-20"></div>
                                </div>

                           
                                <div class="text-center">
                                    <div class="text-xs sm:text-sm font-medium transition-colors duration-300"
                                         :class="currentStep >= index ? 'text-white' : 'text-gray-500'"
                                         x-text="step.title"></div>
                                    <div class="text-xs text-gray-500 hidden sm:block" x-text="step.description"></div>
                                </div>

                               
                                <div x-show="index < steps.length - 1"
                                     class="hidden sm:block absolute top-4 left-1/2 w-16 h-0.5 transition-colors duration-300"
                                     :class="currentStep > index ? 'bg-green-500' : 'bg-gray-700'"
                                     style="transform: translateX(2rem);"></div>
                            </div>
                        </template>
                    </div>
                </div>

        
                @if ($errors->any())
                    <div id="error-summary" class="mb-4 p-4 rounded-xl bg-red-900 border border-red-700 text-red-200 font-bold text-center">
                        <i data-lucide="alert-triangle" class="inline w-5 h-5 mr-2 align-middle"></i>
                        Please correct the highlighted errors below to continue.
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-6" id="register" x-cloak>
                    @csrf

          
                    <div x-show="currentStep === 0"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0">

                        <div class="mb-6 p-4 bg-blue-500/10 rounded-xl border border-blue-500/20">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <i data-lucide="user-circle" class="w-5 h-5 text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-white">Personal Information</h3>
<p class="text-gray-400 text-sm">Configure your DAO participation profile</p>

                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            
                            <div class="space-y-2">
                                <label for="username" class="block text-sm font-bold text-gray-200">
                                   Username <span class="text-red-400">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                        <i data-lucide="user" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                    </div>
                                     <input type="text" name="username" id="username" required
    value="{{ old('username') }}"
    class="block w-full rounded-xl border @error('username') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
    placeholder="Choose username">
                                </div>
                                @error('username')
                                    <p class="text-sm text-red-400 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-gray-200">
                                    Full Name <span class="text-red-400">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                        <i data-lucide="user-check" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                    </div>
                                    <!-- Name -->
<input type="text" name="name" id="name" required
    value="{{ old('name') }}"
    class="block w-full rounded-xl border @error('name') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
    placeholder="Enter full name">
                                </div>
                                @error('name')
                                    <p class="text-sm text-red-400 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-bold text-gray-200">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                        <i data-lucide="mail" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                    </div>
                                    <!-- Email -->
<input type="email" name="email" id="email" required
    value="{{ old('email') }}"
    class="block w-full rounded-xl border @error('email') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
    placeholder="your.email@example.com">
                                </div>
                                @error('email')
                                    <p class="text-sm text-red-400 flex items-center gap-1">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                      
                   <!-- Phone Field -->
<div class="space-y-2">
    <label for="phone" class="block text-sm font-bold text-gray-200">
        Phone Number <span class="text-red-400">*</span>
    </label>
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
            <i data-lucide="phone" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
        </div>
       <!-- Phone -->
<input type="tel" name="phone" id="phone" required
    value="{{ old('phone') }}"
    class="block w-full rounded-xl border @error('phone') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
    placeholder=""
    pattern="[0-9+()-]+"
    title="Please enter a valid phone number (numbers, +, ( ), - only)"
    inputmode="tel"
    oninput="this.value = this.value.replace(/[^0-9+()-]/g, '')">`
    </div>
    @error('phone')
        <p class="text-sm text-red-400 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
        </p>
    @enderror
    <p class="text-xs text-gray-400 flex items-center gap-1">
        <i data-lucide="info" class="w-3 h-3"></i>
        Format: +1 (555) 123-4567 or +44-20-1234-5678
    </p>
</div>
                        </div>
                    </div>

            
                <div x-show="currentStep === 1"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0">

               
                    <div class="mb-6 p-4 bg-purple-500/10 rounded-xl border border-purple-500/20">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-500/20 rounded-lg">
                                <i data-lucide="globe-2" class="w-5 h-5 text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-white">Location</h3>
<p class="text-gray-400 text-sm">Set your regional preferences</p>

                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 sm:gap-6">
                        
                        <div class="space-y-2">
                            <label for="country" class="block text-sm font-bold text-gray-200">
                                Country <span class="text-red-400">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 z-10">
                                    <i data-lucide="flag" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                </div>
                             <select name="country" id="country" required
    class="block w-full rounded-xl border @error('country') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-8 py-4 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold appearance-none">
    <option value="" disabled {{ old('country') ? '' : 'selected' }} class="text-gray-400">Select your country</option>
    @include('auth.countries')
</select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="space-y-2">
                            <label for="select_c" class="block text-sm font-bold text-gray-200">
                                Preferred Currency <span class="text-red-400">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 z-10">
                                    <i data-lucide="banknote" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                </div>
                                <input name="s_currency" value="{{ $settings->s_currency }}" id="s_c" type="hidden">
                                <select name="currency" id="select_c" onchange="changecurr()" required
                                        class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-8 py-4 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold appearance-none">
                                    <option selected disabled class="text-gray-400">Select trading currency</option>
                                    @foreach ($currencies as $key => $currency)
                                        <option id="{{ $key }}" value="<?php echo html_entity_decode($currency); ?>" class="text-white bg-gray-900">
                                            {{ $key . ' (' . html_entity_decode($currency) . ')' }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400"></i>
                                </div>
                            </div>
                        </div> --}}
                    </div>

            
                    <div class="mt-6 p-4 bg-blue-500/10 rounded-xl border border-blue-500/20">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0"></i>
                            <div class="text-sm">
<p class="text-blue-300 font-bold mb-1">Regional Information</p>
<p class="text-gray-300">
Your location helps us tailor platform features, compliance requirements, and regional settings.
</p>

                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="currentStep === 2"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0">

                    <div class="mb-6 p-4 bg-green-500/10 rounded-xl border border-green-500/20">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-500/20 rounded-lg">
                                <i data-lucide="shield-check" class="w-5 h-5 text-green-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-white">Account Security</h3>
                                <p class="text-gray-400 text-sm">Secure your trading account</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                 
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-bold text-gray-200">
                                Password <span class="text-red-400">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="lock" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                </div>
                                    <input type="password" name="password" id="password" required
                                        class="block w-full rounded-xl border @error('password') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                                        placeholder="Create strong password">
                            </div>
                            @error('password')
                                <p class="text-sm text-red-400 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-200">
                                Confirm Password <span class="text-red-400">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="key" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="block w-full rounded-xl border @error('password_confirmation') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                                        placeholder="Confirm your password">
                            </div>
                        </div>
                    </div>

             
                    <div class="space-y-4 mt-6">
                        <div class="space-y-2">
                            <label for="captcha" class="block text-sm font-bold text-gray-200">
                                Security Verification <span class="text-red-400">*</span>
                            </label>

                      
                            <div class="bg-gray-800 border border-gray-600 rounded-xl p-4 mb-3">
                                <div class="flex items-center justify-center">
                                    <div class="bg-gradient-to-r from-blue-900 to-purple-900 rounded-lg p-4 border border-gray-600">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-300 mb-2 font-medium">Enter the code below:</p>
                                            <div class="bg-gray-900 rounded-lg px-6 py-3 border border-gray-700">
                                                <span class="text-2xl font-bold text-yellow-400 tracking-[0.3em] select-none"
                                                      style="font-family: 'Courier New', monospace; transform: rotate(-1deg); display: inline-block;">
                                                    {{ $captcha }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="shield-check" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors"></i>
                                </div>
                                    <input type="text" name="captcha" id="captcha" required
                                        class="block w-full rounded-xl border @error('captcha') border-red-500 @else border-gray-600 @enderror bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold text-center tracking-widest uppercase"
                                        placeholder="Enter the code above"
                                        autocomplete="off"
                                        maxlength="6">
                            </div>

                            @error('captcha')
                                <p class="text-sm text-red-400 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $message }}
                                </p>
                            @enderror

                            
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <i data-lucide="info" class="w-3 h-3"></i>
                                This helps us verify that you're a real person and protects against automated registrations.
                            </p>
                        </div>
                    </div>

                
                    <input type="hidden" name="captcha_confirmation" value="{{ $captcha }}">

                    @if (Session::has('ref_by'))
                        <input type="hidden" name="ref_by" value="{{ session('ref_by') }}" required>
                    @endif

                    <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700">
                        <p class="text-sm font-bold text-gray-200 mb-2">Password Requirements:</p>
                        <ul class="text-xs text-gray-300 space-y-1">
                            <li class="flex items-center gap-2">
                                <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                                At least 8 characters long
                            </li>
                            <li class="flex items-center gap-2">
                                <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                                Contains uppercase and lowercase letters
                            </li>
                            <li class="flex items-center gap-2">
                                <i data-lucide="check" class="w-3 h-3 text-green-400"></i>
                                Includes at least one number or special character
                            </li>
                        </ul>
                    </div>

              
                    <div class="mt-6 p-6 bg-blue-500/10 rounded-xl border border-blue-500/20">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center h-5 mt-1">
                                    <input type="checkbox" name="agree" id="agree" required
                                        class="h-4 w-4 rounded @error('agree') border-red-500 @else border-gray-600 @enderror bg-gray-900 text-blue-500 focus:ring-2 focus:ring-blue-400/20 transition-colors">
                            </div>
                            <div class="flex-1">
                                <label for="agree" class="text-sm font-bold text-gray-200 leading-relaxed">
                                    I agree to {{ $settings->site_name }}'s
                                    <a href="rules" target="_blank" class="text-blue-400 hover:text-blue-300 font-bold underline underline-offset-2">
                                        Terms and Conditions
                                    </a>
                                    and acknowledge that I have read and understood the
                                    <a href="#" target="_blank" class="text-blue-400 hover:text-blue-300 font-bold underline underline-offset-2">
                                        Privacy Policy
                                    </a>
                                </label>
                                <p class="text-xs text-gray-400 mt-2">
                                    By creating an account, you confirm that you are at least 18 years old and agree to receive trading updates and market insights.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="flex flex-col sm:flex-row justify-between items-center mt-10 pt-8 border-t border-gray-700 gap-4" x-cloak>
                  
                    <button type="button" @click="previousStep()"
                            x-show="currentStep > 0"
                            class="inline-flex items-center gap-2 px-6 py-3 text-gray-400 hover:text-white transition-all duration-200 rounded-xl hover:bg-gray-800/50 group">
                        <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-bold">Previous Step</span>
                    </button>

                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <span x-text="`Step ${currentStep + 1} of ${steps.length}`" class="font-bold"></span>
                    </div>

                    <button type="button" @click="nextStep()"
                            x-show="currentStep < steps.length - 1"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group">
                        <span>Continue</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>

              
                    <button type="submit" x-show="currentStep === steps.length - 1"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        <span>Create Account</span>
                        <i data-lucide="sparkles" class="w-4 h-4 group-hover:rotate-12 transition-transform"></i>
                    </button>
                </div>

            
                <div class="mt-8 text-center space-y-4">
                    <div class="flex items-center justify-center gap-6 text-sm">
                        <p class="text-gray-400">
                            Already have an account?
                            <a href="{{ route('login') }}"
                               class="font-bold text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                                Sign in here
                            </a>
                        </p>
                    </div>

                    <div class="flex items-center justify-center gap-8 py-4 text-xs text-gray-500">
                        <div class="flex items-center gap-1">
                            <i data-lucide="shield" class="w-3 h-3"></i>
                            <span>SSL Secured</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i data-lucide="lock" class="w-3 h-3"></i>
                            <span>256-bit Encryption</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i data-lucide="award" class="w-3 h-3"></i>
                            <span>Regulated Platform</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }} {{ $settings->site_name }}. All rights reserved. |
                        Licensed and regulated trading platform.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>




<style>
    .skiptranslate {
        display: none !important;
    }
    body {
        top: 0 !important;
    }
    [x-cloak] {
        display: none !important;
    }
    /* Hide stray comment text */
    body::after {
        content: none !important;
    }
</style>


    <script>
    // Auto-scroll to first error field if errors exist
    document.addEventListener('DOMContentLoaded', function() {
        var errorFields = [
            'username', 'name', 'email', 'phone', 'country', 'password', 'password_confirmation', 'captcha', 'agree'
        ];
        @if ($errors->any())
            setTimeout(function() {
                // Try to scroll to the first field with error
                for (var i = 0; i < errorFields.length; i++) {
                    var field = document.getElementById(errorFields[i]);
                    if (field && field.classList.contains('border-red-500')) {
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        field.focus();
                        break;
                    }
                }
                // Also scroll to error summary if present
                var summary = document.getElementById('error-summary');
                if (summary) {
                    summary.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 300);
        @endif
    });

    function registrationForm(errors = {}) {
        // Determine which step has errors
        let errorStep = 0;
        if (errors && Object.keys(errors).length > 0) {
            // Map error fields to steps
            const stepFields = [
                ['username', 'name', 'email', 'phone'],
                ['country'],
                ['password', 'password_confirmation', 'captcha', 'agree']
            ];
            for (let i = 0; i < stepFields.length; i++) {
                if (stepFields[i].some(f => Object.keys(errors).includes(f))) {
                    errorStep = i;
                    break;
                }
            }
        }

        return {
            currentStep: errorStep,
            isSubmitting: false, // Track submission state
            steps: [
                {
                    title: 'Personal Info',
                    description: 'Basic details',
                    completed: false
                },
                {
                    title: 'Location',
                    description: 'Regional settings',
                    completed: false
                },
                {
                    title: 'Security',
                    description: 'Account protection',
                    completed: false
                }
            ],

            nextStep() {
                if (this.validateCurrentStep()) {
                    this.steps[this.currentStep].completed = true;
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                        this.scrollToTop();
                    }
                }
            },

            previousStep() {
                if (this.currentStep > 0) {
                    this.currentStep--;
                    this.scrollToTop();
                }
            },

            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            validateCurrentStep() {
                const step = this.currentStep;
                let isValid = true;
                let missingFields = [];

                if (step === 0) {
                    // Validate personal information
                    const fields = [
                        { id: 'username', name: 'Username' },
                        { id: 'name', name: 'Full Name' },
                        { id: 'email', name: 'Email' },
                        { id: 'phone', name: 'Phone Number' }
                    ];

                    fields.forEach(field => {
                        const value = document.getElementById(field.id).value.trim();
                        if (!value) {
                            missingFields.push(field.name);
                            isValid = false;
                        }
                    });

                    // Email validation
                    const email = document.getElementById('email').value.trim();
                    if (email && !email.includes('@')) {
                        missingFields.push('Valid Email');
                        isValid = false;
                    }

                    // Phone validation
                    const phone = document.getElementById('phone').value.trim();
                    if (phone && !/^[0-9+()-]+$/.test(phone)) {
                        missingFields.push('Valid Phone Number (only numbers and + ( ) - allowed)');
                        isValid = false;
                    }

                } else if (step === 1) {
                    // Validate location
                    const country = document.getElementById('country').value;

                    if (!country || country === 'Select your country') {
                        missingFields.push('Country');
                        isValid = false;
                    }

                } else if (step === 2) {
                    // Validate security
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;
                    const captcha = document.getElementById('captcha').value.trim();
                    const agree = document.getElementById('agree').checked;

                    if (!password) {
                        missingFields.push('Password');
                        isValid = false;
                    } else if (password.length < 8) {
                        missingFields.push('Password (minimum 8 characters)');
                        isValid = false;
                    }

                    if (!confirmPassword) {
                        missingFields.push('Password Confirmation');
                        isValid = false;
                    } else if (password !== confirmPassword) {
                        missingFields.push('Matching Passwords');
                        isValid = false;
                    }

                    if (!captcha) {
                        missingFields.push('Security Verification Code');
                        isValid = false;
                    } else if (captcha.length !== 6) {
                        missingFields.push('Complete Security Code (6 characters)');
                        isValid = false;
                    }

                    if (!agree) {
                        missingFields.push('Terms Agreement');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    const message = missingFields.length === 1
                        ? `Please provide: ${missingFields[0]}`
                        : `Please provide: ${missingFields.join(', ')}`;

                    // Show professional alert
                    this.showAlert('Incomplete Information', message, 'warning');
                }

                return isValid;
            },

            showAlert(title, message, type = 'info') {
                // Simple alert fallback if SweetAlert2 is not available
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: type,
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#3B82F6'
                    });
                } else {
                    alert(`${title}: ${message}`);
                }
            }
        }
    }

    // Enhanced initialization with better error handling
    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }, 100);
    });

    document.addEventListener('alpine:updated', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Form submission enhancement - FIXED VERSION
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('register');
        if (form) {
            let isSubmitting = false;

            form.addEventListener('submit', function(e) {
                // Prevent double submission
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }

                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    isSubmitting = true;
                    submitBtn.disabled = true;
                    
                    // Store original HTML
                    const originalHTML = submitBtn.innerHTML;
                    
                    // Change button text
                    submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin inline-block mr-2"></i>Creating Account...';
                    
                    // Re-enable after 3 seconds as a failsafe
                    setTimeout(function() {
                        if (isSubmitting) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHTML;
                            isSubmitting = false;
                            // Reinitialize lucide icons
                            if (typeof lucide !== 'undefined') {
                                lucide.createIcons();
                            }
                        }
                    }, 3000);
                }
            });
        }
    });
</script>


@endsection
