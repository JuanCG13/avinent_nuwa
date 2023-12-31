<script setup>
import { ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import TeamManagement from '@/Components/TeamManagement.vue';
import languageSelector from '@/Components/languageSelector.vue';


defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const page = usePage();

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-white dark:bg-slate-900 flex flex-col h-full justify-between">
            <nav class="bg-primary-500 border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">

                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="ml-16 sm:flex" v-if="page.props.auth.user.isAdmin">
                                <NavLink class="text-white hover:text-white text-sm" :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                    <i class="pi pi-inbox mr-2 text-xl"></i>{{ $t('Gestión') }}  
                                </NavLink>
                            </div>

                            <div class="ml-16 sm:flex">
                                <NavLink class="text-white hover:text-white text-sm" :href="route('dashboard')" :active="route().current('dashboard')">
                                    <i class="pi pi-file mr-2 text-xl"></i>{{ $t('Mis casos') }}   
                                </NavLink>
                            </div>

                            <div class="ml-16 sm:flex">
                                <NavLink class="text-white hover:text-white text-sm" :href="route('support')" :active="route().current('support')">
                                    <i class="pi pi-book mr-2 text-xl"></i>{{ $t('Soporte') }}   
                                </NavLink>
                            </div>

                        </div>

                        <div class="sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">

                            <!-- Teams Dropdown -->
                            <TeamManagement/>

                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>

                            <div class="flex ml-8">
                                <languageSelector class="bg-primary-500 dark:bg-primary-500 text-white"/>
                            </div>

                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

             
            </nav>

            
            <!-- Page Content -->
            <div class="container mx-auto mb-auto h-full relative">
                <slot name="fullcontent">
                    
                    <div class="pt-12 px-6 mx-auto lg:px-0">
                        <slot name="header" />
                    </div>
                    <div class="px-6 mx-auto lg:px-0">
                        <slot name="content"/>
                   </div>

                </slot>

            </div>

            <!-- Footer -->
            <div class="bg-neutral-500 h-28">

            </div>

        </div>
  

    </div>
</template>
