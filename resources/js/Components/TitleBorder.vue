<template>
    <div class="relative mt-6">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300 dark:text-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-white dark:bg-slate-800 px-2 text-gray-500 dark:text-slate-200">
                <slot name="title" />
            </span>
        </div>
    </div>
</template>