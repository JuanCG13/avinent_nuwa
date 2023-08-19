<script setup>
import { ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import InputMask from 'primevue/inputmask';

const toast = useToast();

const form = useForm({
    idClientX3: '',
    cif: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    customer_type: 'A',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>
<template>

    <Toast/>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="customercode" :value="$t('Código de cliente')" />
            <InputMask
                mask="aa99999" 
                placeholder="LB999999"
                id="customercode"
                type="text"
                v-model="form.idClientX3"
                class="mt-1 block w-full text-sm uppercase"
                required
                autofocus
                name="idClientX3"
            />
            <InputError class="mt-2" :message="form.errors.idClientX3" />
        </div>

        <div class="mt-4">
            <InputLabel for="nif" :value="$t('NIF')" />
            <TextInput
                id="nif"
                v-model="form.cif"
                type="text"
                class="mt-1 block w-full text-sm"
                required
            />
            <InputError class="mt-2" :message="form.errors.cif" />
        </div>

        <div class="break-after-column  mt-4">
            <InputLabel for="email" :value="$t('Email')" />
            <TextInput
                id="email"
                v-model="form.email"
                type="email"
                class="mt-1 block w-full text-sm"
                required
                autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>



        <div>
            <InputLabel for="password" :value="$t('Contraseña')" />
            <TextInput
                id="password"
                v-model="form.password"
                type="password"
                class="mt-1 block w-full text-sm"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" :value="$t('Confirmar contraseña')" />
            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                class="mt-1 block w-full text-sm"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
            <InputLabel for="terms">
                <div class="flex items-center">
                    <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                    <div class="ml-2">
                        I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.terms" />
            </InputLabel>
        </div>

        <div class="flex items-center mt-4">
            <!-- <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
            </Link> -->
    
        </div>

        <div class="flex items-center mt-4">
            <Button class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{$t('Registrarme')}}
            </Button>
        </div>
    
    </form>
</template>