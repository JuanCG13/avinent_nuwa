<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
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


</script>

<template>
<AuthLayout> 
  <Head :title="$t('msg.login')" />
  <main>
     <div class="mt-8">
      <div>
         <div class="relative flex text-sm">
            <span class="text-gray-500 dark:text-white" v-html='$t("msg.auth-intro")'></span>
          </div>
      </div>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">{{ status }}</div>

      <div class="mt-6">
        <form class="space-y-6" @submit.prevent="submit">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300"> {{ $t("msg.email") }}</label>
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
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ $t("msg.password") }}</label>
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
                class="ml-2 block text-sm text-gray-900 dark:text-slate-300"
              >{{ $t("msg.remember") }}</label>
            </div>
            <div>
                <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="ml-2 block text-sm text-gray-900 underline dark:text-slate-300"
              >{{ $t("msg.forgot") }}</Link>
            </div>
          </div>

          <div class="block lg:flex pt-3 lg:gap-6">
            <Button
              type="submit"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >{{ $t("msg.login") }}</Button>
            
            <Link :href="route('register')">
             <Button class="w-full mt-4 lg:mt-0 !bg-neutral-500 hover:!bg-primary-500">{{ $t("msg.register") }} </Button>
            </Link>
       
          </div>

        </form>
      </div>
    </div>
  </main>

</AuthLayout>


</template>

