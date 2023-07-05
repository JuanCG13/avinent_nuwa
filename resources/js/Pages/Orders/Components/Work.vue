<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from 'primevue/dropdown';
import { vue3dLoader } from "vue-3d-loader";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const toast = useToast();
const confirm = useConfirm();


const props = defineProps({
    workType:String,
});

const emit = defineEmits(['deleteWork','cloneWork'])

const workData = reactive({
    workType: props.workType,
    idTipusArticle : '',
    idTipusArticle2 : '',
    });



const deleteWork = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Quieres borrar el trabajo?',
        icon: 'pi pi-trash',
        acceptIcon: 'pi pi-check',
        rejectIcon: 'pi pi-times',
        accept: () => {
            toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 3000 });
            emit('deleteWork')
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

const editWork = (event) => {

};

const cloneWork = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Quieres duplicar el trabajo?',
        icon: 'pi pi-trash',
        accept: () => {
            emit('cloneWork')
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

</script>

<template>
    <Toast />
    <ConfirmPopup />

    <div class="w-full bg-primary-300 border border-gray-200 mb-6 p-6">
        <div class="flex justify-between">
            <div>{{workData.workType}}</div>
            <div class="flex">
                <div @click="deleteWork($event)">
                    <i class="pi pi-trash text-xl ml-3 hover:cursor-pointer hover:text-primary-500 text-slate-500 transition-colors"></i>
                </div>
                <div @click="editWork($event)">
                    <i class="pi pi-pencil font-light text-xl ml-3 hover:cursor-pointer hover:text-primary-500 text-slate-500 transition-colors"></i>
                </div>
                <div @click="cloneWork($event)">
                    <i class="pi pi-copy text-xl ml-3 hover:cursor-pointer hover:text-primary-500 text-slate-500 transition-colors"></i>
                </div>
            </div>
        </div>
        <div class="pt-6 flex flex-col w-full">
            <div class="mt-4 gap-6 columns-2 flex w-2/3">
                <TextInput
                    id="idTipusArticle"
                    v-model="workData.idTipusArticle"
                    ref="idTipusArticleInput"
                    type="text"
                    class="mt-1 block w-3/4"
                    @input="handleChange"
                />

                <TextInput
                    id="idTipusArticle2"
                    v-model="workData.idTipusArticle2"
                    ref="idTipusArticleInput"
                    type="text"
                    class="mt-1 block w-1/4"
                    @input="handleChange"
                />


            </div>
         
            <div class="mt-4 w-1/3">
                <vue3dLoader
                :height="200"
                :showFps="true"
                :filePath="['http://127.0.0.1:8000/storage/placeholder.stl']"
                :backgroundColor="0x000000"
                >
                </vue3dLoader>
             </div>
         
        </div>

        
     
    </div>

</template>