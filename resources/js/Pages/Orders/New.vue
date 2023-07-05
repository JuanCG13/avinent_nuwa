<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, router } from '@inertiajs/vue3';

import { ref, onMounted, reactive } from 'vue';
import Info from './Components/Info.vue';
import Work from './Components/Work.vue';
import WorkDetail from './Components/WorkDetail.vue';

import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import SelectButton from 'primevue/selectbutton';
import MessageBox from "@/Components/MessageBox.vue";
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';

const toast = useToast();

const workType = ref(null);
const showWorkDetail = ref(false);

const workTypes = ref([
    { label: 'Producción', value: 'A' },
    { label: 'Producción y diseño', value: 'B' },
])

const orderData = reactive({
    orderHeader:{}, //Object
    orderWorks:[] //Array of objects
});

const closeWorkDetail = () => {
    showWorkDetail.value = false;
}

const deleteWork = (work) => {
    orderData.orderWorks.splice(work, 1);
}

const cloneWork = (work) => {
   // orderData.orderWorks.splice(work, 1);
}

const addWork = (type) => {
    orderData.orderWorks.push({
        workType:type.value
    })
    workType.value = null;
    showWorkDetail.value = true;

}

const updateData = (data) => {
    orderData.orderHeader = data.orderHeader;
};

const addOrder = () => {
    router.post('order.new', [props.orderHeader, props.orderWorks]), {
        errorBag: 'addOrder',
        preserveScroll: true,
        onSuccess: () => {
            toast.add();
        }
    }
};

const saveOrder = (data) => {
    console.table(data.orderHeader);
    console.table(data.orderWorks);
    return;
    router.post('order.store', [data.orderHeader, data.orderWorks]), {
        errorBag: 'addOrder',
        preserveScroll: true,
        onSuccess: () => {
            toast.add();
        }
    }
};

</script>

<template>
    <AppLayout title="Dashboard">
        
        <template #fullcontent>
            <WorkDetail v-if="showWorkDetail" :workType="WorkType" @closeDetail="closeWorkDetail"></WorkDetail>
        </template>

        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
               Nuevo pedido
            </h2>
        </template>

        <template #content>

            <div class="mx-auto px-6 lg:px-0 gap-12 flex py-12">

                <div class="w-1/3 h-full">
                    <Info
                     @addOrder = "addOrder"
                     @saveOrder = "saveOrder"
                     @updateData="updateData"
                     />

                    <MessageBox class="mt-6 border-red-800 bg-red-100 text-red-900"
                    :title="$t('msg.register-title')" 
                    :text="$t('msg.register-copy')"
                    />
                     
                </div>

                <div class="w-2/3 works">
                    <template v-for="(value, index) in orderData.orderWorks" :key="index">
                        <Work :workType="value.workType" @deleteWork="deleteWork(index)"  @cloneWork="cloneWork(index)"/>
                    </template>
                  
                    <div class="flex w-full p-6 bg-primary-500 text-white items-center justify-between">
                        <div class="text-xl font-bold flex items-center">
                            <svg class="mr-4" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33">
                                <g id="Grupo_557" data-name="Grupo 557" transform="translate(-491 -1488)">
                                    <path id="Elipse_14" data-name="Elipse 14" d="M16.5,2.64A13.86,13.86,0,0,0,6.7,26.3,13.86,13.86,0,1,0,26.3,6.7a13.769,13.769,0,0,0-9.8-4.06M16.5,0A16.5,16.5,0,1,1,0,16.5,16.5,16.5,0,0,1,16.5,0Z" transform="translate(491 1488)" fill="#fff"/>
                                    <g id="Grupo_556" data-name="Grupo 556" transform="translate(497.202 1494.6)">
                                    <path id="Línea_34" data-name="Línea 34" d="M-.68,17.14A1.32,1.32,0,0,1-2,15.82V-.68A1.32,1.32,0,0,1-.68-2,1.32,1.32,0,0,1,.64-.68v16.5A1.32,1.32,0,0,1-.68,17.14Z" transform="translate(10.91 2)" fill="#fff"/>
                                    <path id="Línea_35" data-name="Línea 35" d="M17.276.64H-.68A1.32,1.32,0,0,1-2-.68,1.32,1.32,0,0,1-.68-2H17.276A1.32,1.32,0,0,1,18.6-.68,1.32,1.32,0,0,1,17.276.64Z" transform="translate(2 10.25)" fill="#fff"/>
                                    </g>
                                </g>
                            </svg>
                            Nuevo trabajo 
                        </div>
                        <div class="card flex flex-wrap justify-content-center gap-3">
                            <SelectButton v-model="workType" :options="workTypes" optionLabel="label" dataKey="value">
                   
                            </SelectButton>
                        </div>
                        <div v-tooltip.top="{value:workType?'':'Debes seleccionar el tipo de trabajo', class:'text-xs text-center border-sm no-wrap'}"> 
                        <Button 
                            class="text-lg font-bold bg-white !text-purple-950 hover:bg-primary-300" 
                            :disabled="!workType"
                            @click="addWork(workType)"
                            >
                            Empezar
                        </Button>
                        </div>
                    </div>

                </div>
                  
            </div>

        </template>
    </AppLayout>
</template>

