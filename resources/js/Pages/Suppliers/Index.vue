<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#SupplierTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#SupplierTable_filter label {
  font-size: 17px;
  color: #000000; /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#SupplierTable_filter input[type="search"] {
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
#SupplierTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#SupplierTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>

<template>
  <Head title="Suppliers" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-full md:w-5/6 py-12 space-y-24">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4"></div>
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">
            
            {{ allsuppliers.length }}
          </span>
          <span class="text-xl">/ Total Suppliers</span>
        </p>
      </div>
      <div class="flex md:flex-row flex-col w-full">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Suppliers
          </p>
        </div>
        
        <div class="flex justify-end w-full">
          <!-- <p

              @click="() => { playClickSound(); isCreateModalOpen = true; }"
            class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-pointer rounded-xl"
          >
            <i class="pr-4 ri-add-circle-fill"></i> Add More Suppliers
          </p> -->

          <!-- <p
            v-if="HasRole(['Admin'])"
            @click="
              () => {
                isCreateModalOpen = true;
              }
            "
            class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded rounded-xl"
          >
            <i class="pr-4 ri-add-circle-fill"></i> Add More Suppliers
          </p> -->

          <p
            @click="
              () => {
                if (HasRole(['Admin'])) {
                  isCreateModalOpen = true;
                }
              }
            "
            :class="
              HasRole(['Admin'])
                ? 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl'
                : 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'
            "
            :title="
              HasRole(['Admin'])
                ? ''
                : 'You do not have permission to add more Color'
            "
          >
            <i class="md:pr-4 ri-add-circle-fill"></i> Add More Suppliers
          </p>
        </div>
      </div>
      <template v-if="allsuppliers && allsuppliers.length > 0">
        <div class="overflow-x-auto">
          <table
            id="SupplierTable"
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
                  Contact
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Image
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Email
                </th>

                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Address
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
                v-for="supplier in allsuppliers"
                :key="supplier.id"
                class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
              >
                <td class="p-4 font-bold border-t border-gray-200">
                  {{ supplier.name || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ supplier.contact || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  <!-- <img
                    v-if="supplier.image"
                    :src="supplier.image"
                    alt="Supplier Image"
                    class="object-cover rounded-md shadow h-15 w-15"
                  />
                  <span v-else class="text-gray-500">N/A</span> -->

                  <img
                    :src="
                      supplier.image
                        ? `/${supplier.image}`
                        : '/images/placeholder.jpg'
                    "
                    alt="Supplier Image"
                    class="object-cover rounded-md shadow h-15 w-15"
                  />
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ supplier.email || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ supplier.address || "N/A" }}
                </td>
                <td class="p-4 text-center border-t border-gray-200">
                  <div class="inline-flex items-center w-full space-x-3">
                    <!-- <button
                      v-if="HasRole(['Admin'])"
                      @click="
                        () => {
                          openEditModal(supplier);
                        }
                      "
                      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-green-500 to-green-400 transition duration-150 ease-in-out rounded-md hover:from-green-600 hover:to-green-500"
                    >
                      Edit
                    </button>
                    <button
                      v-if="HasRole(['Admin'])"
                      @click="
                        () => {
                          openDeleteModal(supplier);
                        }
                      "
                      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-red-500 to-red-400 transition duration-150 ease-in-out rounded-md hover:from-red-600 hover:to-red-500"
                    >
                      Delete
                    </button> -->

                    <!-- Edit Button -->
                    <button
                      :class="
                        HasRole(['Admin'])
                          ? 'px-4 py-2 bg-green-500 text-white rounded-lg'
                          : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'
                      "
                      :title="
                        HasRole(['Admin'])
                          ? ''
                          : 'You do not have permission to edit'
                      "
                      :disabled="!HasRole(['Admin'])"
                      @click="
                        () => {
                          if (HasRole(['Admin'])) openEditModal(supplier);
                        }
                      "
                    >
                      Edit
                    </button>

                    <!-- Delete Button -->
                    <button
                      :class="
                        HasRole(['Admin'])
                          ? 'px-4 py-2 bg-red-500 text-white rounded-lg ml-2'
                          : 'px-4 py-2 bg-red-400 text-white rounded-lg cursor-not-allowed ml-2'
                      "
                      :title="
                        HasRole(['Admin'])
                          ? ''
                          : 'You do not have permission to delete'
                      "
                      :disabled="!HasRole(['Admin'])"
                      @click="
                        () => {
                          if (HasRole(['Admin'])) openDeleteModal(supplier);
                        }
                      "
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
            No Suppliers Available
          </p>
        </div>
      </template>
    </div>
  </div>
  <!-- Modal Components -->
  <SupplierCreateModel
    :suppliers="allsuppliers"
    v-model:open="isCreateModalOpen"
  />
  <SupplierDeleteModel
    :suppliers="allsuppliers"
    :selected-supplier="selectedSupplier"
    v-model:open="isDeleteModalOpen"
  />

  <SupplierUpdateModel
    :suppliers="allsuppliers"
    v-model:open="isEditModalOpen"
    :selected-supplier="selectedSupplier"
  />

  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import SupplierCreateModel from "@/Components/custom/SupplierCreateModel.vue";
import SupplierDeleteModel from "@/Components/custom/SupplierDeleteModel.vue";
import SupplierUpdateModel from "@/Components/custom/SupplierUpdateModel.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

defineProps({
  allsuppliers: Array, // Array of suppliers
  totalSuppliers: Number, // Total count of suppliers
});

const openEditModal = (supplier) => {
  console.log("Opening edit modal for supplier:", supplier);
  selectedSupplier.value = supplier;
  isEditModalOpen.value = true;
};

const openDeleteModal = (supplier) => {
  selectedSupplier.value = supplier;
  isDeleteModalOpen.value = true;
};

const form = useForm({});

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedSupplier = ref(null);

$(document).ready(function () {
  let table = $("#SupplierTable").DataTable({
    dom: "Bfrtip",
    pageLength: 10,
    buttons: [],
    columnDefs: [
      // Adjust targets if needed, e.g., skip "Actions" column
      {
        targets: [1, 2, 3, 5], // Adjust this based on the current column index of "Image" or other columns
        searchable: false,
        orderable: false,
      },
    ],
    initComplete: function () {
      let searchInput = $("div.dataTables_filter input");
      searchInput.attr("placeholder", "Search ...");
      searchInput.off("keyup");
      searchInput.on("keypress", function (e) {});
    },
    language: {
      search: "",
    },
  });
});
</script>

