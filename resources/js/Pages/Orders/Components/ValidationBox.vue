<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useI18n } from "vue-i18n";
import _ from 'lodash';

import MessageBox from "@/Components/MessageBox.vue";


const { t } = useI18n();
const page = usePage();

const props = defineProps({
    orderData: Object,
});

const emit = defineEmits(['orderValidated'])

//check all order works for validation
const validation_msg = computed(() => {

    var msg_errors = [];
    var msg_validation = '';

    if (props.orderData.orderWorks.length == 0) return t('El pedido debe contener un trabajo como mínimo.');
 
    props.orderData.orderWorks.forEach((work, index) => {
        msg_errors.push({[index]:{
            idTipusArticle: work.idTipusArticle?'':t('Falta definir el tipo de producto'),
            idMaterial: work.idMaterial?'':t('Falta definir el material'),
            idTipusArticle2: '',    
            quantitat:  work.quantitat?'':t('Falta definir las unidades'),
            idColor:  work.idMaterial?'':t('Falta definir el color'),
            idIncisal: ''}
        });
    
    });

    _.forEach(msg_errors, function(workError, key) {

        msg_validation+='<br><b>' + t('Del trabajo ') + eval(key+1) + '</b><br/>'
        _.each(workError[key], function(value) {
            value? msg_validation+=value + '<br/>' :'';
            });
        }); 

    return msg_validation;

})


</script>

<template>
    <div class="mt-6">
        <MessageBox v-if="validation_msg" class="border-red-800 bg-red-100 text-red-900"
            :title="$t('Validación del pedido')" 
            :text="validation_msg"
        />

        <MessageBox v-if="!validation_msg" class="border-green-800 bg-green-100 text-green-700"
            :title="$t('Validación del pedido')" 
            :text="$t('Los datos de los trabajos son correctos, puedes proceder al envío del pedido.')"
        />
    </div>
</template>
