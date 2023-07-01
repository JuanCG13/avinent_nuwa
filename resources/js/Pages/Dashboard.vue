<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';                   
//import { CustomerService } from '@/service/CustomerService';


onMounted(() => {
//   CustomerService.getCustomersMedium().then((data) => (customers.value = data));
});

const customers = ref('');
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                Mis pedidos
            </h2>
        </template>

        <template #content>
            <div class="py-12">
            
                <div class="max-w-7xl mx-auto px-6 lg:px-8 main-dashboard">
                    <DataTable :value="customers" paginator :rows="20" :rowsPerPageOptions="[20, 50, 100]">
                        <Column field="name" header="Name" style="width: 25%"></Column>
                        <Column field="country.name" header="Country" style="width: 25%"></Column>
                        <Column field="company" header="Company" style="width: 25%"></Column>
                        <Column field="representative.name" header="Representative" style="width: 25%"></Column>
                    </DataTable>


                </div>
            </div>
        </template>
    </AppLayout>
</template>

