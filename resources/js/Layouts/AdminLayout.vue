<template>
  <div class="min-h-screen bg-gray-100" :class="{ 'overflow-hidden': openMobileMenu }">
    <!-- Mobile Menu Button (Only visible on small screens) -->
    <div class="lg:hidden p-4">
      <button @click="openMobileMenu = true" class="text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Mobile Full-Screen Menu -->
    <div v-if="openMobileMenu" class="fixed inset-0 bg-gray-800 text-white flex flex-col z-50 lg:hidden">
      <div class="p-4 flex justify-between items-center">
        <span class="text-lg font-bold">TailAdmin</span>
        <button @click="openMobileMenu = false" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <nav class="mt-4">
        <MenuItem text="Dashboard" />
        <MenuItem text="Calendar" />
        <MenuItem text="Profile" />
        <DropdownMenu text="Task">
          <MenuItem text="Subtask 1" />
          <MenuItem text="Subtask 2" />
        </DropdownMenu>
        <DropdownMenu text="Forms">
          <MenuItem text="Form 1" />
          <MenuItem text="Form 2" />
        </DropdownMenu>
        <MenuItem text="Tables" />
        <DropdownMenu text="Pages">
          <MenuItem text="Page 1" />
          <MenuItem text="Page 2" />
        </DropdownMenu>
      </nav>
    </div>

    <div class="flex">
      <!-- Sidebar for large screens -->
      <div class="hidden lg:block w-64 bg-gray-800 text-white h-screen">
        <div class="p-4 text-center font-bold text-lg">TailAdmin</div>
        <nav class="mt-4">
          <MenuItem text="Dashboard" />
          <MenuItem text="Calendar" />
          <MenuItem text="Profile" />
          <DropdownMenu text="Task">
            <MenuItem text="Subtask 1" />
            <MenuItem text="Subtask 2" />
          </DropdownMenu>
          <DropdownMenu text="Forms">
            <MenuItem text="Form 1" />
            <MenuItem text="Form 2" />
          </DropdownMenu>
          <MenuItem text="Tables" />
          <DropdownMenu text="Pages">
            <MenuItem text="Page 1" />
            <MenuItem text="Page 2" />
          </DropdownMenu>
        </nav>
      </div>

      <!-- Main Content -->
      <div class="flex-1 p-6 h-screen overflow-y-auto">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

// State for controlling mobile menu
const openMobileMenu = ref(false);

// Reusable MenuItem component
const MenuItem = {
  props: {
    text: String,
  },
  template: `
    <a href="#" class="block py-2 px-4 text-gray-200 hover:bg-gray-700">{{ text }}</a>
  `,
};

// Dropdown Menu Component
const DropdownMenu = {
  props: {
    text: String,
  },
  data() {
    return {
      open: false,
    };
  },
  template: `
    <div>
      <button @click="open = !open" class="flex items-center justify-between w-full py-2 px-4 text-gray-200 hover:bg-gray-700">
        <span>{{ text }}</span>
        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <div v-show="open" class="ml-4">
        <slot />
      </div>
    </div>
  `,
};
</script>

<style>
/* Hide elements during transitions */
[hidden] {
  display: none;
}
</style>
