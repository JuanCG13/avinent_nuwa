<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, computed, reactive } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';             
import Message from 'primevue/message';      
import Breadcrumb from 'primevue/breadcrumb';
import moment from 'moment';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const toast = useToast();

const _data = defineProps({

    users: Object,
    orders: Object,
    status: Object,

});

const _status1 = reactive({
 
})


const _status = ((idEstat)=> {

    var match = _data.status.filter(
      function(data){ return data.idEstat == idEstat && data.idIdioma == 'SPA' }
  );

    //console.table(match);
    if (match.length > 0) return match[0].estat; else return '-';

});

const testing = (obj) => {
        console.log(`Received object from child:`)    
        console.log(obj)
}

onMounted(() => {
  //  toast.add({ severity: 'success', summary:'', detail: 'Message Content', life: 3000 });
//   CustomerService.getCustomersMedium().then((data) => (customers.value = data));
});

</script>

<template>
    <AppLayout title="Dashboard">
    
        <template #header>
            <ToastNotification @onTesting="testing" />
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                Últimos movimientos
            </h2>

        </template>

        <template #content>
            <div class="py-12 lg:columns-2 gap-0">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">         
                       <Message severity="success">
                        <div class="flex flex-col">
                            <span class="font-bold">¡Tienes clientes pendientes de validación! </span>
                            <span class="text-xs">Success Message Content</span>
                        </div>
                    </Message>
                    <Message severity="info">Info Message Content</Message>
                    <Message severity="warn">Warning Message Content</Message>
                    <Message severity="error">Error Message Content</Message>
                
                    <DataTable :value="_data.users" paginator :rows="10" :rowsPerPageOptions="[10, 20, 50]">
                      
                     <template #header>
                        <div class="flex flex-wrap align-items-center">
                            <span class="text-lg font-bold">Validación de clientes</span>
                        </div>
                    </template>
                        <Column header="Data" >
                            <template #body="{data}">
                                {{ moment(data.created_at).format('DD/MM/YYYY') }}
                            </template>
                       
                        </Column>
                        <Column field="raoSocial" header="Raó social" ></Column>
                        <Column field="estat" header="Estat" >
                            <template #body="{data}">
                                {{ _status(data.estat) }}
                            </template>
                       
                        </Column>
                        <Column field="idClientX3" header="ID Client" ></Column>
                        <!-- <template #footer> In total there are {{ _data.users ? _data.users.length: 0 }} clients. </template> -->
                        <Column field="id" alignFrozen="right" :frozen="true">
                            <template #body="{data}">
                                <i class="pi pi-eye text-primary-500"></i>
                                <!-- {{ data.id }} -->
                            </template>
                        </Column>
                    </DataTable>

                </div>

                <div class="lg:break-after-column"></div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <Message severity="info" icon="pi pi-send">Info Message Content</Message>

                    <DataTable :value="_data.users" paginator :rows="20" :rowsPerPageOptions="[10, 20, 50]">
                    <template #header>
                        <div class="flex flex-wrap align-items-center">
                            <span class="text-lg font-bold">Validación de pedidos</span>
                        </div>
                    </template>
                        <Column header="Data" >
                            <template #body="{data}">
                                {{ moment(data.dataCreacio).format('DD/MM/YYYY') }}
                            </template>
                        </Column>
                        <Column field="raoSocial" header="Raó social" ></Column>
                        <Column field="estat(idEstat)" header="Estat" ></Column>
                        <Column field="idComandaX3" header="ID Cas" ></Column>
                        <Column field="id">
                            <template #body="{data}">
                                <i class="pi pi-check-circle text-primary-500"></i>
                                <!-- {{ data.id }} -->
                            </template>
                        </Column>

                    </DataTable>

                </div>
            </div>
        </template>
    </AppLayout>
</template>

