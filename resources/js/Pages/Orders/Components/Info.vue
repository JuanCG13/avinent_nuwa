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

const emit = defineEmits(['updateData'])

const handleChange = (event) => {
  emit('updateData', {orderHeader:orderHeader})
}

const orderHeader = reactive({ 
    refPacient: '', 
    telContacte: '', 
    persContacte: '', 
    idComanda: '',
    refPacient: '',
    idAdrecaEnviament: '',
    AdrecaFacturacio: '',
    persContacte: '',
    telfContacte: '',
    dataPrevista: '',
    dataCreacio: '',
    dataModificacio: '',
    });

const props = defineProps({
    orderHeader: Object,
    idComanda: Number,
    refPacient: String,
    idAdrecaEnviament: String,
    AdrecaFacturacio: String,
    persContacte: String,
    telfContacte: String,
    dataPrevista: String,
    dataCreacio: Date,
    dataModificacio: Date,
});


const phoneOptions = {
        mode: "international",
       // defaultCountry: "ES",
        required: true,
        enabledCountryCode: true,
        enabledFlags: true,
        //onlyCountries: ["ES", "PT","AD"],
        invalidMsg: 'Caca',
        styleClasses: "w-full mt-1 py-1 focus:!border-primary-500 focus:!ring-primary-500 dark:border-gray-300 bg-white rounded-sm shadow-sm",
        inputOptions: {
            styleClasses: "",
            autocomplete: "on",
            name: "phone",
            placeholder: ""
            }
        };

</script>

<template>

    <div class="bg-gray-200 w-full h-full border border-gray-300 p-6">
        <h2 class="font-bold text-gray-600">Información general</h2>

        <div class="mt-8">
            <InputLabel for="refPacient" value="Referencia del paciente" />
            <TextInput
                id="refPacient"
                v-model="orderHeader.refPacient"
                ref="refPacientInput"
                type="text"
                class="mt-1 block w-full"
                @input="handleChange"
            />
            <InputError class="mt-2" />
        </div>


        <div class="mt-4">
            <InputLabel for="persContacte" value="Persona de contacto" />
            <TextInput
                id="persContacte"
                v-model="orderHeader.persContacte"
                ref="persContacteInput"
                type="text"
                class="mt-1 block w-full"
                @input="handleChange"
            />
            <InputError class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="telfContacte" value="Teléfono de contacto" />
            <VueTelInput 
            id="telfContacte" 
            v-model="orderHeader.telfContacte" 
            v-bind="phoneOptions" 
            @validate="phoneValidated"
            @input="handleChange"
            />
            <InputError class="mt-2" />
        </div>


        <div class="mt-4">
            <InputLabel for="persContacte" value="Dirección de facturación" />
            <Dropdown class="w-full" optionLabel="label" optionValue="value" placeholder="Selecciona el tipus">
                    <template #option="slotProps">
                        <span>{{slotProps.option.label}}</span>
                    </template>
                </Dropdown>
            <InputError class="mt-2" />
        </div>

        <div class="mt-4">
            <InputLabel for="persContacte" value="Dirección de envío" />
            <Dropdown class="w-full" optionLabel="label" optionValue="value" placeholder="Selecciona el tipus">
                    <template #option="slotProps">
                        <span>{{slotProps.option.label}}</span>
                    </template>
                </Dropdown>
            <InputError class="mt-2" />
        </div>

        <div class="mt-12 gap-6 flex justify-center">
            <AltButton @click="$emit('saveOrder', {orderHeader:orderHeader})" class="w-1/2">{{$t('msg.save')}}</AltButton>
            <Button @click="$emit('addOrder')" class="w-1/2" :disabled="$page.props.auth.user.estat==0">Enviar pedido</Button>
        </div>
      
    </div>

</template>