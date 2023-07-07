<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from 'primevue/dropdown';
import MessageBox from '@/Components/MessageBox.vue';

const emit = defineEmits(['closeDetail'])

const props = defineProps({
    workDetail:Object,
});


</script>

<template>
    <div class="pt-12 px-6 mx-auto lg:px-0">
        <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
            Detalle trabajo {{workDetail.workType}}
        </h2>
    </div>

     <MessageBox
        class="w-1/2 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('msg.step-1')"
        :text="$t('msg.tipo-de-solucion')"
        >
     </MessageBox>
 

    <div class="w-full bg-primary-300 border border-gray-200 p-6">
         
          {{ workDetail }}

        <div class="flex justify-between">
            <div>{{workDetail.workType}}</div>
        </div>
        <div class="pt-6 w-full flex">
            <div class="w-1/2">
                <label for="idTipusArticle" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.product-type") }}</label>
                <TextInput
                    id="idTipusArticle"
                    v-model="workDetail.idTipusArticle"
                    type="text"
                    class="mt-1 mb-6 block w-full"
                    @input="handleChange"
                />
                <label for="idMaterial" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material-type") }}</label>
                <TextInput
                    id="idMaterial"
                    v-model="workDetail.idMaterial"
                    type="text"
                    class="mt-1 mb-6 block w-full"
                    @input="handleChange"
                />
                
                <div class="w-full flex">
                    <div class="w-1/4">
                        <label for="idTipusArticle2" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material-type") }}</label>
                        <TextInput
                            id="idTipusArticle2"
                            v-model="workDetail.idTipusArticle2"
                            type="text"
                            class="mt-1 mb-6 block"
                            @input="handleChange"
                        />
                    </div>
                     <div class="w-1/5">
                        <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material-type") }}</label>
                        <TextInput
                            id="quantitat"
                            v-model="workDetail.quantitat"
                            type="text"
                            class="mt-1 mb-6 block"
                            @input="handleChange"
                        />
                     </div>
                     <div class="w-1/5">
                        <label for="numDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material-type") }}</label>
                        <TextInput
                            id="numDesmontables"
                            v-model="workDetail.numDesmontables"
                            type="text"
                            class="mt-1 mb-6 block"
                            @input="handleChange"
                        />
                     </div>
                     <div class="w-1/4">
                        <label for="posDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material-type") }}</label>
                        <TextInput
                            id="posDesmontables"
                            v-model="workDetail.posDesmontables"
                            type="text"
                            class="mt-1 mb-6 block"
                            @input="handleChange"
                        />
                    </div>
                 </div>



            </div>
         
            <div class="w-1/2">
                <!-- <vue3dLoader
                :height="200"
                :showFps="true"
                :filePath="['http://127.0.0.1:8000/storage/placeholder.stl']"
                :backgroundColor="0x000000"
                >
                </vue3dLoader> -->
             </div>
         
        </div>

        
     
    </div>

    <div class="flex gap-6 px-6 lg:px-0 py-12 justify-end">
        <Button class="!w-1/12" @click="emit('closeDetail')">Guardar</Button>
        <AltButton class="!w-1/12" @click="emit('closeDetail')">Cerrar</AltButton>

    </div>

</template>