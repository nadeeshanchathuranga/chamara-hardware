<style  >


/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}



/* Style the filter container */
#CategoryTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#CategoryTable_filter label {
  font-size: 17px;
  color: #000000; /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#CategoryTable_filter input[type="search"] {
font-weight: 400;
    padding: 9px 15px;
    font-size: 14px;
    color: #000000cc;
    border: 1px solid rgb(209 213 219);
    border-radius: 5px;
    background:#fff;
    outline: none;
  transition: all 0.5s ease;
}
#CategoryTable_filter input[type="search"]:focus {
    outline: none; /* Removes the default outline */
     border: 1px solid #4b5563;
    box-shadow: none; /* Removes any focus box-shadow */
}

#CategoryTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>

<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-5/6 py-12 space-y-24">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4"></div>
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
            totalCategories
          }}</span>
          <span class="text-xl">/ Total Categories</span>
        </p>
      </div>
      <div class="flex w-full">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <a href="/dashboard">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </a>

          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Categories
          </p>
        </div>
        <div
          class="flex items-center justify-center w-1/6 h-16 space-x-4 rounded-xl"
        ></div>
        <div class="flex justify-end w-full">
          <p
            @click="isCreateModalOpen = true"
            class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded rounded-xl"
          >
            <i class="pr-4 ri-add-circle-fill"></i> Add More Categories
          </p>
        </div>
      </div>
      <template v-if="allcategories && allcategories.length > 0">
        <div class="overflow-x-auto">
  <table
  id="CategoryTable"
  class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
>
  <thead>
    <tr
      class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[16px] text-white border-b border-blue-700"
    >
      <th class="p-4 font-semibold tracking-wide text-left uppercase">Name</th>
      <th class="p-4 font-semibold tracking-wide text-left uppercase">
        Parent Hierarchy
      </th>
      <th class="p-4 font-semibold tracking-wide text-center uppercase">
    Actions
</th>
    </tr>
  </thead>
  <tbody class="text-[13px] font-normal">
    <!-- If categories exist -->
    <tr
      v-if="allcategories && allcategories.length > 0"
      v-for="category in allcategories"
      :key="category.id"
      class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
    >
     <td class="p-4 font-bold border-t border-gray-200">
        {{ category.name || "N/A" }}
      </td>
      <td class="p-4 italic border-t border-gray-200">
        {{ category.hierarchy_string || "N/A" }}
      </td>


<td class="p-4 text-center border-t border-gray-200">
  <div class="inline-flex items-center w-full space-x-3">
    <button
      @click="openEditModal(category)"
      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-green-500 to-green-400 transition duration-150 ease-in-out rounded-md hover:from-green-600 hover:to-green-500"
    >
      Edit
    </button>
    <button
      @click="openDeleteModal(category)"
      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-red-500 to-red-400 transition duration-150 ease-in-out rounded-md hover:from-red-600 hover:to-red-500"
    >
      Delete
    </button>
  </div>
</td>






    </tr>

    <!-- Fallback for no categories -->
    <tr
      v-else
      class="font-medium text-center text-white text-red-500 bg-gradient-to-r from-gray-800 to-gray-900"
    >
      <td colspan="3" class="p-4 border-t border-gray-700">
        No categories available.
      </td>
    </tr>
  </tbody>
</table>

        </div>
      </template>
      <template v-else>
        <div class="col-span-4 text-center text-blue-500">
          <p class="text-center text-red-500 text-[17px]">
            No categories available
          </p>
        </div>
      </template>
    </div>
  </div>
  <!-- Modal -->
  <!-- <CategoryCreateModel :categories="allcategories" v-model:open="isModalOpen" /> -->
  <CategoryCreateModel
    :categories="allcategories"
    v-model:open="isCreateModalOpen"
  />
  <CategoryEditModel
    :categories="allcategories"
    :selected-category="selectedCategory"
    v-model:open="isEditModalOpen"
  />

  <CategoryDeleteModel
    :categories="allcategories"
    :selected-category="selectedCategory"
    v-model:open="isDeleteModalOpen"
  />

  <!-- Include the Footer -->
  <Footer />
</template>
<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import CategoryCreateModel from "@/Components/custom/CategoryCreateModel.vue";
import CategoryEditModel from "@/Components/custom/CategoryEditModel.vue";
import CategoryDeleteModel from "@/Components/custom/CategoryDeleteModel.vue";
import Banner from "@/Components/Banner.vue";

defineProps({
  // paginatedcategories: Object, // This comes from Inertia
  allcategories: Array,
  totalCategories: Number,
});

const openEditModal = (category) => {
  selectedCategory.value = category; // Set the selected category
  isEditModalOpen.value = true; // Open the edit modal
};

const openDeleteModal = (category) => {
  selectedCategory.value = category; // Set the selected category
  isDeleteModalOpen.value = true; // Open the edit modal
};

const form = useForm({});

// Manage modal state
// const isModalOpen = ref(false);
const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedCategory = ref(null);

$(document).ready(function () {
  let table = $("#CategoryTable").DataTable({
    dom: "Bfrtip",
    pageLength: 10,
    buttons: [],

    columnDefs: [
      {
        targets: 2, // Index of the "Actions" column
        searchable: false, // Disable filtering for this column
        orderable: false, // Optional: Disable sorting for this column
      },
    ],
    initComplete: function () {
      // Customize the search input
      let searchInput = $('div.dataTables_filter input');
      searchInput.attr("placeholder", "Search ...");
      searchInput.off('keyup'); // Remove the default keyup event listener

      // Add custom search on "Enter"
      searchInput.on('keypress', function (e) {
        if (e.which == 13) { // Check if the Enter key is pressed
          table.search(this.value).draw();
        }
      });
    },
    language: {
      search: "", // Remove the default "Search:" label
    },
  });
});

</script>
