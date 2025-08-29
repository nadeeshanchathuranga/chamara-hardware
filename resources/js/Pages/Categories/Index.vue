<style>
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
  background: #fff;
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
  <Head title="Categories" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16"
  >
    <Header />
    <div class="w-full md:w-5/6 py-12 space-y-24">
      <div class="flex items-center justify-between float-end">
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
            totalCategories
          }}</span>
          <span class="text-xl">/ Total Categories</span>
        </p>
      </div>

      <div class="flex md:flex-row flex-col w-full">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Categories
          </p>
        </div>
        <div class="flex justify-end w-full">
          <!-- <p
            :disabled="!HasRole(['Admin'])"
            @click="
              () => {
                if (HasRole(['Admin'])) {
                  isCreateModalOpen = true;
                }
              }
            "
            :class="{
              'cursor-not-allowed opacity-50': !HasRole(['Admin']),
              '': true,
            }"
            class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded rounded-xl"
          >
            <i class="pr-4 ri-add-circle-fill"></i> Add More Categories
          </p>
 -->



          <p
  @click="() => { if (HasRole(['Admin'])) { isCreateModalOpen = true; } }"
  :class="HasRole(['Admin'])
            ? 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl'
            : 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'"
  :title="HasRole(['Admin'])
            ? ''
            : 'You do not have permission to add more Categories'"
>
  <i class="md:pr-4 ri-add-circle-fill"></i> Add More Categories
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
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Name
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Parent Hierarchy
                </th>
                <th
                  class="p-4 font-semibold tracking-wide text-center uppercase"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="text-[13px] font-normal">
              <tr
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

<!-- Edit Button -->
<button
  :class="HasRole(['Admin'])
            ? 'px-4 py-2 bg-green-500 text-white rounded-lg'
            : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'"
  :title="HasRole(['Admin'])
            ? ''
            : 'You do not have permission to edit'"
  :disabled="!HasRole(['Admin'])"
  @click="() => { if (HasRole(['Admin'])) openEditModal(category); }"
>
  Edit
</button>

<!-- Delete Button -->
<button
  :class="HasRole(['Admin'])
            ? 'px-4 py-2 bg-red-500 text-white rounded-lg ml-2'
            : 'px-4 py-2 bg-red-400 text-white rounded-lg cursor-not-allowed ml-2'"
  :title="HasRole(['Admin'])
            ? ''
            : 'You do not have permission to delete'"
  :disabled="!HasRole(['Admin'])"
  @click="() => { if (HasRole(['Admin'])) openDeleteModal(category); }"
>
  Delete
</button>













                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>

      <template v-else>
        <div class="col-span-4 text-center text-blue-500">
          <p class="text-center text-red-500 text-[17px]">
            No Categories Available
          </p>
        </div>
      </template>



    </div>
  </div>
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
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import CategoryCreateModel from "@/Components/custom/CategoryCreateModel.vue";
import CategoryEditModel from "@/Components/custom/CategoryEditModel.vue";
import CategoryDeleteModel from "@/Components/custom/CategoryDeleteModel.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

defineProps({
  allcategories: Array,
  totalCategories: Number,
});

const openEditModal = (category) => {
  selectedCategory.value = category;
  isEditModalOpen.value = true;
};

const openDeleteModal = (category) => {
  selectedCategory.value = category;
  isDeleteModalOpen.value = true;
};

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
        targets: 2,
        searchable: false,
        orderable: false,
      },
    ],
    initComplete: function () {
      let searchInput = $("div.dataTables_filter input");
      searchInput.attr("placeholder", "Search ...");
      searchInput.on("keypress", function (e) {
        if (e.which == 13) {
          table.search(this.value).draw();
        }
      });
    },
    language: {
      search: "",
    },
  });
});
</script>
