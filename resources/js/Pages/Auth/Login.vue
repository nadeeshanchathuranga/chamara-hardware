<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import logo from "@/assets/logo.png";
import { computed } from "vue";

// Get the page properties using usePage()
const page = usePage();

// Access the companyInfo from the page props
const companyInfo = computed(() => page.props.companyInfo);

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  identity: "",
  password: "",
  remember: false,
});

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? "on" : "",
    }))
    .post(route("login"), {
      onFinish: () => form.reset("password"),
    });
};
</script>

<template>
  <Head title="Log in" />
  <section
    class="flex flex-col items-center justify-start w-full min-h-screen pt-16 space-y-12"
  >
    <div
      class="flex flex-col items-center justify-center w-full pt-16 space-y-12"
    >
      <div class="flex items-center justify-center w-full">
        <!-- <img src="./assetes/images/logo.png" class="w-[180px] h-[100px]" /> -->
        <!-- <img :src="logo" alt="Logo" class="w-[180px] h-[100px]" /> -->

        <img :src="companyInfo && companyInfo.logo ? companyInfo.logo : '/images/jaan_logo.jpg'" class="w-[180px] h-[100px]" alt="Logo" />
      </div>
      <div class="w-full max-w-md p-8 space-y-8 tracking-wider bg-black">
        <h2 class="text-3xl font-bold text-center text-white roboto-regular">
          TERMINAL LOGIN
        </h2>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <TextInput
              id="identity"
              v-model="form.identity"
              type="text"
              class="w-full px-3 py-2 mt-1 text-2xl border rounded-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
              autofocus
              placeholder="Enter Name"
              autocomplete="username"
            />
          </div>

          <div>
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="w-full px-3 py-2 mt-1 text-2xl border rounded-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
              placeholder="Enter password"

              autocomplete="current-password"
            />
            <!-- <InputError class="mt-2 font-bold text-center" :message="form.errors.email" /> -->
            <InputError class="mt-2 font-bold text-center" :message="form.errors.identity" />
          </div>

          <div class="w-full py-4">
            <button
              type="submit"
              class="w-full py-4 text-2xl font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 roboto-regular"
            >
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
    <div
      class="flex items-center justify-center w-full space-x-4 tracking-wider roboto-regular"
    >
      <p class="text-2xl font-bold">
        <i class="ri-global-line"></i>

        {{ companyInfo?.website || 'JAAN Network (Pvt) Ltd' }}
      </p>
      <p class="text-2xl">|</p>
      <p class="text-2xl font-bold">
        JAAN PoS <span class="font-normal">(Textile) Version 1.1</span>
      </p>
    </div>
    <div
      class="fixed bottom-0 items-center justify-end w-full py-6 tracking-wider bg-black roboto-regular"
    >
      <p class="text-2xl text-center text-white">
        Powered by
        <span class="font-bold text-red-500">JAAN Network (Pvt) Ltd</span> @2024
      </p>
    </div>
  </section>


</template>
<script setup>


</script>
