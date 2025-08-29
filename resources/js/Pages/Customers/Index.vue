<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#CustomerTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#CustomerTable_filter label {
  font-size: 17px;
  color: #000000; /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#CustomerTable_filter input[type="search"] {
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
#CustomerTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#CustomerTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>





<template>
  <Head title="Customers" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16"
  >
    <!-- Include the Header -->
    <Header />

    <!-- Main Content -->
    <div class="w-full md:w-5/6 md:py-12 space-y-24">
      <div class="flex md:flex-row flex-col md:items-center justify-between md:space-y-0 space-y-8">
        <!-- Back Button and Title -->
        <div class="flex items-center space-x-4">
          <Link
            href="/"

          >
            <img src="/images/back-arrow.png" class="w-14 h-14" alt="Back" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Customers
          </p>
        </div>

        <!-- Total Customers -->
        <div class="flex items-center">
          <p class="text-3xl italic font-bold text-black">
            <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">
              {{ totalCustomers.length }}
            </span>
            <span class="text-xl">/ Total Customers</span>
          </p>
        </div>
      </div>

      <template v-if="allcustomers && allcustomers.length > 0">
        <div class="overflow-x-auto">
          <table
            id="CustomerTable"
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
                  Email
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  Address
                </th>
                <th class="p-4 font-semibold tracking-wide text-left uppercase">
                  L/Points
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
                v-for="customer in allcustomers"
                :key="customer.id"
                class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
              >
                <td class="p-4 font-bold border-t border-gray-200">
                  {{ customer.name || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ customer.phone || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ customer.email || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ customer.address || "N/A" }}
                </td>
                <td class="p-4 border-t border-gray-200">
                  {{ customer.loyalty_points || "N/A" }}
                </td>
                <td class="p-4 text-center border-t border-gray-200">
                  <div class="inline-flex items-center w-full space-x-3">
                    <!-- <button
                    v-if="HasRole(['Admin'])"
                      @click="
                        () => {

                          openEditModal(customer);
                        }
                      "
                      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-green-500 to-green-400 transition duration-150 ease-in-out rounded-md hover:from-green-600 hover:to-green-500"
                    >
                      Edit
                    </button>
                    <button
                      @click="
                        () => {

                          openDeleteModal(customer);
                        }
                      "
                      class="w-full px-4 py-2 font-medium text-[14px] tracking-wider text-white bg-gradient-to-r from-red-500 to-red-400 transition duration-150 ease-in-out rounded-md hover:from-red-600 hover:to-red-500"
                    >
                      Delete
                    </button> -->

<!-- Edit Button -->
<button
  :class="HasRole(['Admin'])
            ? 'px-4 py-2 bg-green-500 text-white rounded-lg'
            : 'px-4 py-2 bg-green-400 text-white rounded-lg cursor-not-allowed'"
  :title="HasRole(['Admin'])
            ? ''
            : 'You do not have permission to edit'"
  :disabled="!HasRole(['Admin'])"
  @click="() => { if (HasRole(['Admin'])) openEditModal(customer); }"
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
  @click="() => { if (HasRole(['Admin'])) openDeleteModal(customer); }"
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
            No Customers available
          </p>
        </div>
      </template>
    </div>
  </div>
  <Footer />

  <CustomerUpdateModel
    :customer="allcustomers"
    :selected-customer="selectedCustomer"
    v-model:open="isEditModalOpen"
  />

  <CustomerDeleteModel
    :customer="allcustomers"
    :selected-customer="selectedCustomer"
    v-model:open="isDeleteModalOpen"
  />
</template>

<script setup>

import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, router } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import CustomerDeleteModel from "@/Components/custom/CustomerDeleteModel.vue";
import CustomerUpdateModel from "@/Components/custom/CustomerUpdateModel.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

defineProps({
  allcustomers: Array,
  totalCustomers: Array,
});






const form = useForm({});

const openEditModal = (customer) => {
  console.log("Opening edit modal for customer:", customer);
  selectedCustomer.value = customer;
  isEditModalOpen.value = true;
};

const openDeleteModal = (customer) => {
  selectedCustomer.value = customer;
  isDeleteModalOpen.value = true;
};

const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedCustomer = ref(null);

$(document).ready(function () {
  let table = $("#CustomerTable").DataTable({
    dom: "Bfrtip",
    pageLength: 10,
    buttons: [],
    columnDefs: [
      {
        targets: [4],
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

