<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<!-- Main Content Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Staking Pool</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title with Animation -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
               <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-2 ">Top Performing Staking Pools</h3>
                <p class="text-gray-600 dark:text-gray-300">Discover our handpicked selection of pools with proven track records.</p>
            </div>
            <!--<div class="mt-4 md:mt-0">-->
            <!--    <span class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">-->
            <!--        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
            <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />-->
            <!--        </svg>-->
            <!--        Grow Your Portfolio-->
            <!--    </span>-->
            <!--</div>-->
        </div>
    </div>

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

    <!-- Plans Grid -->
    <div x-data="{ selectedPlan: null }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Plan Card -->
           <div class="relative rounded-2xl overflow-hidden
            bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900
            border border-white/10 shadow-xl
            transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">

                
                <!-- ROI Badge -->
<!--               <div class="absolute top-4 right-4">-->
<!--    <span-->
<!--        class="relative inline-flex items-center gap-1.5-->
<!--               px-3 py-1.5 rounded-full text-xs font-semibold-->
<!--               text-blue-300-->
<!--               bg-gradient-to-br from-slate-900/80 to-slate-800/60-->
<!--               border border-blue-400/20-->
<!--               shadow-lg shadow-blue-400/20-->
<!--               backdrop-blur-md-->
<!--               overflow-hidden">-->

        <!-- subtle animated glow -->
<!--        <span class="absolute inset-0 bg-gradient-to-r-->
<!--                     from-transparent via-blue-400/10 to-transparent-->
<!--                     opacity-60"></span>-->

        <!-- icon -->
<!--        <svg class="relative w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">-->
<!--            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586l3.293-3.293A1 1 0 0112 7z" clip-rule="evenodd"/>-->
<!--        </svg>-->

        <!-- text -->
<!--        <span class="relative tracking-wide">-->
<!--            <?php echo e($plan->increment_amount); ?>% APY-->
<!--        </span>-->
<!--    </span>-->
<!--</div>-->

                
                <!-- Card Header with Gradient -->
               <div
    class="relative pt-8 px-6 pb-6 text-center
           bg-gradient-to-br from-[#0b1220] via-[#0f1a2b] to-[#0b1220]
           border-b border-blue-400/10
           shadow-inner
           overflow-hidden">

    <!-- subtle grid / glow overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(96,165,250,0.12),transparent_70%)]"></div>

    <h3 class="relative text-2xl font-semibold tracking-tight
               text-slate-100 drop-shadow-sm">
        <?php echo e($plan->name); ?>

    </h3>

    <!-- accent divider -->
    <div class="relative mt-3 flex justify-center">
        <div class="h-[2px] w-16 rounded-full
                    bg-gradient-to-r from-transparent via-[#60a5fa] to-transparent
                    opacity-70"></div>
    </div>
</div>

                
                <!-- Plan Features -->
                <div class="p-6">
                    
                   <!-- DAO Mini APY Chart (Top Pools Style) -->
<div class="relative mb-5 rounded-2xl overflow-hidden
            bg-gradient-to-br from-[#0b1220] via-[#0f1a2b] to-[#0b1220]
            border border-white/10">

    <!-- soft grid glow -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)]
                bg-[size:24px_24px] opacity-40"></div>

    <!-- emerald glow -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(16,185,129,0.18),transparent_60%)]"></div>

    <div class="relative p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-400 uppercase tracking-wide">
                APY Index (30d)
            </span>
            <span class="text-xs font-semibold text-emerald-400">
                <?php echo e($plan->increment_amount); ?>%
            </span>
        </div>

        <!-- rolling bars -->
        <div class="flex items-end gap-1 h-16">
            <?php for($i = 0; $i < 24; $i++): ?>
                <div
                    class="w-1.5 rounded-full
                           bg-gradient-to-t from-emerald-600/30 via-emerald-500/70 to-emerald-300
                           animate-[pulse_2.5s_ease-in-out_infinite]"
                    style="
                        height: <?php echo e(rand(30, 100)); ?>%;
                        animation-delay: <?php echo e($i * 90); ?>ms;
                    ">
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>


                    <ul class="space-y-4">
                        
                         <!-- Duration -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Lock Period:</span> 
                                    <span class="text-gray-900 dark:text-white"><?php echo e($plan->expiration); ?></span>
                                </p>
                            </div>
                        </li>
                        
                            <!-- ROI Details -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Estimated DAO Yield:</span>


                                    <span class="text-green-600 dark:text-green-400"><?php echo e($plan->increment_amount); ?>% </span>
                                </p>
                            </div>
                        </li>
                        
                       
                        
                        <!-- Minimum Amount -->
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">
                                <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">Min Stake:</span> 
                                    <span class="text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->min_price)); ?></span>
                                </p>
                            </div>
                        </li>
                        
                        <!-- Maximum Amount -->
                        <!--<li class="flex items-start">-->
                        <!--    <div class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3 mt-0.5">-->
                        <!--        <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                        <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>-->
                        <!--        </svg>-->
                        <!--    </div>-->
                        <!--    <div>-->
                        <!--        <p class="text-gray-700 dark:text-gray-300">-->
                        <!--            <span class="font-medium">Max Stake:</span> -->
                        <!--            <span class="text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->max_price)); ?></span>-->
                        <!--        </p>-->
                        <!--    </div>-->
                        <!--</li>-->
                        
                    
                    </ul>
                    
                    <!-- Investment Form -->
                    <form method="post" action="<?php echo e(route('joininvestmentplan')); ?>" class="mt-6">
                        <?php echo csrf_field(); ?>
                        <div x-data="{ amount: '<?php echo e($plan->min_price); ?>' }" class="space-y-4">
                            <!-- Amount Input with Animation -->
                            <div>
                                <label for="amount-<?php echo e($index); ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Stake Amount (<?php echo e(Auth::user()->currency); ?>)
                                </label>
                                
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400"><?php echo e(Auth::user()->currency); ?></span>
                                    </span>
                                    <input 
                                        type="number" 
                                        id="amount-<?php echo e($index); ?>"
                                        name="iamount" 
                                        min="<?php echo e($plan->min_price); ?>" 
                                        max="<?php echo e($plan->max_price); ?>" 
                                        x-model="amount"
                                        placeholder="Enter amount" 
                                        class="pl-8 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 transition-colors duration-200"
                                        @click="selectedPlan = <?php echo e($index); ?>"
                                    >
                                </div>
                                
                                <!-- Range Input -->
                                <div class="mt-4 px-1">
                                    <input 
                                        type="range" 
                                        min="<?php echo e($plan->min_price); ?>" 
                                        max="<?php echo e($plan->max_price); ?>" 
                                        x-model="amount"
                                        class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-600 dark:accent-blue-500"
                                    >
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>Min Stake: <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->min_price)); ?></span>
                                        <span>Max Stake: <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->max_price)); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Yield: 
                                        <span class="text-green-600 dark:text-green-400 font-medium">
                                            <?php echo e(Auth::user()->currency); ?><span x-text="(amount * <?php echo e($plan->increment_amount); ?> / 100).toFixed(2)"></span>
                                        </span>
                                        <span x-text="' ' + '<?php echo e($plan->increment_interval); ?>'"></span>
                                    </p>
                                </div>
                            </div>
                            
                            <input type="hidden" name="duration" value="<?php echo e($plan->expiration); ?>">
                            <input type="hidden" name="id" value="<?php echo e($plan->id); ?>">
                            
                       <button
    type="submit"
    class="relative w-full py-3 px-6 rounded-xl
           bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600
           text-white font-semibold
           shadow-lg shadow-blue-400/30
           transition-all duration-300
           hover:shadow-blue-400/50
           hover:scale-[1.02]
           focus:outline-none focus:ring-2 focus:ring-blue-400/40
           overflow-hidden group">

    <!-- blue glow sweep -->
    <span class="absolute inset-0 bg-gradient-to-r
                 from-transparent via-blue-300/20 to-transparent
                 translate-x-[-120%] group-hover:translate-x-[120%]
                 transition-transform duration-700"></span>

    <span class="relative flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
        </svg>
        Stake in DAO Pool
    </span>
</button>

                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State with Animation -->
            <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">No Investment Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center max-w-md mb-6">
                    Investment plans are currently being updated. Please check back later for new investment opportunities.
                </p>
                <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Dashboard
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Investment Guide Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Start Earning in 3 Simple Steps
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Choose a Pool</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Browse our curated selection of high-yield staking pools with competitive APRs and flexible lock periods.</p>
                    <br>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ Curated pools</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">+ High APRs</p>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ Flexible terms</p>
                    
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Stake Your Assets</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Securely deposit your crypto assets with enterprise-grade security and multi-signature protection.
</p>
                     <br>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ Instant deposits</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">+ Multi-sig security</p>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ No hidden fees</p>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Earn Rewards</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Watch your rewards accumulate automatically with real-time tracking and transparent calculations.</p>
     <br>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ Auto-compounding</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">+ Real-time tracking</p>
                       <p class="text-gray-600 dark:text-gray-400 text-sm">+ Daily rewards</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for No Plans -->


<!-- Alpine.js Initialization -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('plans', () => ({
            init() {
                // Any initialization code can go here
            }
        }))
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/user/mplans.blade.php ENDPATH**/ ?>