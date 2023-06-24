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
 
    <div class="flex min-h-full dark:bg-slate-800">

        <Head :title="title" />

        <Banner />

        <div class="absolute right-16 top-8">
            <languageSelector/>
        </div>

        <div class="relative hidden w-0 flex-1 lg:flex auth-side-bg">

        </div>

        <div class="flex flex-1 flex-col justify-around px-4 sm:px-6 lg:flex-none lg:px-10 xl:px-60">


            <div class="mx-auto w-full max-w-sm lg:w-96 pt-12 pb-8">
                <div class="pb-8">
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

.auth-side-bg {
    background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.25)), url(https://cadcam.avinent.com/wp-content/uploads/sites/5/2021/02/Banner-ACC.jpg);
}
</style>

