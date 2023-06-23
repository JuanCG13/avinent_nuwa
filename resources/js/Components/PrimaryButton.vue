<script setup>
import Button from "primevue/button";

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <Button
        :type="submit"
        class="flex w-full justify-center rounded-md border border-transparent bg-primary-500 hover:!bg-neutral-500 py-2 px-4 text-sm text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-copate-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
     <slot />
    </Button>

</template>
