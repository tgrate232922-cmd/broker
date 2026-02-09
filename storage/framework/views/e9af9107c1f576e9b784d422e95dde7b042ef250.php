<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<?php echo \Livewire\Livewire::styles(); ?>


<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" x-data="{ activeTab: 'per' }">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your account details and security preferences</p>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Alert Messages -->
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.error-alert','data' => []]); ?>
<?php $component->withName('error-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <!-- Breadcrumbs -->
        <nav class="flex mb-6 mt-2" aria-label="Breadcrumb ">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Profile</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 overflow-hidden">
            <!-- Profile Header with Avatar -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-12 relative">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>

                <div class="flex flex-col items-center relative z-10">
                    
                    <div class="relative group" x-data="{
    previewUrl: null,
    fileSelected: false,
    submit() {
        if (!this.fileSelected) return;
        this.$refs.form.submit();
    },
    onFileChange(e) {
        const file = e.target.files?.[0];
        if (!file) return;
        this.previewUrl = URL.createObjectURL(file);
        this.fileSelected = true;
    }
}">
<?php
    $nameParts = explode(' ', trim(Auth::user()->name));
    $first = strtoupper(substr($nameParts[0], 0, 1));
    $last  = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '';
    $initials = $first . $last;

    // Stable gradient selection
    $gradients = [
        'from-blue-500 to-indigo-600',
        'from-emerald-500 to-teal-600',
        'from-purple-500 to-pink-600',
        'from-orange-500 to-red-600',
        'from-cyan-500 to-sky-600',
        'from-violet-500 to-fuchsia-600',
    ];

    $hash = crc32(Auth::user()->email ?? Auth::user()->id);
    $gradient = $gradients[$hash % count($gradients)];
?>

<div class="w-24 h-24 rounded-full flex items-center justify-center
            bg-gradient-to-br <?php echo e($gradient); ?>

            shadow-xl ring-4 ring-white/20 hover:shadow-2xl transition-all duration-300
">
    <span class="text-3xl font-bold text-white tracking-wide">
        <?php echo e($initials); ?>

    </span>
</div>


                        <!-- Camera Icon -->
                     
                        <!-- ONE Upload Form (important) -->
                 
                    </div>

                    <!-- User Info -->
                    <h2 class="text-xl font-bold text-white mt-4"><?php echo e(Auth::user()->name); ?></h2>
                    <p class="text-blue-100"><?php echo e(Auth::user()->email); ?></p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-700 dark:border-gray-600">
                <div class="flex px-6">
                    <button
                        @click="activeTab = 'per'"
                        :class="{
                            'border-b-2 border-blue-500': activeTab === 'per',
                            'text-blue-600 dark:text-blue-400': activeTab === 'per',
                            'text-gray-300 dark:text-gray-400': activeTab !== 'per'
                        }"
                        class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors"
                    >
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span>Personal Information</span>
                    </button>

                    <button
                        @click="activeTab = 'pas'"
                        :class="{
                            'border-b-2 border-blue-500': activeTab === 'pas',
                            'text-blue-600 dark:text-blue-400': activeTab === 'pas',
                            'text-gray-300 dark:text-gray-400': activeTab !== 'pas'
                        }"
                        class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors"
                    >
                        <i data-lucide="lock" class="w-5 h-5"></i>
                        <span>Security</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <div
                    x-show="activeTab === 'per'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                >
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="info" class="h-5 w-5 text-blue-500" aria-hidden="true"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-400">
                                    Your personal information helps us personalize your experience. Please ensure all details are accurate and up-to-date.
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php echo $__env->make('profile.update-profile-information-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div
                    x-show="activeTab === 'pas'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    style="display: none;"
                >
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="shield" class="h-5 w-5 text-indigo-500" aria-hidden="true"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700 dark:text-indigo-400">
                                    Strong passwords help protect your account. Use a unique password that includes numbers, letters, and special characters.
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php echo $__env->make('profile.update-password-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/homefor1/scalpchain.com/account/resources/views/user/profile.blade.php ENDPATH**/ ?>