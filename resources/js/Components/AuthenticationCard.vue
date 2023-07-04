<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-12 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>

        <div class="w-full sm:max-w-xl mt-4 ml-6">
            <slot name="footer" />
        </div>
    </div>
</template>
