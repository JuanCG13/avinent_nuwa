<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import Button from '@/Components/PrimaryButton.vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';                   
//import { CustomerService } from '@/service/CustomerService';


onMounted(() => {
//   CustomerService.getCustomersMedium().then((data) => (customers.value = data));
});

const page = usePage();

const customers = ref('');
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                Mis casos
            </h2>
            {{ page.props.impersonator.user.name }} // {{ page.props.auth.user.name }}
        </template>

        <template #content>
            <div class="py-12">
            <Link
                :href="route('impersonate', 3)"
                class="ml-2 block text-sm text-gray-900 underline dark:text-slate-300"
              >IMPERSONATE</Link>

              <Link
                :href="route('impersonate.leave')"
                class="ml-2 block text-sm text-gray-900 underline dark:text-slate-300"
              >DESIMPERSONATE</Link>

              <Button class="w-1/6 mt-6" @click="$route('orders.new')">Crear nuevo caso</Button>
            </div>
    
        
            <div class="py-12 px-6 lg:px-0 mx-auto main-dashboard">
                <DataTable :value="customers" paginator :rows="20" :rowsPerPageOptions="[20, 50, 100]">
                    <Column field="name" header="Name" style="width: 25%"></Column>
                    <Column field="country.name" header="Country" style="width: 25%"></Column>
                    <Column field="company" header="Company" style="width: 25%"></Column>
                    <Column field="representative.name" header="Representative" style="width: 25%"></Column>
                </DataTable>
            </div>
        </template>
    </AppLayout>
</template>

