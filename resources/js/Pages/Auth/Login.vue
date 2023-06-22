<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import Button from "primevue/button";
import Checkbox from "@/Components/Checkbox.vue";
import Dialog from "primevue/dialog";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

defineProps({
  canResetPassword: Boolean,
  status: String
});

const form = useForm({
  email: "",
  password: "",
  remember: false
});

const submit = () => {
  form
    .transform(data => ({
      ...data,
      remember: form.remember ? "on" : ""
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password")
    });
};

const displayModal = ref(false);
</script>

<template>
<AuthLayout> 
  <Head title="Login" />
  <main>
     <div class="mt-8">
      <div>
         <div class="relative flex text-sm">
            <span class="text-gray-500" v-html='$t("laravel.Login copy")'></span>
          </div>
      </div>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">{{ status }}</div>

      <div class="mt-6">
        <form class="space-y-6" @submit.prevent="submit">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700"> {{ $t("laravel.E-Mail") }}</label>
            <div class="mt-1">
              <textInput
                id="email"
                name="email"
                type="email"
                v-model="form.email"
                autocomplete="email"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-copate-500 focus:outline-none focus:ring-copate-500 sm:text-sm"
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>
          </div>

          <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ $t("laravel.Password") }}</label>
            <div class="mt-1">
              <textInput
                id="password"
                name="password"
                type="password"
                v-model="form.password"
                autocomplete="current-password"
                required
                class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-copate-500 focus:outline-none focus:ring-copate-500 sm:text-sm"
              />
              <InputError class="mt-2" :message="form.errors.password" />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <Checkbox v-model:checked="form.remember" name="remember" />
              <label
                for="remember-me"
                class="ml-2 block text-sm text-gray-900"
              >{{ $t("laravel.Remember Me") }}</label>
            </div>
            <div>
                <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="ml-2 block text-sm text-gray-900 underline"
              >{{ $t("laravel.Forgot Your Password?") }}</Link>
            </div>
          </div>

          <div class="block lg:flex pt-3 lg:gap-6">
            <PrimaryButton
              class="flex w-full justify-center rounded-md border border-transparent bg-primary-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-copate-700 focus:outline-none focus:ring-2 focus:ring-copate-500 focus:ring-offset-2"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >{{ $t("laravel.Login") }}</PrimaryButton>
            
             <PrimaryButton
              class="flex w-full justify-center rounded-md border border-transparent bg-neutral-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-copate-700 focus:outline-none focus:ring-2 focus:ring-copate-500 focus:ring-offset-2"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >{{ $t("laravel.Register") }}</PrimaryButton>
          </div>

        </form>
      </div>
    </div>
  </main>

</AuthLayout>


</template>

