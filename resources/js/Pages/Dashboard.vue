<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, reactive, watch } from 'vue';
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import Button from '@/Components/PrimaryButton.vue';
import Dropdown from 'primevue/dropdown';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';    
import moment from 'moment';

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

import { useWebNotification } from '@vueuse/core'


const page = usePage();

const orderList = ref('');

const _data = defineProps({

    orders: Object,
    status: Object,

});

const impersonateUserSelected = ref(0);

const impersonateUserList = reactive({
    data:null
});

watch(impersonateUserSelected, (user) => {
    router.get(route('impersonate', user));
});


const orderStatus = ((idEstat)=> {

var match = _data.status.filter(
  function(data){ return data.idEstat == idEstat && data.idIdioma == 'SPA' }
);

//console.table(match);
if (match.length > 0) return match[0].estat; else return '-';

});


onMounted(async () => {
      const response = await fetch("/impersonate-users/");
      impersonateUserList.data = await response.json();
   
      const response1 = await fetch("/order/list");
      orderList.value = await response1.json();
 
    });


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                Mis casos
            </h2>
        </template>

        <template #content>

            <div v-if="isSupported">
                <Button class="!w-1/6" @click="show()">
                    Show Notification
                </Button>
            </div>

            <div class="py-12" v-if="!page.props.impersonator.user && page.props.auth.user.tipusUsuari != 2">
              
                <Dropdown :options="impersonateUserList.data" v-model="impersonateUserSelected" class="w-1/6 my-6" optionValue="id" optionLabel="name" placeholder="Selecciona">
                    <template #option="slotProps">
                        <span> {{slotProps.option.name}} </span>
                    </template>
                </Dropdown>

                <Link
                    :href="route('impersonate', impersonateUserSelected)"
                    class="ml-2 block text-sm text-gray-900 underline dark:text-slate-300"
                >IMPERSONATE</Link>
              

                <div v-if="page.props.impersonator.user">
                <Link
                    :href="route('impersonate.leave')"
                    class="ml-2 block text-sm text-gray-900 underline dark:text-slate-300"
                >DESIMPERSONATE</Link>
                </div>
            </div>

              <Button class="!w-2/12 mt-6" @click="router.visit(route('orders.new'))">
                <svg class="mr-3 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33">
                                <g id="Grupo_557" data-name="Grupo 557" transform="translate(-491 -1488)">
                                    <path id="Elipse_14" data-name="Elipse 14" d="M16.5,2.64A13.86,13.86,0,0,0,6.7,26.3,13.86,13.86,0,1,0,26.3,6.7a13.769,13.769,0,0,0-9.8-4.06M16.5,0A16.5,16.5,0,1,1,0,16.5,16.5,16.5,0,0,1,16.5,0Z" transform="translate(491 1488)" fill="#fff"/>
                                    <g id="Grupo_556" data-name="Grupo 556" transform="translate(497.202 1494.6)">
                                    <path id="Línea_34" data-name="Línea 34" d="M-.68,17.14A1.32,1.32,0,0,1-2,15.82V-.68A1.32,1.32,0,0,1-.68-2,1.32,1.32,0,0,1,.64-.68v16.5A1.32,1.32,0,0,1-.68,17.14Z" transform="translate(10.91 2)" fill="#fff"/>
                                    <path id="Línea_35" data-name="Línea 35" d="M17.276.64H-.68A1.32,1.32,0,0,1-2-.68,1.32,1.32,0,0,1-.68-2H17.276A1.32,1.32,0,0,1,18.6-.68,1.32,1.32,0,0,1,17.276.64Z" transform="translate(2 10.25)" fill="#fff"/>
                                    </g>
                                </g>
                            </svg>
                Crear nuevo caso
            </Button>
    
        
            <div class="py-12 px-6 lg:px-0 mx-auto main-dashboard">
                <DataTable :value="_data.orders" paginator :rows="20" :rowsPerPageOptions="[20, 50, 100]" :key="idComanda">
                    <Column :header="$t('msg.order-date')" style="width: 10%">
                        <template #body="{data}">
                                {{ moment(data.dataCreacio).format('DD/MM/YYYY') }}
                        </template>
                    </Column>
                    <Column field="idComandaX3" :header="$t('msg.case-id')" style="width: 10%"></Column>
                    <Column field="refPacient" :header="$t('msg.pacient-ref')" style="width: 20%">
                    </Column>
                    <Column :header="$t('msg.delivery-date')" style="width: 15%">
                        <template #body="{data}">
                                {{ moment(data.dataPrevista).format('DD/MM/YYYY') }}
                        </template>
                    </Column>
                    <Column :header="$t('msg.order-status')" style="width: 15%">
                        <template #body="{data}">
                                {{ orderStatus(data.estat) }}
                        </template>
                    </Column>
                    <Column :header="$t('msg.order-actions')" style="width: 15%"></Column>
                </DataTable>
            </div>
        </template>
    </AppLayout>
</template>

