<script setup>
import { ref, onMounted, reactive, computed, watch } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Button from '@/Components/PrimaryButton.vue';
import AltButton from '@/Components/SecondaryButton.vue';
import Dropdown from 'primevue/dropdown';
import MessageBox from '@/Components/MessageBox.vue';
import Checkbox from 'primevue/checkbox';
import { useI18n } from "vue-i18n";
import FileUpload from 'primevue/fileupload';
import { vue3dLoader } from "vue-3d-loader";
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from 'primevue/confirmpopup';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   
import Row from 'primevue/row';    
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';
import _ from 'lodash';
import { usePageLeave } from '@vueuse/core';

const isLeft = usePageLeave();

const page = usePage();

const toast = useToast();
const confirm = useConfirm();

const {t, locale} = useI18n();

const emit = defineEmits(['closeDetail'])

const props = defineProps({
    workDetail: Object,
    uploadedFile: String,
});

const renderFile = ref(null);

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
    materials:[],
    tipusImplants:null,
    marcaImplants:null,
    colorsMaterial:null,
    });

const implantDetail = reactive({
        posicio: '',
        idMarca: '',
        idConexio: '',
        idAngulacions: '',
        analeg: '',
        tipusAnaleg: '',
        enviarCargol: '',
        baseTi: '',
        tipusBaseTi: '',
        tallables: '',
        alcadaGH: '',
});

const addImplant = () => {
    props.workDetail.implantsDetail.push(
            // id: '',
            // idComanda: '',
            // idLiniaCmd:'',
            implantDetail
        )
    }


onMounted(async () => {

      const response1 = await fetch("/tipusarticle/"+locale.value);
      _data.tipusArticle = await response1.json();
    
      const response7 = await fetch("/materials/"+locale.value);
      _data.materials = await response7.json();
    
      const response = await fetch("/colors/"+locale.value);
      _data.colors = await response.json();

      const response3 = await fetch("/incisal/"+locale.value);
      _data.incisal = await response3.json();
    
      const response4 = await fetch("/fitxers/"+locale.value);
      _data.sistemesFitxers = await response4.json();

    //   const response8 = await fetch("/colorsmaterial/"+locale.value);
    //   _data.colorsMaterial = await response8.json();

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

const customBase64Uploader = async (event) => {
    const file = event.files[0];
    const reader = new FileReader();
    let blob = await fetch(file.objectURL).then((r) => r.blob()); //blob:url

    reader.readAsDataURL(blob);

    reader.onloadend = function () {
        const base64data = reader.result;
    };
};

const fileUploadExecute = async (event) => {
    router.post(route('order.fileUpload'), event.files , {
            forceFormData: true,
            preserveScroll: true,
            resetOnSuccess: false,
            onSuccess: () => {
               renderFile.value = page.props.uploadedFile;
               toast.add({ severity: 'success', summary: 'Èxit', detail: 'File uploaded', life: 3000 });
            },
            onError:()=> {
                toast.add({ severity: 'error', summary: 'Error', detail: 'File not uploaded', life: 3000 });
            }
        });
    }
    
watch(()=>props.workDetail.idTipusArticle, (value, oldValue) => {
    
    _.filter(_data.materials, { materials: [{ name: 'Medium', present: true }] })
    
}, { deep: true });


watch(renderFile, (currentValue, oldValue) => {
    console.log(currentValue);
    console.log(oldValue);
});



</script>

<template>
    <div class="w-full px-6 lg:px-0 z-10 top-0 left-0 bg-white dark:bg-gray-900 h-full min-h-fit">

    {{ workDetail }} 

    <!-- step 1 -->
     <MessageBox
        class="w-full md:w-3/5 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('Paso 1')"
        :text="$t('Tipo de solución')"
        >
     </MessageBox>
 

    <div class="w-full bg-primary-300 border border-gray-200 p-6">

        <div class="pt-6 w-full flex gap-6">
            <div class="w-full lg:w-3/5">
    
                <label for="idTipusArticle" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Tipo de producto") }}</label>
                <Dropdown 
                    :loading="!_data.tipusArticle" 
                    v-model="workDetail.idTipusArticle" 
                    :options="_data.tipusArticle" 
                    optionLabel="tipusArticle" 
                    optionGroupLabel="grupTipusArticle" 
                    optionGroupChildren="tipusArticles" 
                    optionValue="idTipusArticle" 
                    :placeholder="t('Seleccionar tipo de artículo')"
                    class="w-full md:w-14rem mb-6">
                    <template #optiongroup="slotProps">
                            <div class="flex align-items-center">
                                <!-- <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 18px" /> -->
                                <div>{{ slotProps.option.grupTipusArticle }}</div>
                            </div>
                        </template>
                </Dropdown>

                <label for="idMaterial" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Material") }}</label>
                <Dropdown 
                    :loading="!_data.materials" 
                    v-model="workDetail.idMaterial" 
                    :options="_data.materials" 
                    optionLabel="material" 
                    optionGroupLabel="grupMaterial" 
                    optionGroupChildren="materials" 
                    optionValue="idMaterial" 
                    :placeholder="t('Seleccionar material')"
                    class="w-full md:w-14rem mb-6">
                        <template #optiongroup="slotProps">
                            <div class="flex align-items-center">
                                <!-- <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 18px" /> -->
                                <div>{{ slotProps.option.grupMaterial }}</div>
                            </div>
                        </template>
                </Dropdown>
                
                <div class="flex gap-6">
                    <div class="w-4/12 overflow-hidden">
                        <label for="idTipusArticle2" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Tipo de artículo") }}</label>
                        <Dropdown 
                            :loading="!_data.tipusArticle" 
                            :options="_data.tipusArticle"
                             v-model="workDetail.tipusArticle" 
                             id="idMaterial" 
                             class="w-full mb-6" 
                             optionLabel="material" 
                             optionValue="idMaterial" 
                             placeholder="Seleccionar">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Cantidad") }}</label>
                        <TextInput
                            id="quantitat"
                            v-model="workDetail.quantitat"
                            type="text"
                            class="mt-1 mb-6 block w-full"
                                />
                     </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="numDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Nº Desmontables") }}</label>
                        <TextInput
                            id="numDesmontables"
                            v-model="workDetail.numDesmontables"
                            type="text"
                            class="mt-1 mb-6 block w-full"
                                />
                     </div>
                     <div class="w-4/12 overflow-hidden">
                        <label for="posDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Pos. Desmontable") }}</label>
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
                        <label for="color" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Color") }}</label>
                        <Dropdown :loading="!_data.colors" :options="_data.colors" v-model="workDetail.idColor" id="idColor" class="w-full mb-6" optionLabel="color" optionValue="idColor" placeholder="Selecciona">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Incisal") }}</label>
                        <Dropdown :loading="!_data.incisal" :options="_data.incisal" v-model="workDetail.idIncisal" id="idColor" class="w-full mb-6" optionLabel="color" optionValue="idIncisal" placeholder="Selecciona">
                        </Dropdown>
                     </div>
                     <div class="w-2/12 overflow-hidden">
                     </div>
                     <div class="w-4/12 overflow-hidden">
                     </div>
                </div>

            </div>
         
            <div class="w-full lg:w-2/5">
        
             </div>
         
        </div>
     
    </div>


    <!-- step 2 -->
    <MessageBox
        class="w-full md:w-3/5 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('Paso 2')"
        :text="$t('Archivos')"
        >
     </MessageBox>

    <div class="w-full bg-primary-300 border border-gray-200 p-6">

        <div class="pt-6 w-full flex gap-6">
            <div class="w-full lg:w-3/5">
    
                <label for="idSistemaFitxer" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("msg.file-system") }}</label>
                <Dropdown :loading="!_data.sistemesFitxers"  :options="_data.sistemesFitxers" v-model="workDetail.idSistemaFitxer" id="idSistemaFitxer" class="w-full mb-6" optionLabel="sistema" optionValue="idSistema" placeholder="Selecciona">
                </Dropdown>

                <div class="flex w-full gap-6">
                    <div class="w-full lg:w-1/2 bg-gray-100 border border-gray-300 p-8">
                        <div class="flex flex-col gap-3 items-center justify-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 50 50">
                                <image id="stl" width="50" height="50" xlink:href="data:image/png;base64,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"/>
                            </svg>

                            <p class="mt-4 font-bold">Añadir fichero de diseño</p>
                             <template v-if="!renderFile">
                                <FileUpload accept="model/stl" class="bg-primary-500 text-sm p-button-sm" mode="basic" name="" chooseLabel="Añadir documento" 
                            :maxFileSize="50000000" :auto="true" :customUpload="true" @uploader="fileUploadExecute($event)">
          
                                </FileUpload>
                            </template>

                            <template v-if="renderFile">
                               <AltButton class="bg-red-500">Borrar fichero</AltButton>
                            </template>

                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 bg-gray-100 border border-gray-300 p-8">
                        <div class="flex flex-col gap-3 items-center justify-center text-center">
                            <svg id="Grupo_724" data-name="Grupo 724" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 51.425 40.219">
                                <defs>
                                    <clipPath id="clip-path">
                                    <rect id="Rectángulo_1593" data-name="Rectángulo 1593" width="51.425" height="40.219" fill="#212121"/>
                                    </clipPath>
                                </defs>
                                <g id="Grupo_724-2" data-name="Grupo 724" clip-path="url(#clip-path)">
                                    <path id="Trazado_511" data-name="Trazado 511" d="M45.069,13.182c.671.03,1.26.015,1.838.089a5.067,5.067,0,0,1,4.281,6.579q-2.563,8.374-5.216,16.72a5.075,5.075,0,0,1-5.212,3.645q-9.476.009-18.951,0-8.214,0-16.428,0A5.113,5.113,0,0,1,.2,36.445,5.514,5.514,0,0,1,.01,35Q-.007,20.154,0,5.307A5.06,5.06,0,0,1,5.22.015C9.034-.016,12.848.014,16.661,0a5.215,5.215,0,0,1,3.881,1.642C21.187,2.3,21.86,2.93,22.491,3.6a3.656,3.656,0,0,0,2.828,1.172c4.733-.018,9.466-.008,14.2-.007,3.427,0,5.549,2.131,5.551,5.57,0,.935,0,1.87,0,2.85M23.126,38.339q8.833,0,17.665,0a3.209,3.209,0,0,0,3.42-2.455q2.568-8.191,5.116-16.388a3.229,3.229,0,0,0-3.207-4.4q-17.841-.011-35.682,0a3.175,3.175,0,0,0-3.221,2.329Q4.611,25.695,2.053,33.981a3.79,3.79,0,0,0-.085,1.784,3.229,3.229,0,0,0,3.494,2.573q8.832.007,17.665,0M43.2,13.214c0-1.041,0-2,0-2.953a3.288,3.288,0,0,0-3.643-3.623c-4.734,0-9.468-.017-14.2.009a5.448,5.448,0,0,1-4.155-1.7c-.611-.633-1.262-1.229-1.865-1.869a3.7,3.7,0,0,0-2.875-1.2C12.78,1.9,9.1,1.882,5.424,1.888a4.671,4.671,0,0,0-1.1.1A3.237,3.237,0,0,0,1.867,5.405q-.008,11.035,0,22.07c0,.119.018.239.028.358a1.034,1.034,0,0,0,.227-.429q1.6-5.116,3.207-10.231a5.164,5.164,0,0,1,5.405-3.959H43.2Z" transform="translate(0 0)" fill="#212121"/>
                                </g>
                                </svg>

                            <p class="mt-4 font-bold">Añadir fichero construcción</p>
                            <template v-if="!constructFile">
                                <FileUpload class="bg-primary-500 text-sm p-button-sm" mode="basic" name="" chooseLabel="Añadir documento" 
                            :maxFileSize="50000000" :auto="true" :customUpload="true" @uploader="fileUploadExecute($event)">
                                    <template #header="{ chooseCallback, uploadCallback, clearCallback, files }">
                                <div class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2">
                                    <!-- <div class="flex gap-2">
                                        <Button @click="chooseCallback()" icon="pi pi-images" rounded outlined></Button>
                                        <Button @click="uploadEvent(uploadCallback)" icon="pi pi-cloud-upload" rounded outlined severity="success" :disabled="!files || files.length === 0"></Button>
                                        <Button @click="clearCallback()" icon="pi pi-times" rounded outlined severity="danger" :disabled="!files || files.length === 0"></Button>
                                    </div> -->
                                    <ProgressBar :value="totalSizePercent" :showValue="false" :class="['md:w-20rem h-1rem w-full md:ml-auto', { 'exceeded-progress-bar': totalSizePercent > 100 }]"
                                        ><span class="white-space-nowrap">{{ totalSize }}B / 1Mb</span></ProgressBar
                                    >
                                </div>
                            </template>
                                </FileUpload>
                            </template>

                            <template v-if="constructFile">
                                <AltButton class="bg-red-500">Borrar fichero</AltButton>
                            </template>
            


                        </div>
                    </div>
                </div>

            </div>
         
            <div class="w-full lg:w-2/5 mt-5 border border-gray-300 bg-white dark:bg-slate-900">
                <vue3dLoader v-if="renderFile"
                :height="300"
                autoPlay="true"
                :filePath="['http://127.0.0.1:8001/getfile/'+renderFile]"
                :backgroundColor="0x000000"
                >
                </vue3dLoader>
             </div>

        </div>
     
    </div>


    <!-- step 3 -->

    <MessageBox
        class="w-full md:w-3/5 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('Paso 3')"
        :text="$t('Selección de la posición de implantes y componentes')"
        >
     </MessageBox>
 
     {{ implantDetail }}
    <div class="w-full bg-primary-300 border border-gray-200 p-6">
        <div class="pt-6 w-full flex gap-6">
              
                <div class="w-32 overflow-hidden">
                    <label for="numDents" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Nº dientes") }}</label>
                    <TextInput
                        id="numDents"
                        v-model="workDetail.numDents"
                        type="text"
                        class="mt-1 mb-6 block w-full"
                        />
                </div>
                <div class="w-32 overflow-hidden">
                    <label for="numImplants" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Nº implantes") }}</label>
                    <TextInput
                        id="numImplants"
                        v-model="workDetail.numImplants"
                        type="text"
                        class="mt-1 mb-6 block w-full"
                        />
                </div>

            </div>
        
            <div class="pt-6 w-full gap-6">
                <label class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Tipo de implantes") }}</label>
                
                <DataTable scrollable class="mt-4" :value="props.workDetail.implantsDetail" tableStyle="min-width: 50rem">
               
                    <Column field="posicio" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Posición') }}
                                <br/>
                                <Dropdown 
                                    :options="_data.posicions" 
                                    optionLabel="posicions" 
                                    optionValue="idPosicions"
                                    class="w-full mt-1 rounded-none"
                                    v-model="implantDetail.posicio"
                                    :pt="{
                                        input: { class: 'p-1 text-xs' },
                                        loadingIcon: { class: 'text-xs' },
                                        wrapper: { class: 'text-xs'  },
                                        trigger: { class: 'text-xs mx-4 my-0 w-auto text-black-900' },
                                    }"
                                    >
                                </Dropdown>
                            </div>
                        </template>
                        <template #body="slotProps">
                            <img :src="`https://primefaces.org/cdn/primevue/images/product/bamboo-watch.jpg`" :alt="slotProps.data.image" class="w-6rem shadow-2 border-round" />
                        </template>
                    </Column>
                    <Column field="idMarca" style="min-width: 12rem">
                        
                        <template #header>
                            <div>
                                {{ $t('Marca') }}
                                <br/>
                                <Dropdown 
                                    :options="_data.marcaImplants" 
                                    optionLabel="marca" 
                                    optionValue="idMarca"
                                    class="w-full mt-1 rounded-none"
                                    v-model="implantDetail.idMarca"    
                                    :pt="{
                                        input: { class: 'p-1 text-xs' },
                                        loadingIcon: { class: 'text-xs' },
                                        wrapper: { class: 'text-xs'  },
                                        trigger: { class: 'text-xs mx-4 my-0 w-auto text-black-900' },
                                    }"
                                    >
                                </Dropdown>
                            </div>
                        </template>
                    </Column>
                    <Column field="idConexio" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Conexión') }}
                                <br/>
                                <Dropdown 
                                    :options="_data.conexions" 
                                    optionLabel="conexio" 
                                    optionValue="idConexio"
                                    class="w-full mt-1 rounded-none"
                                    v-model="implantDetail.idConexio"    
                                    :pt="{
                                        input: { class: 'p-1 text-xs' },
                                        loadingIcon: { class: 'text-xs' },
                                        wrapper: { class: 'text-xs'  },
                                        trigger: { class: 'text-xs mx-4 my-0 w-auto text-black-900' },
                                    }"
                                    >
                                </Dropdown>
                            </div>
                        </template>
                    </Column>
                    <Column field="idAngulacions" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Angulación') }}
                                <br/>
                                <Dropdown 
                                    :options="_data.angulacions" 
                                    optionLabel="angulacions" 
                                    optionValue="idAngulacions"
                                    class="w-full mt-1 rounded-none"
                                    v-model="implantDetail.idAngulacions"    
                                    :pt="{
                                        input: { class: 'p-1 text-xs' },
                                        loadingIcon: { class: 'text-xs' },
                                        wrapper: { class: 'text-xs'  },
                                        trigger: { class: 'text-xs mx-4 my-0 w-auto text-black-900' },
                                    }"
                                    >
                                </Dropdown>
                            </div>
                        </template>
                    </Column>
                    <Column field="analeg" style="min-width: 6rem">
                        <template #header>
                            <div class="text-center">
                                {{ $t('Análogo') }}
                                <br/>
                                <Checkbox v-model="implantDetail.analeg" :binary="true" />
                            </div>
                        </template>
                    </Column> 
                    <Column field="tipusAnaleg" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Tipo análogo') }}
                                <br/>
                            </div>
                        </template>
                    </Column>
                    <Column field="baseTi" style="min-width: 6rem">
                        <template #header>
                            <div class="text-center">
                                {{ $t('Enviar tornillos') }}
                                <br/>
                                <Checkbox v-model="implantDetail.enviarCargol" :binary="true" />

                            </div>
                        </template>
                    </Column>
                    <Column field="baseTi" style="min-width: 6rem">
                        <template #header>
                            <div  class="text-center">
                                {{ $t('Base Ti') }}
                                <br/>
                                <Checkbox class="" v-model="implantDetail.baseTi" :binary="true" />

                            </div>
                        </template>
                    </Column>
                    <Column field="tipusBaseTi" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Tipo base') }}
                                <br/>
                            </div>
                        </template>
                    </Column>
                    <Column field="tallables" style="min-width: 6rem">
                        <template #header>
                            <div class="text-center">
                                {{ $t('Tallable') }}
                                <br/>
                                <Checkbox v-model="implantDetail.tallables" :binary="true" />

                            </div>
                        </template>
                    </Column>
                    <Column field="alcadaGH" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('GH') }}
                                <br/>
                            </div>
                        </template>
                    </Column>
                    <Column style="width: 6rem" alignFrozen="right" frozen="1">
                        <template #header>
                            <Button 
                            class="text-3xl font-bold bg-purple-800" 
                            @click="addImplant()"
                            >
                            {{ $t('+') }}
                        </Button>
                        </template>
                        <template #body="slotProps">
                            <div class="text-center">
                                <i class="pi pi-trash text-primary-500"></i>
                            </div>
                        </template>
                    </Column>

                </DataTable>


            </div>
     
    </div>

    <div class="flex gap-6 px-6 lg:px-0 py-12 justify-end">
        <!-- <Button class="!w-1/12" @click="emit('closeDetail')">Guardar</Button> -->
        <AltButton class="!w-1/12" @click="emit('closeDetail')">Cerrar</AltButton>

    </div>
</div>
</template>

