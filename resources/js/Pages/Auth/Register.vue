<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import MessageBox from "@/Components/MessageBox.vue";
import PageLayout from "@/Layouts/PageLayout.vue";
import RadioButton from 'primevue/radiobutton'
import RegisterTypeA from "./RegisterTypeA.vue"
import RegisterTypeB from "./RegisterTypeB.vue"

const customer_type = ref('1');
</script>

<template>
    <PageLayout> 
    <Head :title="$t('Registrarme')" />
        <main>
             <MessageBox 
                :title="$t('Rellena el formulario para registrarte')" 
                :text="$t('Una vez registrado, validaremos tus datos y ya podrás acceder al portal.')"
                />
            
            <div class="flex flex-col gap-2 mb-6">
                <div class="flex align-items-center">
                    <RadioButton v-model="customer_type" inputId="typeA" value="1" />
                    <InputLabel for="typeA" class="ml-2 cursor-pointer">{{ $t('Soy cliente de Avinent') }}</InputLabel>
                </div>
                <div class="flex align-items-center">
                    <RadioButton v-model="customer_type" inputId="typeB" value="2" />
                    <InputLabel for="typeB" class="ml-2 cursor-pointer">{{ $t('Quiero ser cliente de Avinent') }}</InputLabel>
                </div>
            </div>
          

            <div class="md:columns-2 gap-8">
                <RegisterTypeA v-if="customer_type==1"></RegisterTypeA>
                <RegisterTypeB v-if="customer_type==2"></RegisterTypeB>
            </div>
        </main>

    </PageLayout>

</template>
