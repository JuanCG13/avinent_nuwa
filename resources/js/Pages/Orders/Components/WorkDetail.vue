<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from 'primevue/dropdown';

const emit = defineEmits(['closeDetail'])

const props = defineProps({
    workType: String,
});

</script>

<template>
    <div class="pt-12 px-6 mx-auto lg:px-0">
        <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
            Detaller linea n
        </h2>
    </div>

    <div class="mx-auto px-6 lg:px-0 gap-12 flex py-12">
        <Button class="w-1/12" @click="emit('closeDetail')">Tancar</Button>
    </div>

</template>