<template>

  <div class="items-center justify-end w-full py-6 tracking-wider bg-black roboto-regular">
    <p class="text-2xl text-center text-white">
      Powered by <span class="font-bold text-red-400">JAAN Network (Pvt) Ltd</span> @{{ currentYear }}
    </p>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Get the current year
const currentYear = ref(new Date().getFullYear());
</script>
