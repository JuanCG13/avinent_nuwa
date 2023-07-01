<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import languageSelector from '@/Components/languageSelector.vue';
import Banner from '@/Components/Banner.vue';
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";


defineProps({
    title: String,
});


</script>

<template>
 
    <div class="flex min-h-full bg-white dark:bg-slate-800">

        <Head :title="title" />

        <Banner />

        <div class="absolute right-8 top-8">
            <languageSelector/>
        </div>

        <div class="container mx-auto flex items-center">

            <div class="mx-auto w-full max-w-3xl pt-12 pb-8 px-6">
                
                <div class="pb-12 lg:pb-24 flex justify-center">
                    <AuthenticationCardLogo />
                </div>
                  
                
                 <!-- Page Content -->
                <main>
                    <slot />
                </main>


            </div>

             
         </div>
    </div>
    
</template>

<style>
html,
body,
#app {
  height: 100%;
}

</style>


