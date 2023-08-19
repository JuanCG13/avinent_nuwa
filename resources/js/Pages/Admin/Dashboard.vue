<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, computed, reactive } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3'
import DataTable from 'primevue/datatable';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputMask from 'primevue/inputmask';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';             
import Message from 'primevue/message';      
import moment from 'moment';
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';
import ConfirmDialog from 'primevue/confirmdialog';
import Tooltip from 'primevue/tooltip';

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const page = usePage();
const toast = useToast();
const confirm = useConfirm();

const _data = defineProps({

    users: Object,
    orders: Object,
    status: Object,

});

const currUser = useForm({
    id: null,
    name: null,
    idClientX3: null
});

const _status = ((idEstat)=> {

    var match = _data.status.filter(
      function(data){ return data.idEstat == idEstat && data.idIdioma == 'SPA' }
  );

    //console.table(match);
    if (match.length > 0) return match[0].estat; else return '-';

});

const activateUser = (event, currUser) => {
    confirm.require({
        target: event.currentTarget,
        header: currUser.name,
        acceptIcon: 'pi pi-check',
        rejectIcon: 'pi pi-times',
        acceptClass: 'p-button-success text-xs',
        rejectClass: 'p-button-info text-xs',
        accept: () => {
            router.post(route('admin.activateuser'), currUser, {
              preserveState: true, preserveScroll: true,
              onSuccess: () => {toast.add({ severity: 'success', summary: 'Confirmed', detail: 'You have accepted', life: 1000 })},
              onError: () => {},
             })
    
        }
    })
};



</script>

<template>
    <Toast />
    <ConfirmDialog>
        <template #message="slotProps">
            <div>
            <InputLabel class="text-slate-800" for="idClientX3" :value="$t('msg.cod-cliente-x3')" />
            <InputMask
                mask="aa99999" 
                placeholder="LB999999"
                id="idClientX3"
                type="text"
                v-model="currUser.idClientX3"
                class="mt-1 block w-full text-sm uppercase"
                required
                autofocus
                name="idClientX3"
            />
            </div>
         </template>

    </ConfirmDialog>

    <AppLayout :title="$t('Gestión')">

        <template #header>
            <ToastNotification @onTesting="testing" />
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
                {{$t('Últimos movimientos')}}
            </h2>

        </template>

        <template #content>
            <div class="py-12 px-6 lg:px-0 lg:columns-2 gap-12">
                <div>         
                    <!-- <Message severity="success">
                        <div class="flex flex-col">
                            <span class="font-bold">¡Tienes clientes pendientes de validación! </span>
                            <span class="text-xs">Success Message Content</span>
                        </div>
                    </Message> -->
                
                    <DataTable :value="_data.users" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20]">
                     <template #empty>
                        <div class="flex justify-center">
                            {{$t('No hay clientes pendientes')}}
                        </div>
                    </template>

                     <template #header>
                        <div class="flex flex-wrap align-items-center">
                            <span class="text-lg font-bold"> {{$t('Validación de clientes')}}</span>
                        </div>
                    </template>
                        <Column :header="$t('Fecha')">
                            <template #body="{data}">
                                {{ moment(data.created_at).format('DD/MM/YYYY') }}
                            </template>
                       
                        </Column>
                        <Column field="raoSocial" :header="$t('Nombre cliente')"></Column>
      
                        <Column field="id" alignFrozen="right" :frozen="true">
                            <template #body="{data}">
                                <div @click="activateUser($event, {id:data.id, name:data.name, idClientX3:currUser.idClientX3})">
                                    <i v-tooltip="$t('Activar usuario')" class="pi pi-check-circle hover:cursor-pointer text-primary-500"></i>
                                </div>
                                <!-- {{ data.id }} -->
                            </template>
                        </Column>
                    </DataTable>

                </div>

                <div class="lg:break-after-column"></div>

                <div>
                    <DataTable :value="_data.orders" paginator :rows="5" :rowsPerPageOptions="[5, 10, 20]">
                    <template #empty>
                        <div class="flex justify-center">
                            {{$t('No hay pedidos pendientes')}}
                        </div>
                    </template>
                    <template #header>
                        <div class="flex flex-wrap align-items-center">
                            <span class="text-lg font-bold"> {{$t('Validación de pedidos')}}</span>
                        </div>
                    </template>
                        <Column :header="$t('Fecha')">
                            <template #body="{data}">
                                {{ moment(data.dataCreacio).format('DD/MM/YYYY') }}
                            </template>
                        </Column>
                        <Column field="idClientX3" :header="$t('Código cliente')" ></Column>
                        <Column field="estat" :header="$t('Estado')" >
                            <template #body="{data}">
                                {{ _status(data.idEstat) }}
                            </template>
                        </Column>                 
                        <Column field="idComandaX3" :header="$t('ID caso')"></Column>
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

