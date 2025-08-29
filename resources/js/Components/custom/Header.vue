<template>
  <div class="flex md:flex-row flex-col items-center justify-between w-full space-x-4 px-4 py-2">
    <!-- Logo -->
    <Link
      href="/"
      :title="
        companyInfo && companyInfo.name
          ? companyInfo.name
          : 'Default Company Name'
      "
      class="flex-shrink-0"
    >
      <img
        :src="
          companyInfo && companyInfo.logo
            ? companyInfo.logo
            : '/images/jaan_logo.jpg'
        "
        class="w-60 h-auto"
        alt="Logo"
      />
    </Link>
    <!-- User Account Information -->
    <div class="w-full flex md:justify-end justify-between space-x-8">
      <div class="flex items-end space-x-4 text-right space-y-2">
        <div class="flex flex-col">
          <p class="text-lg">
            <span class="font-bold">Account Type : </span>
            <b>{{ $page.props.auth.user.role_type }}</b>
          </p>
          <p class="text-lg">
            <span class="font-bold">Logged As : </span>
            <b>{{ $page.props.auth.user.name }}</b>
          </p>
        </div>

        <img
          src="/images/dashboard/cashier.png"
          class="p-1 border border-black rounded-full"
          style="width: 55px; height: 55px"
          alt="Profile"
        />
      </div>
      <div class="flex">
        <!-- Logout Button -->
        <form @submit.prevent="logout" class="flex items-center">
          <button
            type="submit"
            class="flex items-center font-bold text-red-500 hover:underline"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              class="w-8 h-8"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-6a2.25 2.25 0 00-2.25 2.25v13.5a2.25 2.25 0 002.25 2.25h6a2.25 2.25 0 002.25-2.25V15M19.5 12l-3-3m3 3l-3 3m3-3H9"
              />
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>


  <script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3"; // Importing usePage
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

// Get the page properties using usePage()
const page = usePage();

// Access the companyInfo from the page props
const companyInfo = computed(() => page.props.companyInfo);

const logout = () => {
  router.post(route("logout"));
};
</script>
