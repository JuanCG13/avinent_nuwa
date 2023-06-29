<script setup>
import { ref } from "vue";
import { Head, Link} from "@inertiajs/vue3";
import Button from "@/Components/PrimaryButton.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";

const dashboard = () => {

   $route('dashboard');
}
</script>

<template>
<AuthLayout> 
  <Head :title="$t('msg.welcome')" />
  <main>
     <div class="mt-8">
      <div>
         <div class="relative flex text-sm">
            <div class="text-gray-500 dark:text-white">
            <p class="font-bold mb-4">{{$t("msg.hello")}} {{ $page.props.auth.user.name }}, {{$t("msg.welcome-title")}}</p>
            <p>{{$t("msg.welcome-copy")}}</p>

            <p class="mt-10">{{$t("msg.welcome-footer")}}</p>
            <p class="mt-10">
              <Link :href="route('dashboard')">
                <Button>{{ $t('msg.cta-portal') }}</Button>
              </Link>
            </p>
           </div>
        </div>
      </div>


      <div class="mt-6">
       
      </div>
    </div>
  </main>

</AuthLayout>


</template>

