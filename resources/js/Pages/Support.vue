<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import { ref } from 'vue';


const _data = defineProps({

    faqs: Object

});

const faqs = ref([
    { title: 'Title 1', content: 'Content 1' },
    { title: 'Title 2', content: 'Content 2' },
    { title: 'Title 3', content: 'Content 3' }
]);


</script>

<template>
    <AppLayout :title="$t('Soporte')">
        <template #header>
            <h2 class="font-bold text-2xl text-primary-500 dark:text-slate-300 leading-tight">
               {{ $t('Soporte') }} 
            </h2>
        </template>

        <template #content>
            <div class="py-12">
                <Accordion class="accordion-custom" :activeIndex="0">
                    <AccordionTab v-for="tab in faqs" :key="tab.title" >
                        <template #header>
                            <span>{{tab.title}}</span>
                        </template>
                        <p>{{ tab.content }}</p>
                    </AccordionTab>
                </Accordion>
            </div>
        </template>
    </AppLayout>
</template>

