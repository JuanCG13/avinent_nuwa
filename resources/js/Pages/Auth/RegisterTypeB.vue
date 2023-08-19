<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TitleBorder from "@/Components/TitleBorder.vue";
import { VueTelInput } from 'vue3-tel-input'
import 'vue3-tel-input/dist/vue3-tel-input.css';
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const form = useForm({
    name: '',
    email: '',
    cif:'',
    raoSocial: '',
    direccio: '',
    municipi: '',
    codipostal: '',
    provincia: '',
    pais: '',
    telefon: '',
    password: '',
    password_confirmation: '',
    terms: false,
    customer_type: 'B',
});


const shipping = ref(true);

const phoneOptions = {
        mode: "international",
        defaultCountry: "ES",
        required: true,
        enabledCountryCode: true,
        enabledFlags: true,
        //onlyCountries: ["ES", "PT","AD"],
        invalidMsg: t('El teléfono no es correcto'),
        styleClasses: "w-full mt-1 py-1 border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-300 dark:bg-white rounded-sm shadow-sm",
        inputOptions: {
            styleClasses: "",
            autocomplete: "on",
            name: "phone",
            placeholder: ""
            }
        };

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};


function phoneValidated(object) {
           if (object.valid) {
             form.telefon = object.number;
           } else {
            form.telefon = '';
           }
        }
</script>

<template>
    <form @submit.prevent="submit">
        <div class="mb-4">
            <InputLabel for="name" :value="$t('Nombre')" />
            <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>


        <div class="mb-4">
            <InputLabel for="company_name" :value="$t('Empresa')" />
            <TextInput
                id="company_name"
                v-model="form.raoSocial"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_name"
            />
            <InputError class="mt-2" :message="form.errors.raoSocial" />
        </div>




        <div class="mb-4">
            <InputLabel for="company_address" :value="$t('Dirección')" />
            <TextInput
                id="company_address"
                v-model="form.direccio"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_address"
            />
            <InputError class="mt-2" :message="form.errors.direccio" />
        </div>

        <div class="mb-4">
            <InputLabel for="company_city" :value="$t('Población')" />
            <TextInput
                id="company_city"
                v-model="form.municipi"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_city"
            />
            <InputError class="mt-2" :message="form.errors.municipi" />
        </div>

        <div class="mb-4">
            <InputLabel for="company_province" :value="$t('Provincia')" />
            <TextInput
                id="company_province"
                v-model="form.provincia"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_province"
            />
            <InputError class="mt-2" :message="form.errors.provincia" />
        </div>

        <div class="">
            <InputLabel for="company_zipcode" :value="$t('Código postal')" />
            <TextInput
                id="company_zipcode"
                v-model="form.codipostal"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_zipcode"
            />
            <InputError class="mt-2" :message="form.errors.codipostal" />
        </div>

         <!-- 
        <TitleBorder>
            <template #title>Dirección de envío</template> 
        </TitleBorder>

       <div class="mt-4">
            <InputLabel for="shipping">
                <div class="flex items-center">
                    <Checkbox id="shipping" v-model:checked="shipping" name="shipping" required />

                    <div class="ml-2">
                        Usar la misma dirección que la dirección de facturación.
                    </div>
                </div>
            </InputLabel>
        </div> -->



       <!------------col2------------------------------->

       <div class="break-before-column"></div>

       <div class="mb-4">
            <InputLabel for="company_country" :value="$t('País')" />
            <TextInput
                id="company_country"
                v-model="form.pais"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_country"
            />
            <InputError class="mt-2" :message="form.errors.pais" />
        </div>

       <div class="mb-4">
            <InputLabel for="nif" :value="$t('NIF')" />
            <TextInput
                id="nif"
                v-model="form.cif"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="cif"
            />
            <InputError class="mt-2" :message="form.errors.cif" />
        </div>

        <!-- <div class="mb-4">
            <InputLabel for="company_vatnumber" :value="$t('msg.company_vatnumber')" />
            <TextInput
                id="company_vatnumber"
                v-model="form.company_vatnumber"
                type="text"
                class="mt-1 block w-full text-sm"
                required
                autofocus
                autocomplete="company_vatnumber"
            />
            <InputError class="mt-2" :message="form.errors.company_country" />
        </div> -->

       <div class="mb-4">
            <InputLabel for="company_phone" :value="$t('Teléfono')" />
            <VueTelInput id="form.company_phone" v-model="form.telefono" v-bind="phoneOptions" @validate="phoneValidated"></VueTelInput>
            <InputError class="mt-2" :message="form.errors.telefono" />
        </div>

       <div class="mb-4">
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

        <div class="mb-4">
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

        <div class="mb-4">
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
                        I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm dark:text-gray-200 text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm dark:text-gray-200 text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
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