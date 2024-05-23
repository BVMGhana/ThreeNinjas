<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <Link href="/">
                <p class="text-white text-[32px] lg:text-[48px]">3 Ninjas Home</p>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 dark:bg-gray-600 shadow-md overflow-hidden 
            sm:rounded-lg border border-slate-400 bg-slate-900 shadow-lg backdrop-filter 
            backdrop-blur-sm bg-opacity-30 rounded-[12px]"
        >
            <slot />
        </div>
    </div>
</template>
