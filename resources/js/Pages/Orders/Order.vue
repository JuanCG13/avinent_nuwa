<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, usePage } from '@inertiajs/vue3';

import { ref, onMounted, reactive, computed } from 'vue';
import Info from './Components/Info.vue';
import Work from './Components/Work.vue';
import WorkDetail from './Components/WorkDetail.vue';
import ValidationBox from './Components/ValidationBox.vue';

import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import SelectButton from 'primevue/selectbutton';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const toast = useToast();
const page = usePage();

const tipoTreball = ref(null);
const showWorkDetail = ref(false);
const currentWorkDetail = ref(0);

const workTypes = ref([
    { label: t('Producción'), value: t('A') },
    { label: t('Producción y diseño'), value: t('B') },
])

defineProps ({
    orderData: Object,
    orderAction: { //0 new | 1 view | 2 edit
        type: Number,
        default: 0
     } 
});

onMounted(() => {
    if (page.props.orderData) {
        orderData.orderHeader = page.props.orderData.orderHeader;
        orderData.orderWorks = page.props.orderData.orderWorks;
    }
    //page.props.orderAction = 1;
})

const orderData = reactive({
    orderHeader:{
        idComanda: '',
        refPacient: '',
        idAdrecaEnviament: '',
        adrecaFacturacio: '',
        persContacte: '',
        telfContacte: '',
        dataPrevista: '',
        dataCreacio: '',
        dataModificacio: '',
    },
    orderWorks:[] //Array of objects
});

const closeWorkDetail = () => {
    showWorkDetail.value = false;
}

const deleteWork = (index) => {
    orderData.orderWorks.splice(index, 1);
}

const editWork = (index) => {
    currentWorkDetail.value = orderData.orderWorks[index]
    showWorkDetail.value = true;
}

const cloneWork = (index) => {
   orderData.orderWorks.push(
     {...orderData.orderWorks[index]}
    );
}

const addWork = (type) => {
    orderData.orderWorks.push({
        tipoTreball: type.value,
        implantsDetail: [],
        // idLiniaCmd: 0,
        // idComanda: 0,
        numLin: 0,
        idTipusArticle: '',
        idMaterial: '',
        idTipusArticle2: '',
        quantitat: 0,
        numDesmontables: 0,
        posDesmontables: '',
        idColor: '',
        idIncisal: '',
        idSistemaFitxer: '',
        fitxer1: '',
        fitxer2: '',
        numDents: 0,
        numImplants: 0,
        acabatBrillant: false,
        tractamentTermic: false,
        anodizat: false,
        zonesPulides: '',
        colorAnodizat: '',
        teMicrorosca: false,
        numMicrorosques: 0,
        inclourePilars: '',
        enviarModel: false,
        tipusEnviament: '',
    //  dataRecepcio: Date,
    //  idOFX3: '',
    //  dataCreacio:Date,
    //  dataModificacio:Date,
    })

    tipoTreball.value = null; //reset tipo de treball
    currentWorkDetail.value = orderData.orderWorks[orderData.orderWorks.length-1] 
    showWorkDetail.value = true; //show pantalla treball
}

// const updateData = (data) => {
//     orderData.orderHeader = data.orderHeader;
// };

const addOrder = () => {
    router.post(route('order.new'), [props.orderHeader, props.orderWorks]), {
        errorBag: 'addOrder',
        preserveScroll: true,
        onSuccess: () => {
            toast.add();
        }
    }
};

const saveOrder = () => {

    router.post(route('order.store'), orderData), {
        errorBag: 'addOrder',
        preserveScroll: true,
        onSuccess: () => {
            toast.add('Order created');
        }
    }
};

const _orderAction = computed(() => {
    switch (page.props.orderAction) {
        case 0: 
            return t('Nuevo caso')
        case 1: 
            return t('Visualizar caso') + ' ' + orderData.orderHeader.idComandaX3
        case 2 : 
            return t('Editar caso') + ' ' + orderData.orderHeader.idComandaX3

    }
})

</script>

<template>
    <AppLayout :title="_orderAction">

        <template #header>
            <h2 v-if="!showWorkDetail" class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
               {{_orderAction}}
            </h2>

            <h2 v-if="showWorkDetail" class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                {{$t('Detalle trabajo')}} 
            </h2>

        </template>

        <template #content>
            
            <div class="mx-auto gap-12 flex pb-12">

                <WorkDetail v-if="showWorkDetail" 
                    :workDetail="currentWorkDetail"
                    @closeDetail="closeWorkDetail"
                    >
                </WorkDetail>
            </div>  

       
            <div class="mx-auto gap-12 flex pb-12"  :class="[showWorkDetail ? 'hidden' : 'flex']">

                <div class="w-1/3 h-full">
                    <Info
                        @addOrder = "addOrder"
                        @saveOrder = "saveOrder"
                        :orderHeader="orderData.orderHeader"
                      />
                    <ValidationBox
                        :orderData="orderData"
                    />
                </div>

                <div class="w-2/3 works">
                    <template v-for="(value, index) in orderData.orderWorks" :key="index">
                        <Work 
                            :workData="value"
                            :index = "index"
                            @deleteWork="deleteWork(index)" 
                            @editWork="editWork(index)"  
                            @cloneWork="cloneWork(index)"
                        />
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
                            {{ $t('Nuevo trabajo') }}
                        </div>
                        <div class="card flex flex-wrap justify-content-center gap-3">
                            <SelectButton v-model="tipoTreball" :options="workTypes" optionLabel="label" dataKey="value">
                   
                            </SelectButton>
                        </div>
                        <div v-tooltip.top="{value:tipoTreball?'':$t('Debes seleccionar el tipo de trabajo'), class:'text-xs text-center border-sm no-wrap'}"> 
                        <Button 
                            class="text-lg font-bold bg-white !text-purple-900 hover:bg-primary-300" 
                            :disabled="!tipoTreball"
                            @click="addWork(tipoTreball)"
                            >
                            {{ $t('Empezar') }}
                        </Button>
                        </div>
                    </div>

                </div>
                  
            </div>

        </template>
    </AppLayout>
</template>

