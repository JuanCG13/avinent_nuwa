<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css';
import Dropdown from 'primevue/dropdown';


const props = defineProps({
    workType:String,
});

const workData = reactive({
    workType: props.workType,
   
    });

</script>

<template>
    <div class="w-full bg-primary-300 border border-gray-200 mb-6 p-6">
        {{workData.workType}}
    </div>

</template>