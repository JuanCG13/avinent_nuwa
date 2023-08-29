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
import MultiSelect from 'primevue/multiselect';

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

const filteredData = reactive ({
    tipusImplants: null,
    tipusArticle: null,
    tipusArticle2: null,
    materialsArticle: null,
    materials: null,
    material: null,
    colors: null,
});

const _data = reactive({ 
    grupsTipusArticle:null,
    tipusArticle:null,
    tipusArticle2:null,
    grupsMaterials:null,
    materials:null,
    tipusArticleMaterials:null,
    colors:null,
    colorsMaterial:null,
    posicions:null,
    incisal:null,
    sistemesFitxers:null,
    zonespulides:null,
    angulacions:null,
    tipusImplants:null,
    marcaImplants:null,
    aditaments:null,
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
            {...implantDetail}
        )
    }
onMounted(async () => {

      const response12 = await fetch("/grupstipusarticle/"+locale.value);
      _data.grupsTipusArticle = await response12.json();
    
      const response1 = await fetch("/tipusarticle/"+locale.value);
      _data.tipusArticle = await response1.json();
    
      const response14 = await fetch("/tipusarticle2/"+locale.value);
      _data.tipusArticle2 = await response14.json();
    
      const response7 = await fetch("/materials/"+locale.value);
      _data.materials = await response7.json();
   
      const response11 = await fetch("/grupsmaterials/"+locale.value);
      _data.grupsMaterials = await response11.json();

      const response13 = await fetch("/materialsarticle/"+locale.value);
      _data.materialsTipusArticle = await response13.json();

      const response = await fetch("/colors/"+locale.value);
      _data.colors = await response.json();

      const response3 = await fetch("/incisal/"+locale.value);
      _data.incisal = await response3.json();
    
      const response4 = await fetch("/fitxers/"+locale.value);
      _data.sistemesFitxers = await response4.json();

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

      const response0 = await fetch("/implants/"+locale.value);
      _data.tipusImplants = await response0.json();

    });


const txtPosicio = (id) => {
    var txt = _.filter(_data.posicions, { 'idPosicions' : id });  
    return txt[0]?.posicions;
};

const txtMarca = (id) => {
    var txt = _.filter(_data.marcaImplants, { 'idMarca' : id });
    return txt[0]?.marca;

};

const txtConexio = (id) => {
    var txt = _.filter(_data.tipusImplants, { 'idTipusImplant' : id });
    return txt[0]?.tipusImplants;
};

const txtAngulacio = (id) => {
    var txt = _.filter(_data.angulacions, { 'idAngulacions' : id });
    return txt[0]?.angulacions;
};


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
 
//filter tipusArticle   
watch(()=>props.workDetail.idTipusArticle, (value, oldValue) => {

    filteredData.tipusArticle2 = _.filter(_data.tipusArticle2, { 'idTipusArticle' : props.workDetail.idTipusArticle })
    filteredData.tipusArticle = _.filter(_data.tipusArticle, { 'idTipusArticle' : props.workDetail.idTipusArticle })
    filteredData.materialsArticle = _.filter(_data.materialsTipusArticle, { 'idTipusArticle' : props.workDetail.idTipusArticle })

    props.workDetail.quantitat = filteredData.tipusArticle[0].minQuantitat 
    props.workDetail.numDesmontables = filteredData.tipusArticle[0].minDesmontables 
    props.workDetail.posDesmontables = []

    // Filtrar _data.grupsMaterials usando el campo idMaterial de filteredData.materialsArticle
    const filteredMaterialsIds = filteredData.materialsArticle.map(item => item.idMaterial);
    filteredData.materials = _.cloneDeep(_data.grupsMaterials).map(grup => {
        grup.materials = _.filter(grup.materials, material => filteredMaterialsIds.includes(material.idMaterial));
        return grup;
    });

    // Eliminar objetos en los que el array "materials" esté vacío
    filteredData.materials = _.filter(filteredData.materials, grup => grup.materials.length > 0);

}, { deep: true });

//filter tipusImplants on Brand change    
watch(()=>implantDetail.idMarca, (value, oldValue) => {

    filteredData.tipusImplants = _.filter(_data.tipusImplants, { 'idMarca' : implantDetail.idMarca })
    
}, { deep: true });

watch(()=>props.workDetail.idMaterial, (value, oldValue) => {

    filteredData.material = _.filter(_data.materials, { 'idMaterial' : props.workDetail.idMaterial })
    filteredData.colors = _.filter(_data.colorsMaterial, { 'idMaterial' : props.workDetail.idMaterial })

    props.workDetail.idColor = filteredData.material[0].idColorDefecte 


}, { deep: true });



watch(renderFile, (currentValue, oldValue) => {
    console.log(currentValue);
    console.log(oldValue);
});



</script>

<template>
    <!-- {{ _data.grupsMaterials }} -->
    <!-- {{filteredData.materialsArticle}} -->
    <!-- {{ _data.grupsTipusArticle }} -->
    <!-- {{ filteredData.materialsArticle }} -->
    <!-- {{ filteredData.materials }} -->
    <!-- {{ _data.materials }} -->
    <!-- {{ props.workDetail.idTipusArticle }} -->
    <!-- {{ _data.grupsTipusArticle }} -->
    <!-- {{ filteredData.tipusArticle2 }} -->
    <!-- {{ filteredData.tipusArticle }} -->
    <!-- {{ _data.colorsMaterial }} -->
    <!-- {{ filteredData.colors }} -->
    <!-- {{ _data.incisal }} -->
    <!-- {{ _data.posicions }} -->
    <div class="w-full px-6 lg:px-0 z-10 top-0 left-0 bg-white dark:bg-gray-900 h-full min-h-fit">

    <!-- step 1 -->
     <MessageBox
        class="w-full md:w-3/5 mt-12 bg-gray-100 dark:bg-gray-200"
        :title="$t('Paso 1')"
        :text="$t('Tipo de solución')"
        >
     </MessageBox>
 
    <div class="w-full bg-primary-300 border border-gray-200 p-6">
        <!-- {{ workDetail.posDesmontables }} -->
    
        <div class="pt-6 w-full flex gap-6">
            <div class="w-full lg:w-3/5">
                <label for="idTipusArticle" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Tipo de producto") }}</label>
                <Dropdown 
                    :loading="!_data.grupsTipusArticle" 
                    v-model="workDetail.idTipusArticle" 
                    :options="_data.grupsTipusArticle" 
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
                    :loading="!_data.grupsMaterials" 
                    v-model="workDetail.idMaterial" 
                    :options="filteredData.materials" 
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
                            :loading="!_data.tipusArticle2" 
                            :options="filteredData.tipusArticle2"
                             v-model="workDetail.tipusArticle2" 
                             id="idTipusArticle2" 
                             class="w-full mb-6" 
                             optionLabel="tipusArticle2" 
                             optionValue="id" 
                             placeholder="Seleccionar">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <template v-if="filteredData.tipusArticle">
                            <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Cantidad") }}</label>
                            <TextInput
                                id="quantitat"
                                v-model="workDetail.quantitat"
                                type="number"
                                :min="parseInt(filteredData.tipusArticle[0].minQuantitat)" 
                                :max="parseInt(filteredData.tipusArticle[0].maxQuantitat)"
                                :disabled="filteredData.tipusArticle[0].minQuantitat === filteredData.tipusArticle[0].maxQuantitat"
                                class="mt-1 mb-6 block w-full"
                                    />
                                </template>
                        <template v-else>
                            
                            <label for="quantitat" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Cantidad") }}</label>
                            <TextInput
                                id="quantitat"
                                v-model="workDetail.quantitat"
                                type="number"
                                :disabled="true"
                                class="mt-1 mb-6 block w-full"
                                    />
                        </template>
                     </div>
                     <div class="w-2/12 overflow-hidden">
                        <template v-if="filteredData.tipusArticle">
                            <label for="numDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Nº Desmontables") }}</label>
                            <TextInput
                                id="numDesmontables"
                                v-model="workDetail.numDesmontables"
                                :min="parseInt(filteredData.tipusArticle[0].minDesmontables)" 
                                :max="parseInt(filteredData.tipusArticle[0].maxDesmontables)"
                                :disabled="filteredData.tipusArticle[0].permetDents"
                                type="number"
                                class="mt-1 mb-6 block w-full"
                                    />
                                </template>
                        <template v-else>
                            <label for="numDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Nº Desmontables") }}</label>
                            <TextInput
                                id="numDesmontables"
                                v-model="workDetail.numDesmontables"
                                :disabled="true"
                                type="text"
                                class="mt-1 mb-6 block w-full"
                                    />

                        </template>
                     </div>
                     <div class="w-4/12 overflow-hidden">
                        <label for="posDesmontables" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Pos. Desmontable") }}</label>
                        <MultiSelect v-model="workDetail.posDesmontables" 
                            :disabled="parseInt(workDetail.numDesmontables) <= 0"
                            :options="_data.posicions" 
                            optionLabel="posicions"
                            optionValue="idPosicions" 
                            :maxSelectedLabels="3"
                            display="chip"
                            :selectionLimit="parseInt(workDetail.numDesmontables)" 
                            class="w-full md:w-20rem" />
                    </div>

                 </div>

                 <div class="flex gap-6">
                    <div class="w-4/12 overflow-hidden">
                        <label for="color" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Color") }}</label>
                        <Dropdown 
                            :loading="!_data.colors" 
                            :options="filteredData.colors" 
                            v-model="workDetail.idColor"
                            id="idColor" 
                            class="w-full mb-6" 
                            optionLabel="color" 
                            optionValue="idColor" 
                            placeholder="Selecciona">
                        </Dropdown>
                    </div>
                     <div class="w-2/12 overflow-hidden">
                        <label for="incisal" class="block text-sm font-bold text-gray-700 dark:text-slate-300"> {{ $t("Incisal") }}</label>
                        <Dropdown 
                        :loading="!_data.incisal" 
                        :options="_data.incisal" 
                        v-model="workDetail.idIncisal" 
                        id="incisal" 
                        class="w-full mb-6" 
                        optionLabel="Incisal" 
                        optionValue="idIncisal" 
                        placeholder="Selecciona">
                        </Dropdown>
                     </div>
                     <div class="w-2/12 overflow-hidden">
                     </div>
                     <div class="w-4/12 overflow-hidden">
                     </div>
                </div>

            </div>
         
            <div class="mt-4 flex justify-center items-center border border-gray-300 bg-white p-8 w-full lg:w-2/5">
                <svg id="Grupo_688" data-name="Grupo 688" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="450.267" height="166.391" viewBox="0 0 450.267 166.391">
                <defs>
                    <clipPath id="clip-path">
                    <rect id="Rectángulo_1581" data-name="Rectángulo 1581" width="450.267" height="166.391" fill="none"/>
                    </clipPath>
                </defs>
                <g id="Grupo_687" data-name="Grupo 687" transform="translate(0 0)" clip-path="url(#clip-path)">
                    <path id="Trazado_465" data-name="Trazado 465" d="M13.074,17.538,13.89,2.3A2.029,2.029,0,0,1,15.916.375h7.846a1.676,1.676,0,0,1,1.671,1.748L24.422,25.656" transform="translate(34.326 0.985)" fill="#fff"/>
                    <path id="Trazado_466" data-name="Trazado 466" d="M25.409,28h-.062a1.358,1.358,0,0,1-1.3-1.418L25.061,3.049l-.315-.33H16.9a.671.671,0,0,0-.667.634L15.417,18.6a1.337,1.337,0,0,1-1.428,1.283A1.361,1.361,0,0,1,12.7,18.45l.816-15.242A3.392,3.392,0,0,1,16.9,0h7.846a3.01,3.01,0,0,1,2.19.935,3.047,3.047,0,0,1,.841,2.23L26.765,26.7A1.357,1.357,0,0,1,25.409,28" transform="translate(33.343 0)" fill="#333"/>
                    <path id="Trazado_467" data-name="Trazado 467" d="M116.789,18.49l-.816-15.242a2.029,2.029,0,0,0-2.027-1.922H106.1a1.676,1.676,0,0,0-1.671,1.748l.856,28.91" transform="translate(274.179 3.484)" fill="#fff"/>
                    <path id="Trazado_468" data-name="Trazado 468" d="M106.27,34.329a1.362,1.362,0,0,1-1.36-1.32L104.055,4.1A3.041,3.041,0,0,1,107.086.952h7.846a3.391,3.391,0,0,1,3.383,3.2L119.13,19.4a1.36,1.36,0,0,1-2.716.145L115.6,4.306a.669.669,0,0,0-.667-.634h-7.846l-.312.344.856,28.914a1.361,1.361,0,0,1-1.32,1.4Z" transform="translate(273.193 2.5)" fill="#333"/>
                    <path id="Trazado_469" data-name="Trazado 469" d="M47.534,21.426V3.146c0-.547.605-.993,1.352-.993h11.25c.765,0,1.381.453,1.381,1.012V23.406" transform="translate(124.802 5.653)" fill="#fff"/>
                    <path id="Trazado_470" data-name="Trazado 470" d="M62.5,25.75a1.36,1.36,0,0,1-1.36-1.36V4.53L49.878,4.5V22.411a1.36,1.36,0,0,1-2.719,0V4.131a2.525,2.525,0,0,1,2.712-2.353h11.25a2.548,2.548,0,0,1,2.741,2.371V24.39a1.36,1.36,0,0,1-1.36,1.36" transform="translate(123.818 4.668)" fill="#333"/>
                    <path id="Trazado_471" data-name="Trazado 471" d="M83.8,21.3V3.024c0-.547-.605-.993-1.352-.993H71.2c-.765,0-1.381.453-1.381,1.012V23.284" transform="translate(183.315 5.332)" fill="#fff"/>
                    <path id="Trazado_472" data-name="Trazado 472" d="M70.8,25.628a1.36,1.36,0,0,1-1.36-1.36V4.027a2.549,2.549,0,0,1,2.737-2.371h11.25a2.527,2.527,0,0,1,2.716,2.357V22.289a1.36,1.36,0,0,1-2.719,0V4.4L72.182,4.375h-.018V24.268a1.36,1.36,0,0,1-1.36,1.36" transform="translate(182.331 4.348)" fill="#333"/>
                    <path id="Trazado_473" data-name="Trazado 473" d="M2.309,17.761.641,12.453a5.663,5.663,0,0,1,5.91-7.342L122.437,15.618q2.393.218,4.793.254l208.258,3.27a47.686,47.686,0,0,0,8.288-.595l88.851-14.3a4.643,4.643,0,0,1,5.1,6.182l-1.537,4.2a15.808,15.808,0,0,1-7.592,8.6l-56.37,29.037a30.768,30.768,0,0,1-14.078,3.412H218.384l-135.5-8.549a49.475,49.475,0,0,1-11.37-2.077L11.13,26.527a13.375,13.375,0,0,1-8.821-8.767" transform="translate(0.983 11.005)" fill="#fff"/>
                    <path id="Trazado_474" data-name="Trazado 474" d="M359.131,58.032H219.37L83.778,49.48a50.741,50.741,0,0,1-11.685-2.132L11.713,28.81a14.712,14.712,0,0,1-9.72-9.655L.326,13.84a7.021,7.021,0,0,1,7.331-9.1L123.543,15.251c1.559.141,3.125.221,4.691.25l208.258,3.267a46.918,46.918,0,0,0,8.052-.58L433.4,3.9a6,6,0,0,1,6.588,7.994l-1.537,4.2a17.122,17.122,0,0,1-8.244,9.347l-56.37,29.033a32.259,32.259,0,0,1-14.7,3.564M4.589,18.34a12,12,0,0,0,7.922,7.871L72.887,44.748a48.158,48.158,0,0,0,11.062,2.019l135.5,8.549,139.678,0a29.486,29.486,0,0,0,13.454-3.263l56.37-29.033a14.425,14.425,0,0,0,6.939-7.86l1.537-4.2a3.286,3.286,0,0,0-3.6-4.376l-88.851,14.3a48.637,48.637,0,0,1-8.527.613L128.191,18.22c-1.631-.029-3.267-.112-4.891-.261L7.414,7.452a4.3,4.3,0,0,0-4.492,5.576Z" transform="translate(0.001 10.019)" fill="#333"/>
                    <path id="Trazado_475" data-name="Trazado 475" d="M51.861,75.015c-3.321,4.633-9.445,7.994-10.826,8.19a51.7,51.7,0,0,1-18.4-1.08C15.008,80.152,10.287,64.5,9.5,61.716c-.08-.272-.116-.424-.116-.424l.185-20.038.083-9.176c.272-3.789-1.08-17.316,8.658-23.809s26.651,25.48,31.379,30.842a17.887,17.887,0,0,1,3.713,7.371Z" transform="translate(24.649 19.438)" fill="#fff"/>
                    <path id="Trazado_476" data-name="Trazado 476" d="M32.3,39.885c-4.246-6.457-22.174-33.4-25.071-31.9C5.823,8.709.733,16.373.733,34.5V49.376s.134,5.866,2.781,9.89c3.089,4.7,7.113,12.08,8.3,12.08,5.152,0,16.9-7.494,20.412-11" transform="translate(1.925 20.803)" fill="#fff"/>
                    <path id="Trazado_477" data-name="Trazado 477" d="M55.091,14.441c6.392-4.09,15.358-5,22.732-4.557a45.816,45.816,0,0,1,32.837,16.547,41.888,41.888,0,0,1,7.581,13.364c1.787,5.435,2.23,11.3,2.563,16.982.428,7.255.352,14.517.214,21.779-.076,3.832-.16,7.668-.178,11.5-.011,2.65.1,4.992-.794,7.508-.975,2.752-2.919,5.743-6.178,5.765-3.549.025-7.084.254-10.626.5a140.226,140.226,0,0,1-22.177-.134c-5.232-.46-10.46-.616-15.695-.946a43.565,43.565,0,0,1-10.967-2c-4.7-1.563-9.387-4.111-12.356-8.2-3.129-4.318-3.687-9.26-4.206-14.441-1.378-13.777.754-27.764,4.43-41.066,2.483-8.991,4.7-17.073,12.82-22.594" transform="translate(98.244 25.686)" fill="#fff"/>
                    <path id="Trazado_478" data-name="Trazado 478" d="M100.433,46.482a17.921,17.921,0,0,1,3.713-7.374c4.724-5.359,21.641-37.329,31.379-30.839s8.386,20.02,8.658,23.805l.083,9.176.185,20.042s-.04.149-.12.421c-.78,2.784-5.5,18.439-13.135,20.412a51.7,51.7,0,0,1-18.4,1.08c-1.378-.2-7.5-3.557-10.822-8.19Z" transform="translate(263.691 19.438)" fill="#fff"/>
                    <path id="Trazado_479" data-name="Trazado 479" d="M112.591,60.347c3.52,3.506,15.264,11,20.412,11,1.193,0,5.214-7.385,8.306-12.08,2.647-4.024,2.781-9.89,2.781-9.89V34.5c0-18.124-5.094-25.788-6.493-26.514-2.9-1.5-20.829,25.444-25.074,31.9" transform="translate(295.431 20.803)" fill="#fff"/>
                    <path id="Trazado_480" data-name="Trazado 480" d="M126.49,14.441c8.125,5.522,10.336,13.6,12.82,22.594,3.676,13.3,5.808,27.289,4.43,41.066-.518,5.181-1.077,10.123-4.206,14.441-2.969,4.093-7.657,6.642-12.356,8.2a43.565,43.565,0,0,1-10.967,2c-5.235.33-10.463.486-15.695.946a140.268,140.268,0,0,1-22.181.134c-3.539-.25-7.073-.479-10.623-.5-3.259-.022-5.2-3.013-6.178-5.765-.892-2.516-.783-4.858-.794-7.508-.018-3.832-.1-7.668-.178-11.5-.138-7.262-.214-14.524.214-21.779.334-5.678.776-11.547,2.563-16.982a41.888,41.888,0,0,1,7.581-13.364A45.816,45.816,0,0,1,103.758,9.884c7.374-.439,16.34.468,22.732,4.557" transform="translate(158.727 25.686)" fill="#fff"/>
                    <path id="Trazado_481" data-name="Trazado 481" d="M35.777,85.926a50.821,50.821,0,0,1-12.519-1.5c-8.114-2.1-12.849-16.877-14.1-21.358L9.024,62.6l.228-29.552c.04-.569.044-1.229.054-2.012.058-5.482.178-16.891,9.209-22.913a6.508,6.508,0,0,1,5.076-.939c7.82,1.592,17.152,15.786,23.327,25.176A82.372,82.372,0,0,0,51.668,39.2a19.377,19.377,0,0,1,4.01,7.936,1.393,1.393,0,0,1,.04.406L54.176,76.072a1.375,1.375,0,0,1-.254.718c-3.455,4.822-9.93,8.491-11.739,8.745a47.968,47.968,0,0,1-6.406.392M22.112,9.75a3.678,3.678,0,0,0-2.088.634c-7.835,5.224-7.947,15.666-8,20.68-.011.852-.018,1.566-.058,2.1L11.7,62.288l.062.029c.511,1.816,5.148,17.66,12.171,19.476A50.912,50.912,0,0,0,41.8,82.844c1.051-.174,6.533-3.154,9.68-7.324L52.991,47.6a16.532,16.532,0,0,0-3.361-6.609,79.985,79.985,0,0,1-4.981-7.142c-5.569-8.466-14.886-22.638-21.6-24a4.779,4.779,0,0,0-.939-.1M52.817,76h0Z" transform="translate(23.693 18.453)" fill="#333"/>
                    <path id="Trazado_482" data-name="Trazado 482" d="M12.8,73.716c-1.443,0-2.6-1.639-6.562-8.1C5.263,64.021,4.274,62.4,3.36,61.019c-2.824-4.3-2.995-10.347-3-10.6V35.5c0-17.936,4.96-26.543,7.226-27.717,1.349-.7,4.148-2.161,26.833,32.358a1.361,1.361,0,1,1-2.273,1.5C20.8,24.365,11.282,11.741,8.628,10.381,7.384,11.7,3.077,19.072,3.077,35.5V50.386c0,.022.163,5.5,2.556,9.14.925,1.407,1.932,3.049,2.922,4.67,1.566,2.549,3.676,5.993,4.539,6.794,4.815-.286,15.815-7.266,19.161-10.6a1.359,1.359,0,1,1,1.918,1.925c-3.3,3.288-15.4,11.4-21.373,11.4" transform="translate(0.94 19.798)" fill="#333"/>
                    <path id="Trazado_483" data-name="Trazado 483" d="M93.771,106.548c-4.006,0-7.929-.17-11.837-.511-3.321-.29-6.642-.46-9.963-.631-1.9-.1-3.8-.2-5.7-.315a44.828,44.828,0,0,1-11.312-2.07c-5.873-1.951-10.257-4.88-13.027-8.694-3.415-4.717-3.97-10.235-4.456-15.1-1.258-12.544.207-26.14,4.47-41.567C44.46,28.57,46.806,20.082,55.315,14.3l.029-.022C63.019,9.365,73.4,9.184,78.892,9.51a47.458,47.458,0,0,1,33.8,17.04,43.056,43.056,0,0,1,7.824,13.8c1.809,5.511,2.273,11.341,2.629,17.334.439,7.476.348,14.908.214,21.884l-.036,1.874c-.062,3.2-.123,6.4-.138,9.6v.841A20.149,20.149,0,0,1,122.315,99c-1.494,4.213-4.209,6.646-7.45,6.667-3.5.025-6.979.25-10.536.5-3.611.254-7.113.377-10.558.377M56.827,16.558c-7.668,5.221-9.782,12.871-12.233,21.724C40.4,53.477,38.96,66.746,40.182,78.95c.475,4.749.968,9.658,3.955,13.777,2.425,3.35,6.356,5.942,11.681,7.712a42.209,42.209,0,0,0,10.623,1.94c1.893.12,3.778.214,5.667.312,3.354.17,6.707.344,10.064.638a137.975,137.975,0,0,0,21.964.131c3.6-.254,7.135-.482,10.71-.508,2.777-.018,4.267-3.053,4.905-4.858a17.776,17.776,0,0,0,.718-6.211V91.03c.014-3.212.076-6.424.138-9.64l.036-1.878c.131-6.918.225-14.292-.21-21.67-.341-5.8-.79-11.446-2.5-16.641A40.336,40.336,0,0,0,110.6,28.276a44.732,44.732,0,0,0-31.865-16.05c-5.163-.315-14.883-.156-21.906,4.333" transform="translate(97.255 24.701)" fill="#333"/>
                    <path id="Trazado_484" data-name="Trazado 484" d="M120,85.926a48.05,48.05,0,0,1-6.41-.392c-1.809-.257-8.281-3.923-11.736-8.745a1.344,1.344,0,0,1-.254-.718l-1.544-28.533a1.429,1.429,0,0,1,.04-.41,19.444,19.444,0,0,1,4.01-7.936,80.651,80.651,0,0,0,4.749-6.834c6.174-9.39,15.506-23.584,23.327-25.176a6.513,6.513,0,0,1,5.079.939c9.031,6.022,9.151,17.432,9.209,22.913.007.783.014,1.439.047,1.929l.272,29.3-.17.819c-1.254,4.467-5.989,19.248-14.1,21.344A50.86,50.86,0,0,1,120,85.926M104.3,75.521c3.143,4.166,8.625,7.15,9.677,7.324a50.882,50.882,0,0,0,17.867-1.055c7.023-1.813,11.656-17.656,12.164-19.458l.105-.381-.308-28.877c-.033-.446-.044-1.157-.051-2.009-.054-5.018-.167-15.456-8-20.68a3.83,3.83,0,0,0-3.027-.537c-6.715,1.367-16.032,15.539-21.6,24a79.981,79.981,0,0,1-4.982,7.142,16.5,16.5,0,0,0-3.365,6.609Z" transform="translate(262.705 18.453)" fill="#333"/>
                    <path id="Trazado_485" data-name="Trazado 485" d="M133.988,73.714c-5.975,0-18.073-8.11-21.373-11.4a1.359,1.359,0,0,1,1.918-1.925c3.346,3.332,14.346,10.311,19.161,10.6.863-.8,2.973-4.246,4.539-6.794.99-1.621,2-3.263,2.922-4.67,2.393-3.636,2.556-9.118,2.556-9.173V35.5c0-16.351-4.264-23.726-5.558-25.114-2.259,1.207-10.358,11.243-23.508,31.252a1.375,1.375,0,0,1-1.885.388,1.361,1.361,0,0,1-.388-1.885c22.7-34.53,25.495-33.05,26.833-32.358,2.266,1.175,7.226,9.782,7.226,27.717V50.383c-.007.286-.178,6.337-3,10.634-.914,1.385-1.9,3-2.879,4.594-3.959,6.464-5.119,8.1-6.562,8.1" transform="translate(294.449 19.8)" fill="#333"/>
                    <path id="Trazado_486" data-name="Trazado 486" d="M89.783,106.549c-3.444,0-6.947-.127-10.554-.381-3.56-.247-7.044-.471-10.539-.5-3.241-.025-5.957-2.454-7.45-6.671a20.119,20.119,0,0,1-.874-7.117v-.838c-.015-3.2-.076-6.4-.138-9.6l-.036-1.874c-.134-6.976-.225-14.412.214-21.887.355-5.989.819-11.819,2.629-17.33a43.018,43.018,0,0,1,7.824-13.8,47.445,47.445,0,0,1,33.8-17.04c5.5-.326,15.873-.145,23.548,4.768l.033.022c8.506,5.779,10.851,14.27,13.338,23.258,4.289,15.525,5.754,29.12,4.5,41.661-.486,4.873-1.041,10.391-4.456,15.1-2.77,3.818-7.153,6.743-13.03,8.7a45.061,45.061,0,0,1-11.308,2.07c-1.9.12-3.8.218-5.7.315-3.321.167-6.642.337-9.963.627-3.9.344-7.831.515-11.837.515m18.374-94.424c-1.24,0-2.367.044-3.332.1A44.712,44.712,0,0,0,72.96,28.277,40.31,40.31,0,0,0,65.618,41.2c-1.708,5.2-2.157,10.837-2.5,16.638-.435,7.382-.341,14.752-.21,21.673l.036,1.874c.062,3.216.123,6.432.138,9.644v.852A17.755,17.755,0,0,0,63.8,98.09c.638,1.809,2.128,4.84,4.905,4.862,3.575.025,7.106.254,10.71.5a137.967,137.967,0,0,0,21.964-.131c3.357-.294,6.711-.464,10.065-.638,1.889-.094,3.774-.192,5.667-.308a42.28,42.28,0,0,0,10.619-1.94c5.33-1.769,9.26-4.365,11.689-7.712,2.984-4.119,3.477-9.031,3.952-13.777,1.222-12.2-.214-25.473-4.387-40.57-2.476-8.955-4.59-16.6-12.258-21.822-5.71-3.651-13.193-4.434-18.57-4.434" transform="translate(157.744 24.703)" fill="#333"/>
                    <path id="Trazado_487" data-name="Trazado 487" d="M73.637,30.853c2.44,10.257,2.585,21.318,2.585,31.807,0,5.935.054,12.051-1.153,17.892-1.088,5.239-3.843,11.228-9.706,12.486-3.154.678-6.743.069-9.894-.352a102.486,102.486,0,0,1-12.892-2.469C34.5,88.046,28.126,82.989,24.892,75.136a43.861,43.861,0,0,1-2.556-23.345A96.658,96.658,0,0,1,33.6,21.2a78.089,78.089,0,0,1,4.133-6.715c1.084-1.523,2.273-3.325,4.126-3.974,4.057-1.425,8.85.511,12.508,2.259a36.828,36.828,0,0,1,7.871,4.757c4.434,3.727,9.39,7.9,11.446,13.505" transform="translate(57.111 26.289)" fill="#fff"/>
                    <path id="Trazado_488" data-name="Trazado 488" d="M63.179,95.688a44.57,44.57,0,0,1-6.015-.544l-.9-.123a101.4,101.4,0,0,1-13.059-2.5c-8.868-2.382-15.3-7.875-18.592-15.88a45.282,45.282,0,0,1-2.636-24.1A98.259,98.259,0,0,1,33.4,21.51a79.02,79.02,0,0,1,4.209-6.827c1.265-1.795,2.621-3.716,4.782-4.47,4.43-1.552,9.332.3,13.545,2.317A38.5,38.5,0,0,1,64.1,17.471c4.434,3.727,9.452,7.944,11.707,13.7a1.293,1.293,0,0,1,.138.352l.007.025a1.362,1.362,0,0,1,.069.3c2.346,10.072,2.542,20.785,2.545,31.792v.714c0,5.757.007,11.71-1.182,17.453-.91,4.391-3.517,11.986-10.753,13.541a16.522,16.522,0,0,1-3.448.33M45.929,12.355a7.86,7.86,0,0,0-2.636.424c-1.338.468-2.328,1.867-3.285,3.223a77.559,77.559,0,0,0-4.242,6.852A95.61,95.61,0,0,0,24.658,53.016,42.474,42.474,0,0,0,27.13,75.607c2.962,7.193,8.763,12.131,16.783,14.285a98.7,98.7,0,0,0,12.718,2.436l.9.123c2.766.381,5.9.812,8.524.247,5.728-1.229,7.886-7.69,8.658-11.431,1.135-5.467,1.131-11.279,1.128-16.9V63.65c0-10.887-.2-21.478-2.5-31.307-1.969-5.2-6.762-9.234-11-12.791a35.918,35.918,0,0,0-7.581-4.568c-2.821-1.352-5.96-2.629-8.835-2.629" transform="translate(56.13 25.299)" fill="#333"/>
                    <path id="Trazado_489" data-name="Trazado 489" d="M90.908,27.894c2.679-5.333,8.074-8.915,12.9-12.117a36.748,36.748,0,0,1,8.361-3.832c3.832-1.323,8.814-2.7,12.682-.827,1.766.856,2.741,2.781,3.644,4.42,1.265,2.3,2.32,4.724,3.35,7.135a96.681,96.681,0,0,1,7.722,31.68,43.828,43.828,0,0,1-5.188,22.9C130.274,84.692,123.367,89,115.1,90.231a101.991,101.991,0,0,1-13.088.993c-3.176.058-6.812.257-9.869-.776-5.685-1.914-7.744-8.176-8.226-13.505-.54-5.942.21-12.011.881-17.907,1.2-10.423,2.592-21.394,6.182-31.31" transform="translate(219.834 26.79)" fill="#fff"/>
                    <path id="Trazado_490" data-name="Trazado 490" d="M99.707,93.627a22.113,22.113,0,0,1-7.023-.9c-7.008-2.364-8.734-10.206-9.14-14.673-.533-5.852.149-11.776.809-17.5l.076-.682c1.251-10.927,2.661-21.547,6.134-31.292a1.575,1.575,0,0,1,.109-.3l.011-.022a1.293,1.293,0,0,1,.17-.33c2.9-5.471,8.361-9.089,13.193-12.291a38.131,38.131,0,0,1,8.661-3.984c4.416-1.526,9.5-2.81,13.723-.765,2.059,1,3.187,3.06,4.1,4.713a80.562,80.562,0,0,1,3.553,7.534,98.307,98.307,0,0,1,7.828,32.13A45.3,45.3,0,0,1,136.554,78.9c-4.184,7.581-11.2,12.305-20.27,13.665a101.773,101.773,0,0,1-13.262,1l-.914.018c-.772.018-1.584.036-2.4.036m-6.53-64.27c-3.415,9.51-4.807,20.006-6.047,30.821l-.076.682c-.645,5.594-1.309,11.377-.8,16.949C86.6,81.616,88,88.279,93.555,90.15c2.545.859,5.565.787,8.491.721l.921-.018a98.207,98.207,0,0,0,12.911-.979c8.208-1.225,14.535-5.475,18.3-12.283a42.51,42.51,0,0,0,5.018-22.17A95.642,95.642,0,0,0,131.579,24.2a76.809,76.809,0,0,0-3.285-7.015c-.95-1.729-1.773-3.234-3.049-3.85-3.325-1.606-7.755-.453-11.649.888a35.956,35.956,0,0,0-8.049,3.68c-4.608,3.053-9.825,6.508-12.37,11.457" transform="translate(218.847 25.798)" fill="#333"/>
                    <path id="Trazado_491" data-name="Trazado 491" d="M103.542,33.26c-2.03.46-3.749.493-5.217,1.53a13.647,13.647,0,0,0-2.487-1.653c-2.487-1.3-6-1.486-10.949-1.606-13.636-.344-18.175,6.7-19.255,13.574-.685,4.376.859,21.177,4.213,26.028s10.4,11.145,31.343,11.145S125.433,73.986,128.62,70.8s4.416-9.064,4.416-17.116c0-11.286-.33-27.094-29.494-20.423" transform="translate(171.905 82.753)" fill="#fff"/>
                    <path id="Trazado_492" data-name="Trazado 492" d="M123.4,33.26c-2.03.46-3.749.493-5.217,1.53-.689-.58-1.508-.352-2.487-.863a24.723,24.723,0,0,0-10.949-2.4c-13.636-.344-18.175,6.7-19.255,13.574-.685,4.376.859,21.177,4.213,26.028s10.4,11.145,31.343,11.145,24.244-8.292,27.431-11.478,4.416-9.064,4.416-17.116c0-11.286-.33-27.094-29.494-20.423" transform="translate(224.043 82.753)" fill="#fff"/>
                    <path id="Trazado_493" data-name="Trazado 493" d="M143.251,33.26a14.515,14.515,0,0,0-5.217,2.32,13.649,13.649,0,0,0-2.487-1.653,24.724,24.724,0,0,0-10.949-2.4c-13.636-.344-18.175,6.7-19.255,13.574-.685,4.376.859,21.177,4.213,26.028s10.4,11.145,31.343,11.145,24.244-8.292,27.431-11.478,4.416-9.064,4.416-17.116c0-11.286-.33-27.094-29.494-20.423" transform="translate(276.162 82.753)" fill="#fff"/>
                    <path id="Trazado_494" data-name="Trazado 494" d="M141.881,84.621c-21.829,0-28.983-6.693-32.463-11.729-3.633-5.253-5.152-22.442-4.438-27.014.892-5.67,4.8-15.122,20.633-14.723a26.345,26.345,0,0,1,11.544,2.552,15.088,15.088,0,0,1,1.925,1.186,15.95,15.95,0,0,1,4.851-1.972c11.8-2.7,19.988-2.048,25.049,1.983,6.1,4.865,6.1,13.476,6.1,19.763,0,9.053-1.526,14.8-4.811,18.081-.424.428-.852.95-1.331,1.534-3.165,3.868-8.458,10.34-27.061,10.34M124.613,33.863c-9.952,0-15.648,4.18-16.942,12.436-.638,4.046.812,20.459,3.984,25.045,3.132,4.532,9.673,10.558,30.226,10.558,17.312,0,21.913-5.62,24.955-9.343.544-.66,1.03-1.251,1.512-1.733,2.7-2.7,4.017-7.987,4.017-16.159,0-5.732,0-13.589-5.076-17.635-4.314-3.437-11.968-3.926-22.754-1.461a12.978,12.978,0,0,0-2.871,1.008,13.271,13.271,0,0,0,2.755.975,1.359,1.359,0,1,1-.605,2.65,15.156,15.156,0,0,1-5.67-2.6l-.007,0a12.114,12.114,0,0,0-2.237-1.486,23.692,23.692,0,0,0-10.351-2.244q-.473-.011-.935-.011" transform="translate(275.179 81.766)" fill="#333"/>
                    <path id="Trazado_495" data-name="Trazado 495" d="M122.03,84.621c-21.829,0-28.983-6.693-32.463-11.729-3.633-5.253-5.152-22.442-4.438-27.014.892-5.67,4.8-15.122,20.633-14.723a26.37,26.37,0,0,1,11.544,2.552,2.949,2.949,0,0,0,.877.254,5.264,5.264,0,0,1,.95.247,11.78,11.78,0,0,1,3.488-1c.468-.083.954-.17,1.461-.283,11.8-2.7,19.988-2.048,25.049,1.983,6.1,4.865,6.1,13.476,6.1,19.763,0,9.053-1.526,14.8-4.811,18.081-.424.428-.852.95-1.331,1.534-3.165,3.868-8.458,10.34-27.061,10.34M104.762,33.863c-9.952,0-15.648,4.18-16.942,12.436-.638,4.046.812,20.459,3.984,25.045C94.937,75.876,101.477,81.9,122.03,81.9c17.312,0,21.913-5.62,24.955-9.343.544-.66,1.03-1.251,1.512-1.733,2.7-2.7,4.017-7.987,4.017-16.159,0-5.732,0-13.589-5.076-17.635-4.314-3.437-11.972-3.926-22.754-1.461-.334.076-.656.138-.972.2.272.065.558.134.856.2A1.361,1.361,0,0,1,125.59,37.6a1.344,1.344,0,0,1-1.632,1.019,35.742,35.742,0,0,1-5.344-1.6,1.4,1.4,0,0,1-.326-.2,1.463,1.463,0,0,0-.609-.181,5.6,5.6,0,0,1-1.632-.515A23.7,23.7,0,0,0,105.7,33.874q-.473-.011-.935-.011" transform="translate(223.06 81.766)" fill="#333"/>
                    <path id="Trazado_496" data-name="Trazado 496" d="M102.172,84.621c-21.829,0-28.983-6.693-32.463-11.729-3.633-5.253-5.152-22.442-4.438-27.014.892-5.67,4.826-15.122,20.633-14.723,5.185.131,8.788.323,11.544,1.762a15.33,15.33,0,0,1,1.969,1.218,12.21,12.21,0,0,1,3.346-.932c.468-.083.954-.17,1.461-.283,11.8-2.7,19.988-2.048,25.049,1.983,6.1,4.865,6.1,13.476,6.1,19.763,0,9.053-1.526,14.8-4.811,18.081-.424.424-.852.95-1.331,1.534-3.165,3.868-8.458,10.34-27.061,10.34M84.9,33.863c-9.952,0-15.648,4.18-16.942,12.436-.638,4.046.812,20.459,3.984,25.045C75.078,75.876,81.619,81.9,102.172,81.9c17.312,0,21.913-5.62,24.958-9.343.54-.66,1.026-1.251,1.508-1.733,2.7-2.7,4.017-7.987,4.017-16.159,0-5.732,0-13.589-5.076-17.635-4.314-3.437-11.972-3.926-22.754-1.461-.551.123-1.08.221-1.584.312a16.491,16.491,0,0,0-1.925.417,33.55,33.55,0,0,1,2.353,5.036,1.359,1.359,0,0,1-2.542.964,24.173,24.173,0,0,0-2.755-5.536,12.285,12.285,0,0,0-2.183-1.436c-2.23-1.167-5.7-1.338-10.351-1.454q-.473-.011-.935-.011" transform="translate(170.922 81.766)" fill="#333"/>
                    <path id="Trazado_497" data-name="Trazado 497" d="M116.93,45.68a1.4,1.4,0,0,1-.453-.076c-.069-.025-6.715-2.335-12.283-.337a1.36,1.36,0,0,1-.921-2.56c6.5-2.328,13.81.225,14.114.334a1.359,1.359,0,0,1-.457,2.639" transform="translate(268.788 109.566)" fill="#333"/>
                    <path id="Trazado_498" data-name="Trazado 498" d="M93.494,44.932h-.062l-9.122-.4a1.358,1.358,0,0,1-1.3-1.418,1.4,1.4,0,0,1,1.418-1.3l9.122.392a1.36,1.36,0,0,1-.058,2.719" transform="translate(217.95 109.802)" fill="#333"/>
                </g>
                </svg>
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
                                <FileUpload class="bg-primary-500 text-sm p-button-sm" mode="basic" name="" chooseLabel="Añadir documento" 
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
                :filePath="['http://127.0.0.1:8000/getfile/'+renderFile]"
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
                            {{ txtPosicio(slotProps.data.posicio) }}
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
                        <template #body="slotProps">
                            {{ txtMarca(slotProps.data.idMarca) }}
                        </template>
                    </Column>
                    <Column field="idConexio" style="min-width: 6rem">
                        <template #header>
                            <div>
                                {{ $t('Conexión') }}
                                <br/>
                                <Dropdown 
                                    :options="filteredData.tipusImplants" 
                                    optionLabel="tipusImplants" 
                                    optionValue="idTipusImplant"
                                    class="w-full mt-1 rounded-none"
                                    v-model="implantDetail.idConexio" 
                                    :placeholder="$t('Selecc. marca')"   
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
                            {{ txtConexio(slotProps.data.idConexio) }}
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
                        <template #body="slotProps">
                            {{ txtAngulacio(slotProps.data.idAngulacions) }}
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

