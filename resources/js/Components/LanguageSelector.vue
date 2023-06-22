<script setup>
import Dropdown from 'primevue/dropdown';
</script>

<template>
  <!-- <Dropdown 
    v-model="$i18n.locale" 
    :options="$i18n.availableLocales" 
    placeholder="Select a City" 
    class="border-0 focus:border-0"
    > 

</Dropdown> -->
    <select class="border-0 focus:border-0 focus:shadow-none" v-model="$i18n.locale">
      <option v-for="locale in $i18n.availableLocales" :key="`locale-${locale}`" :value="locale">{{ locale }}</option>
    </select>
</template>

    