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

    console.table(match);
    if (match.length > 0) return match[0].estat; else return '-';


});


onMounted(() => {
//   CustomerService.getCustomersMedium().then((data) => (customers.value = data));
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                Últimos movimientos
            </h2>
        </template>

        <template #content>
            <div class="py-12 lg:columns-2 gap-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <Message severity="info" icon="pi pi-send">Info Message Content</Message>
                    
                    <DataTable :value="_data.users" paginator :rows="10" :rowsPerPageOptions="[10, 20, 50]">
                        <Column header="Data" style="width: 25%">
                            <template #body="{data}">
                                {{ moment(data.created_at).format('DD/MM/YYYY') }}
                            </template>
                       
                        </Column>
                        <Column field="raoSaocial" header="Raó social" style="width: 25%"></Column>
                        <Column field="estat" header="Estat" style="width: 25%">
                            <template #body="{data}">
                                {{ _status(data.estat) }}
                            </template>
                       
                        </Column>
                        <Column field="idClientX3" header="ID Client" style="width: 25%"></Column>
                    </DataTable>

                </div>

                <div class="lg:break-after-column"></div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <Message severity="info" icon="pi pi-send">Info Message Content</Message>

                    <DataTable :value="_data.orders" paginator :rows="20" :rowsPerPageOptions="[10, 20, 50]">
                        <Column field="dataCreacio" header="Data" style="width: 25%"></Column>
                        <Column field="raoSocial" header="Raó social" style="width: 25%"></Column>
                        <Column field="estat(idEstat)" header="Estat" style="width: 25%"></Column>
                        <Column field="idComandaX3" header="ID Cas" style="width: 25%"></Column>
                    </DataTable>

                </div>
            </div>
        </template>
    </AppLayout>
</template>

