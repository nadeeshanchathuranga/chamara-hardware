<template>
  <div class="max-w-xs relative space-y-3">
    <label
      for="search"
      class="text-gray-900"
    >
      {{ label }}
    </label>

    <input
      type="text"
      id="search"
      v-model="searchTerm"
      :placeholder="placeholder"
      class="p-3 mb-0.5 w-full border border-gray-300 rounded"
    >

    <ul
      v-if="searchCountries.length"
      class="w-full rounded bg-white border border-gray-300 px-4 py-2 space-y-1 absolute z-10"
    >
      <li class="px-1 pt-1 pb-2 font-bold border-b border-gray-200">
        Showing {{ searchCountries.length }} of {{ countries.length }} results
      </li>
      <li
        v-for="country in searchCountries"
        :key="country.name"
        @click="selectCountry(country.name)"
        class="cursor-pointer hover:bg-gray-100 p-1"
      >
        {{ country.name }}
      </li>
    </ul>

    <p
      v-if="selectedCountry"
      class="text-lg pt-2 absolute"
    >
      You have selected: <span class="font-semibold">{{ selectedCountry }}</span>
    </p>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Props definition using defineProps
const props = defineProps({
  label: {
    type: String,
    default: 'Type the name of a country to search',
  },
  placeholder: {
    type: String,
    default: 'Type here...',
  }
});

// Countries list as a constant
const countries = [
  { name: "Afghanistan" },
  { name: "Albania" },
  { name: "Algeria" },
  { name: "Andorra" },
  { name: "Angola" },
  { name: "Antigua and Barbuda" },
  { name: "Argentina" },
  { name: "Armenia" },
  { name: "Australia" },
  { name: "Austria" },
  { name: "Azerbaijan" },
  { name: "Bahamas" },
  { name: "Bahrain" },
  { name: "Bangladesh" },
  { name: "Barbados" },
  { name: "Belarus" },
  { name: "Belgium" },
  { name: "Belize" },
  { name: "Benin" },
  { name: "Bhutan" },
  // Add more countries as needed
];

// Reactive state variables
const searchTerm = ref('');
const selectedCountry = ref('');

// Computed property for filtered countries
const searchCountries = computed(() => {
  if (searchTerm.value === '') {
    return [];
  }

  let matches = 0;
  return countries.filter((country) => {
    if (country.name.toLowerCase().includes(searchTerm.value.toLowerCase()) && matches < 10) {
      matches++;
      return country;
    }
  });
});

// Method to select a country
const selectCountry = (country) => {
  selectedCountry.value = country;
  searchTerm.value = '';
};
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
