<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, reactive, watch } from 'vue';
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import Button from '@/Components/PrimaryButton.vue';
import Dropdown from 'primevue/dropdown';

import InputText from 'primevue/inputtext';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import moment from 'moment';
import { useI18n } from "vue-i18n";

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

import { useWebNotification } from '@vueuse/core'

const {t, locale} = useI18n();

const page = usePage();

const orderList = [];

const _data = defineProps({

    orders: Object,
    status: Object,

});

const impersonateUserSelected = ref(0);
const clientSelected = ref(0);

const impersonateUserList = reactive({
    data:null
});

const clientList = reactive({
    data:null
});

const filteredUserList = ref(null);

watch(clientSelected, () => {
    filteredUserList.value =  _.filter(impersonateUserList.data, {'idClientX3':clientSelected.value});
});

watch(impersonateUserSelected, (user) => {
    router.get(route('impersonate', user));
});

const orderStatus = ((idEstat)=> {
    var match = _data.status.filter(
        function(data){ return data.idEstat == idEstat && data.idIdiomaISO == locale.value }
    );
    if (match.length > 0) return match[0].estat; else return '-';
});


onMounted(async () => {
    const response1 = await fetch("/clients/");
    clientList.data = await response1.json();

    const response = await fetch("/impersonate-users/");
    impersonateUserList.data = await response.json();

    //   const response1 = await fetch("/order/list");
    //   orderList.value = await response1.json();
 
    });

const editOrder = (event, index) => {
    router.get(route('orders.edit', index));
};

const viewOrder = (event, index) => {
    
};

const cloneOrder = (event, index) => {
    
};

const deleteOrder = (event, index) => {
    
};

const downloadOrder = (event, index) => {
    
};



</script>

<template>
    <AppLayout :title="$t('Mis casos')">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
               {{ $t('Mis casos') }} 
            </h2>
        </template>
 
        <template #content>
            
            <div v-if="isSupported">
                <Button class="!w-1/6" @click="show()">
                    Show Notification
                </Button>
            </div>
            <div class="pt-6">
                <span v-if="page.props.auth.user.isAdmin!=1" class="p-input-icon-right">
                    <i class="pi" >
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15.003" height="20" viewBox="0 0 15.003 20">
                            <defs>
                                <clipPath id="clip-path">
                                <rect id="Rectángulo_1534" data-name="Rectángulo 1534" width="15.003" height="20" fill="#b0b0b0"/>
                                </clipPath>
                            </defs>
                            <g id="Grupo_394" data-name="Grupo 394" clip-path="url(#clip-path)">
                                <path id="Trazado_446" data-name="Trazado 446" d="M13.4,20H1.6c-.073-.023-.144-.05-.218-.07a1.849,1.849,0,0,1-1.38-1.759q-.011-4.422,0-8.844a1.832,1.832,0,0,1,1.553-1.79A9.32,9.32,0,0,1,2.5,7.483c0-.075,0-.145,0-.215,0-.787-.007-1.575,0-2.362A4.979,4.979,0,0,1,5.9.272C6.28.148,6.681.089,7.072,0h.859l.3.052A5,5,0,0,1,12.5,5.081q0,1.1,0,2.206V7.5c.244,0,.459,0,.673,0A1.858,1.858,0,0,1,15,9.327q.016,4.422,0,8.844a1.843,1.843,0,0,1-1.231,1.713c-.12.044-.244.078-.366.116M10.832,7.49c0-.65.006-1.286,0-1.923a8.423,8.423,0,0,0-.053-1.148,3.328,3.328,0,0,0-6.6.625c0,.657,0,1.315,0,1.972V7.49Zm-4.16,7.493c0,.111,0,.221,0,.332,0,.182,0,.365,0,.546a.828.828,0,0,0,.834.808.82.82,0,0,0,.819-.8c.011-.566.01-1.132,0-1.7a.377.377,0,0,1,.175-.352,1.634,1.634,0,0,0,.546-1.935,1.666,1.666,0,0,0-3.156.2,1.623,1.623,0,0,0,.635,1.756.3.3,0,0,1,.147.287c-.009.286,0,.572,0,.859" transform="translate(0)" fill="#b0b0b0"/>
                            </g>
                        </svg>
                    </i>
                    <InputText 
                        :value="page.props.auth.user.idClientX3" 
                        v-model="clientSelected"
                        class="mt-2 p-2 w-48 rounded-sm text-sm bg-gray-200" 
                        disabled />
                </span>
                <Dropdown 
                v-if="page.props.auth.user.isAdmin==1"
                :loading="!clientList.data"
                :options="clientList.data" 
                v-model="clientSelected" 
                class="mt-2 w-48 rounded-sm text-xs" 
                optionValue="idClientX3" 
                optionLabel="idClientX3" 
                :placeholder="$t('Seleccionar cliente')"
                :pt="{
                    input: { class: 'text-sm p-2' },
                    loadingIcon: { class: 'text-sm' },
                    wrapper: { class: 'text-sm bg-white' },
                    list: {class: 'rounded-sm py-0' },
                    item: {class: 'hover:bg-primary-300'},
                    trigger: { class: 'text-sm mx-4 my-0 w-auto text-black-800' },
                }">
                </Dropdown>
                    <br/>
         
                <Dropdown 
                v-if="page.props.auth.user.tipusUsuari != 2"
                :loading="!impersonateUserList.data"
                :options="page.props.auth.user.isAdmin ? filteredUserList : impersonateUserList.data" 
                v-model="impersonateUserSelected" 
                class="mt-3 w-48 rounded-sm text-xs" 
                optionValue="id" 
                optionLabel="name" 
                :emptyMessage="$t('No hay usuarios')"
                :placeholder="$t('Seleccionar usuario')"
                :pt="{
                    input: { class: 'text-sm p-2' },
                    loadingIcon: { class: 'text-sm' },
                    wrapper: { class: 'text-sm bg-white' },
                    list: {class: 'rounded-sm py-0' },
                    item: {class: 'hover:bg-primary-300'},
                    trigger: { class: 'text-sm mx-4 my-0 w-auto text-black-800' },
                }">
                    <template #option="slotProps">
                        <span> {{slotProps.option.name}} </span>
                    </template>
                </Dropdown>

             <div v-if="page.props.impersonator.user">
                <Button class="!w-48 mt-3 rounded-sm !bg-emerald-500" @click="router.visit(route('impersonate.leave'))">
                    <div class="flex">
                    {{ $t('Volver a mi usuario') }} 
    
                </div>
                </Button>
    

                </div>
            </div>

              <Button class="!w-48 mt-6 rounded-sm" @click="router.visit(route('orders.new'))">
                <svg class="mr-3 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33">
                    <g id="Grupo_557" data-name="Grupo 557" transform="translate(-491 -1488)">
                        <path id="Elipse_14" data-name="Elipse 14" d="M16.5,2.64A13.86,13.86,0,0,0,6.7,26.3,13.86,13.86,0,1,0,26.3,6.7a13.769,13.769,0,0,0-9.8-4.06M16.5,0A16.5,16.5,0,1,1,0,16.5,16.5,16.5,0,0,1,16.5,0Z" transform="translate(491 1488)" fill="#fff"/>
                        <g id="Grupo_556" data-name="Grupo 556" transform="translate(497.202 1494.6)">
                        <path id="Línea_34" data-name="Línea 34" d="M-.68,17.14A1.32,1.32,0,0,1-2,15.82V-.68A1.32,1.32,0,0,1-.68-2,1.32,1.32,0,0,1,.64-.68v16.5A1.32,1.32,0,0,1-.68,17.14Z" transform="translate(10.91 2)" fill="#fff"/>
                        <path id="Línea_35" data-name="Línea 35" d="M17.276.64H-.68A1.32,1.32,0,0,1-2-.68,1.32,1.32,0,0,1-.68-2H17.276A1.32,1.32,0,0,1,18.6-.68,1.32,1.32,0,0,1,17.276.64Z" transform="translate(2 10.25)" fill="#fff"/>
                        </g>
                    </g>
                </svg>
                {{ $t('Crear nuevo caso') }} 
            </Button>
    
        
            <div class="py-12 main-dashboard">
                <DataTable :value="_data.orders" paginator :rows="20" :rowsPerPageOptions="[20, 50, 100]" :key="idComanda">
                    <Column :header="$t('Fecha creación')" style="width: 10%">
                        <template #body="{data}">
                                {{ moment(data.dataCreacio).format('DD/MM/YYYY') }}
                        </template>
                    </Column>
                    <Column field="idComandaX3" :header="$t('ID caso')" style="width: 10%"></Column>
                    <Column field="refPacient" :header="$t('Referencia paciente')" style="width: 20%">
                    </Column>
                    <Column :header="$t('Fecha entrega')" style="width: 15%">
                        <template #body="{data}">
                                {{ moment(data.dataPrevista).format('DD/MM/YYYY') }}
                        </template>
                    </Column>
                    <Column :header="$t('Estado')" style="width: 15%">
                        <template #body="{data}">
                                {{ orderStatus(data.idEstat) }}
                        </template>
                    </Column>
                    <Column :header="$t('Acciones')" style="width: 15%">
                    <template #body="{data}">
                        <div class="flex">
                            <div @click="viewOrder($event, data.idComanda)" v-tooltip.top="{value:$t('Visualizar'), class:'text-xs text-center border-sm no-wrap'}">
                                <i class="pi pi-eye text-md mr-3 hover:cursor-pointer text-primary-500 hover:text-slate-500 transition-colors"></i>
                            </div>
                            <div @click="editOrder($event, data.idComanda)" v-if="data.idEstat!=99" v-tooltip.top="{value:$t('Editar'), class:'text-xs text-center border-sm no-wrap'}">
                                <i class="pi pi-pencil font-light text-md mr-3 hover:cursor-pointer text-primary-500 hover:text-slate-500 transition-colors"></i>
                            </div>
                            <div @click="downloadOrder($event, data.idComanda)" v-if="data.idEstat!=99 && data.idEstat!=0" v-tooltip.top="{value:$t('Descargar todo el caso'), class:'text-xs text-center border-sm no-wrap'}">
                                <i class="pi pi-download font-light text-md mr-3 hover:cursor-pointer text-primary-500 hover:text-slate-500 transition-colors"></i>
                            </div>
                            <div @click="cloneOrder($event, data.idComanda)" v-if="data.idEstat!=99" v-tooltip.top="{value:$t('Copiar'), class:'text-xs text-center border-sm no-wrap'}">
                                <i class="pi pi-copy text-md mr-3 hover:cursor-pointer text-primary-500 hover:text-slate-500 transition-colors"></i>
                            </div>
                            <div @click="deleteOrder($event, data.idComanda)" v-if="data.idEstat==0" v-tooltip.top="{value:$t('Borrar'), class:'text-xs text-center border-sm no-wrap'}">
                                <i class="pi pi-trash text-md mr-3 hover:cursor-pointer text-primary-500 hover:text-slate-500 transition-colors"></i>
                            </div>
                        </div>
                    </template>
                    </Column>
                </DataTable>
            </div>
        </template>
    </AppLayout>
</template>

