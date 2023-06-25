<script setup>

const props = defineProps({
    title: {
        type: String,
    },
    text: {
        type: String,
    },
    class: {
        type: String,
        default: () => 'mb-8 bg-gray-100 dark:bg-gray-200',
    },
});


</script>

<template>
    <div :class="class" class="border rounded-sm border-gray-300 text-gray-500 px-4 py-3">
        <p class="font-bold">{{title}}</p>
        <p class="text-sm" v-html="text"></p>
    </div>
</template>