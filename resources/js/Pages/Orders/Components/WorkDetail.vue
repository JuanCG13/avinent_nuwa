<script setup>
import { ref, onMounted, reactive, computed, normalizeClass } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from 'primevue/dropdown';
import MessageBox from '@/Components/MessageBox.vue';
import { useI18n } from "vue-i18n";
import FileUpload from 'primevue/fileupload';
import { vue3dLoader } from "vue-3d-loader";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';

import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

import { usePageLeave } from '@vueuse/core'

const isLeft = usePageLeave();

const toast = useToast();
const confirm = useConfirm();

const {locale} = useI18n();

const emit = defineEmits(['closeDetail'])

const props = defineProps({
    workDetail:Object,
});

const _data = reactive({ 
    tipusArticle:null,
    aditaments:null,
    colors:null,
    posicions:null,
    incisal:null,
    sistemesFitxers:null,
    zonespulides:null,
    angulacions:null,
    grupsMaterials:null,
    materials:null,
    tipusImplants:null,
    marcaImplants:null,
    colorsMaterial:null,
    });



onMounted(async () => {
    
      const response = await fetch("/colors/"+locale.value);
      _data.colors = await response.json();

      const response1 = await fetch("/tipusarticle/"+locale.value);
      _data.tipusArticle = await response1.json();
    
      const response3 = await fetch("/incisal/"+locale.value);
      _data.incisal = await response3.json();
    
      const response4 = await fetch("/fitxers/"+locale.value);
      _data.sistemesFitxers = await response4.json();
   
      const response7 = await fetch("/materials/"+locale.value);
     // _data.materials = await response7.json();
      _data.materials =  [ { "idGrupMaterial": "GT001", "grupMaterial": "Sobre diente natural", "materials": [{"idMaterial": "001", "material": "CoCr", "idColorDefecte": "001", "minDents": 1, "maxDents": 10}, {"idMaterial": "002", "material": "Titani", "idColorDefecte": "001", "minDents": 1, "maxDents": 10}] }, { "idGrupMaterial": "GT002", "grupMaterial": "Sobre implante", "materials": [{"idMaterial": "003", "material": "Cera d'orella", "idColorDefecte": "001", "minDents": 1, "maxDents": 10}] } ]
    
      const response8 = await fetch("/colorsmaterial/"+locale.value);
      _data.colorsMaterial = await response8.json();

      const response5 = await fetch("/zonespulides/"+locale.value);
      _data.zonespulides = await response5.json();
    
      //linies implants
      const response2 = await fetch("/posicions/"+locale.value);
      _data.posicions = await response2.json();

      const response6 = await fetch("/angulacions/"+locale.value);
      _data.angulacions = await response6.json();
     
      const response9 = await fetch("/marques/"+locale.value);
      _data.marcaImplants = await response9.json();


    });


</script>

<template>
    <div class="absolute z-10 top-0 left-0 bg-white h-full min-h-fit">
        
    <div class="pt-12 px-6 mx-auto lg:px-0">
        <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
            Detalle trabajo {{workDetail.workType}}
        </h2>
    </div>

    {{ workDetail }} 

    <!-- step 1 -->
     <MessageBox
        class="w-1/2 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('msg.step-1')"
        :text="$t('msg.tipo-de-solucion')"
        >
     </MessageBox>
 

    <div class="w-full bg-primary-300 border border-gray-200 p-6">

        <div class="pt-6 w-full flex gap-6">
            <div class="w-3/5">
    
                <label for="idTipusArticle" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.product-type") }}</label>
                <Dropdown :loading="!_data.tipusArticle"  :options="_data.tipusArticle" v-model="workDetail.idTipusArticle" id="idTipusArticle" class="w-full mb-6" optionLabel="grupTipusArticle" optionValue="idGrupTipusArticle" placeholder="Selecciona">
                </Dropdown>

                <label for="idMaterial" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.material") }}</label>
                <Dropdown :loading="!_data.materials" v-model="workDetail.idMaterial" :options="_data.materials" optionLabel="material" optionGroupLabel="grupMaterial" optionGroupChildren="materials" optionValue="idMaterial" class="w-full md:w-14rem mb-6">
                        <template #optiongroup="slotProps">
                            <div class="flex align-items-center">
                                <!-- <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 18px" /> -->
                                <div>{{ slotProps.option.grupMaterial }}</div>
                            </div>
                        </template>
                </Dropdown>
                
                <div class="flex gap-6">
                    <div class="w-4/12 overflow-hidden">
                        <label for="idTipusArticle2" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.article-type") }}</label>
                        <Dropdown :loading="!_data.tipusArticle" :options="_data.tipusArticle" v-model="workDetail.tipusArticle" id="idMaterial" class="w-full mb-6" optionLabel="material" optionValue="idMaterial" placeholder="Selecciona">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.qty") }}</label>
                        <TextInput
                            id="quantitat"
                            v-model="workDetail.quantitat"
                            type="text"
                            class="mt-1 mb-6 block w-full"
                                />
                     </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="numDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.desmontables") }}</label>
                        <TextInput
                            id="numDesmontables"
                            v-model="workDetail.numDesmontables"
                            type="text"
                            class="mt-1 mb-6 block w-full"
                                />
                     </div>
                     <div class="w-4/12 overflow-hidden">
                        <label for="posDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.pos-desmontable") }}</label>
                        <TextInput
                            id="posDesmontables"
                            v-model="workDetail.posDesmontables"
                            type="text"
                            class="mt-1 mb-6 block w-full"
                                />
                    </div>

                 </div>

                 <div class="flex gap-6">
                    <div class="w-4/12 overflow-hidden">
                        <label for="color" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.color") }}</label>
                        <Dropdown :loading="!_data.colors" :options="_data.colors" v-model="workDetail.idColor" id="idColor" class="w-full mb-6" optionLabel="color" optionValue="idColor" placeholder="Selecciona">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.incisal") }}</label>
                        <Dropdown :loading="!_data.incisal" :options="_data.incisal" v-model="workDetail.idIncisal" id="idColor" class="w-full mb-6" optionLabel="color" optionValue="idIncisal" placeholder="Selecciona">
                        </Dropdown>
                     </div>
                     <div class="w-2/12 overflow-hidden">
                    </div>
                     <div class="w-4/12 overflow-hidden">
                     </div>
                </div>

            </div>
         
            <div class="w-2/5">
        
             </div>
         
        </div>
     
    </div>


    <!-- step 2 -->
    <MessageBox
        class="w-1/2 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('msg.step-2')"
        :text="$t('msg.archivos')"
        >
     </MessageBox>

    <div class="w-full bg-primary-300 border border-gray-200 p-6">

        <div class="pt-6 w-full flex gap-6">
            <div class="w-3/5">
    
                <label for="idSistemaFitxer" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.file-system") }}</label>
                <Dropdown :loading="!_data.sistemesFitxers"  :options="_data.sistemesFitxers" v-model="workDetail.idSistemaFitxer" id="idSistemaFitxer" class="w-full mb-6" optionLabel="sistema" optionValue="idSistema" placeholder="Selecciona">
                </Dropdown>


            </div>
         
            <div class="w-2/5">
                <vue3dLoader
                class="mt-5 border border-gray-300"
                :height="300"
                :filePath="['http://127.0.0.1:8000/storage/placeholder.stl']"
                :backgroundColor="0xFFFFFF"
                >
                </vue3dLoader>
             </div>
         
        </div>
     
    </div>


    <!-- step 3 -->



    <div class="flex gap-6 px-6 lg:px-0 py-12 justify-end">
        <!-- <Button class="!w-1/12" @click="emit('closeDetail')">Guardar</Button> -->
        <AltButton class="!w-1/12" @click="emit('closeDetail')">Cerrar</AltButton>

    </div>
</div>
</template>