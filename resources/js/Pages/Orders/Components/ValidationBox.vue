<script setup>
import { ref, computed, reactive, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useI18n } from "vue-i18n";
import _ from 'lodash';

import MessageBox from "@/Components/MessageBox.vue";


const {t, locale} = useI18n();
const page = usePage();

const props = defineProps({
    orderData: Object,
});

const _data = reactive({ 
    tipusArticle:null,
});

const emit = defineEmits(['orderValidated'])

onMounted(async () => {

    const response1 = await fetch("/tipusarticle/"+locale.value);
    _data.tipusArticle = await response1.json();


});

const txtArticle = (id) => {
    var txt = _.filter(_data.tipusArticle, { 'idTipusArticle' : id });  
    return txt[0]?.tipusArticle;
};


//check all order works for validation
const validation_msg = computed(() => {

    var msg_errors = [];
    var msg_validation = '';

    if (props.orderData.orderWorks.length == 0) return t('El pedido debe contener un trabajo como mínimo.');
 
    props.orderData.orderWorks.forEach((work, index) => {
        msg_errors.push({[index]:{
            article: txtArticle(work.idTipusArticle)? txtArticle(work.idTipusArticle) : t('Trabajo'),
            idTipusArticle: work.idTipusArticle?'':t('Falta definir el tipo de producto'),
            idMaterial: work.idMaterial?'':t('Falta definir el material'),
            idTipusArticle2: '',    
            quantitat:  work.quantitat?'':t('Falta definir las unidades'),
            idColor:  work.idMaterial?'':t('Falta definir el color'),
            idIncisal: ''}
        });
    
    });

    _.forEach(msg_errors, function(workError, key) {
        msg_validation+='<ul>'

        _.each(workError[key], function(value, key1) {
           
            if (key1=='article') {
                msg_validation+='<br><b>' + value + ' ' + eval(key+1) + '</b><br/>'

                } else {
                value? msg_validation+= '<li>' + value + '</li>' :'';
                }
            });
            msg_validation+='</ul>'
         }); 

     return msg_validation;

})


</script>

<template>
    <div class="mt-6">
        {{ msg_errors }}
        <MessageBox v-if="validation_msg" class="border-red-800 bg-red-100 text-red-900"
            :title="$t('Validación del pedido: ')" 
            :text="validation_msg"
        />

        <MessageBox v-if="!validation_msg" class="border-green-800 bg-green-100 text-green-700"
            :title="$t('Validación del pedido: ')" 
            :text="$t('Los datos de los trabajos son correctos, puedes proceder al envío del pedido.')"
        />
    </div>
</template>
