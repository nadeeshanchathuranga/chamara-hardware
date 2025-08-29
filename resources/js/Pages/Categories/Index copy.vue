<style  >
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Individual Pagination Buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  display: inline-block;
  padding: 8px 12px;
  margin: 0 4px;
  font-size: 14px;
  font-weight: bold;
  color: #fff !important; /* Matches table text color */
  background-color: #1e293b; /* Matches bg-gray-800 */
  border: 1px solid #4b5563; /* Matches border-gray-700 */
  border-radius: 5px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

/* Hover Effect for Buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #2563eb; /* Matches bg-blue-600 */
  border-color: #2563eb;
}

/* Active Page Button */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #2563eb; /* Matches active state bg-blue-600 */
  color: #fff !important;
  border-color: #2563eb;
}

/* Disabled Buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
  color: #9ca3af !important; /* Matches text-gray-400 */
  background-color: #1e293b; /* Matches bg-gray-800 */
  border-color: #4b5563; /* Matches border-gray-700 */
  cursor: not-allowed;
  opacity: 0.5;
}

/* Previous and Next Buttons */
.dataTables_wrapper .dataTables_paginate .paginate_button.previous,
.dataTables_wrapper .dataTables_paginate .paginate_button.next {
  font-size: 14px;
  font-weight: bold;
  text-transform: uppercase;
  color: #ffffff;
  background-color: #1e293b;
  border: 1px solid #4b5563;
  border-radius: 5px;
  padding: 8px 12px;
  transition: all 0.3s ease;
}

/* Previous/Next Hover */
.dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
  background-color: #1e293b;
  border-color: #1e293b;
  color: #ffffff !important;
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
  margin-left: 8px; /* Space between label and input */
  padding: 7px 15px;
  font-size: 15px;
  color: #000000; /* Input text color */

  border: 1px solid #4b5563; /* Matches table border */
  border-radius: 0px;
  outline: none;
  transition: all 0.3s ease;
}

#CategoryTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px; /* Additional spacing for the entire table wrapper */
}
</style>

<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 px-36"
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

      <div class="overflow-x-auto">
        <table
          id="CategoryTable"
          class="w-full text-left text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg table-auto"
        >
          <thead>
            <tr
              class="bg-gray-900 border-b border-gray-700 text-[16px] text-white"
            >
              <th class="p-4 font-semibold tracking-wide uppercase">Name</th>
              <th class="p-4 font-semibold tracking-wide uppercase">
                Parent Category
              </th>
              <th class="p-4 font-semibold tracking-wide uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="text-[13px] font-normal">
            <!-- If categories exist -->
            <tr
              v-if="
                paginatedcategories.data && paginatedcategories.data.length > 0
              "
              v-for="category in paginatedcategories.data"
              :key="category.id"
              class="transition duration-200 ease-in-out hover:bg-gray-700"
            >
              <td class="p-4 border-t border-gray-700">
                {{ category.name || "N/A" }}
              </td>

              <td class="p-4 border-t border-gray-700">
                {{ category.parent?.name || "N/A" }}
              </td>
              <td class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                  <button
                    @click="openEditModal(category)"
                    class="px-4 py-2 font-medium text-[12px] text-white transition duration-150 ease-in-out bg-blue-600 rounded-md hover:bg-blue-500"
                  >
                    Edit
                  </button>
                  <button
                    @click="openDeleteModal(category)"
                    class="px-4 py-2 font-medium text-[12px] text-white transition duration-150 ease-in-out bg-red-600 rounded-md hover:bg-red-500"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>

            <!-- Fallback for no categories -->
            <tr v-else class="font-medium text-center text-red-500 bg-gray-900">
              <td colspan="3" class="p-4 border-t border-gray-700">
                No categories available.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
  paginatedcategories: Object, // This comes from Inertia
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
  $("#CategoryTable").DataTable({
    dom: "Bfrtip",
    buttons: [],
    columnDefs: [
      {
        targets: 2, // Index of the "Actions" column
        searchable: false, // Disable filtering for this column
        orderable: false, // Optional: Disable sorting for this column
      },
    ],
  });
});
</script>
