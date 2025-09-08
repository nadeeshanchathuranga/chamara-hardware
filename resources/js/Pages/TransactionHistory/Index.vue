<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#TransitionTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px; /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#TransitionTable_filter label {
  font-size: 17px;
  color: #000000; /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#TransitionTable_filter input[type="search"] {
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
#TransitionTable_filter input[type="search"]:focus {
  outline: none; /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none; /* Removes any focus box-shadow */
}

#TransitionTable_filter {
  float: left;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>

<template>
    <Head title="Order History" />
     <Banner />
     <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16">
        <Header />
        <div class="w-full md:w-5/6 py-12 space-y-24">
            <div class="flex items-center justify-between float-end">
                <p class="text-3xl italic font-bold text-black">
                <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
                    totalhistoryTransactions

                }}</span>
                <span class="text-xl">/ Total History Transition</span>
                </p>
            </div>

            <div class="flex w-full">
                <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
                <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" />
                </Link>
                <p class="text-4xl font-bold tracking-wide text-black uppercase">
                    Order History
                </p>
                </div>
                <div class="flex justify-end md:inline hidden w-full"></div>
            </div>


            <template v-if="allhistoryTransactions && allhistoryTransactions.length > 0">
                <div class="overflow-x-auto">
                <table
                    id="TransitionTable" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[12px] text-white border-b border-blue-700">
                        <th class="p-4 font-semibold tracking-wide text-left uppercase">#</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase">Oredr ID</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase">Total Amount</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase"> Discount</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase">Payment Method</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase">Sale Date</th>
                        <th class="p-4 font-semibold tracking-wide text-left uppercase"> Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-[13px] font-normal">
                        <tr
                            v-for="(history, index) in allhistoryTransactions"
                            :key="history.id"
                            class="transition duration-200 ease-in-out hover:bg-gray-200 hover:shadow-lg"
                        >
                            <td class="px-6 py-3 text- first-letter:">{{ index + 1 }}</td>

<td class="p-4 font-bold border-gray-200">
  {{ history.order_id || "N/A" }}
</td>

<td class="p-4 font-bold border-gray-200">
  {{ ((history.total_amount || 0) - (history.discount || 0) - (history.custom_discount || 0)).toFixed(2) }}
</td>

<td class="p-4 font-bold border-gray-200">
  {{ ((parseFloat(history.discount) || 0) + (parseFloat(history.custom_discount) || 0)).toFixed(2) }}
</td>

<td class="p-4 font-bold border-gray-200">
  {{ history.payment_method || "N/A" }}
</td>

<td class="p-4 font-bold border-gray-200">
  {{ history.sale_date || "N/A" }}
</td>
                            <td class="p-4 font-bold border-gray-200">
                                <button
                                    @click="printReceipt(history)"
                                    class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 mr-4"
                                >
                                    Print
                                </button>
                                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" @click="deleteReceipt(history.order_id)">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    </tbody>
                </table>
                </div>
            </template>

            <template v-else>
                <div class="col-span-4 text-center text-blue-500">
                <p class="text-center text-red-500 text-[17px]">
                    No Stock Transition Available
                </p>
                </div>
            </template>
        </div>
     </div>
<Footer />
</template>


<script setup>
import { ref } from "vue";
import { router,useForm } from "@inertiajs/vue3";
import { Head, Link } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { HasRole } from "@/Utils/Permissions";

const props = defineProps({
  allhistoryTransactions: Array,
  totalhistoryTransactions: Number,
  companyInfo: Array
});
const form = useForm({});


const deleteReceipt = (orderId) => {
  if (confirm("Are you sure you want to delete this record? This action cannot be undone.")) {
    router.post(route("transactions.delete"), { order_id: orderId }, {
      onError: (error) => {
        alert("Error: " + (error.message || "Something went wrong."));
      },
    });
  }
};



$(document).ready(function () {
  let table = $("#TransitionTable").DataTable({
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

const printReceipt = (history) => {

const companyData = props.companyInfo[0];
const getSafeValue = (obj, path) => {
    return path.split('.').reduce((acc, part) => (acc && acc[part] ? acc[part] : ''), obj);
  };




const saleItems = Array.isArray(history.sale_items) ? history.sale_items : [];

const productRows = saleItems.map((item) => {
  const name = item?.name || item?.product?.name || "Item";
  const qty = Number(item?.quantity) || 0;

  // Base/original price (fallbacks supported)
  const originalPrice = Number(
    item?.unit_price ?? item?.selling_price ?? item?.originalPrice
  ) || 0;

  // Determine discounted price
  const hasDiscount = !!item?.apply_discount && Number(item?.discount) > 0;
  let discountedPrice = originalPrice;

  if (hasDiscount) {
    if (item?.discounted_price != null) {
      discountedPrice = Number(item.discounted_price) || originalPrice;
    } else if (item?.discount_type === "percent") {
      discountedPrice = originalPrice * (1 - (Number(item.discount) || 0) / 100);
    } else {
      // fixed amount off
      discountedPrice = originalPrice - (Number(item.discount) || 0);
    }
    if (discountedPrice < 0) discountedPrice = 0;
  }

  const discountBadge = hasDiscount
    ? (item?.discount_type === "percent"
        ? `${Number(item.discount)}% off`
        : `${(Number(item.discount) || 0).toFixed(2)} LKR off`)
    : "";

  return `
    <tr>
      <td colspan="3">
        <b>${name}</b><br>
        <small style="font-size: 12px; font-weight:600;">
          Selling Price: ${originalPrice.toFixed(2)}
        </small>
        ${
          hasDiscount
            ? `<small
                 style="
                   background-color:#000;
                   color:#fff;
                   font-size:9px;
                   font-weight:600;
                   padding:2px 6px;
                   border-radius:4px;
                   margin:0 8px;
                 "
               >${discountBadge}</small>`
            : ""
        }
      </td>
    </tr>
    <tr style="border-bottom:1px dashed #000; font-size:14px; font-weight:600;">
      <td style="text-align:left;"></td>
      <td style="text-align:center;">${qty} × ${discountedPrice.toFixed(2)}</td>
      <td style="text-align:right;">${(discountedPrice * qty).toFixed(2)}</td>
    </tr>
  `;
}).join("");









  const receiptContent = `
  <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Receipt</title>
      <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
        }
        body {
            background-color: #ffffff;
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            font-size: 10px;
            margin: 4px 0;
        }
        .section {
            margin-bottom: 16px;
            padding-top: 8px;
            border-top: 1px solid #000;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 8px;
        }
        .info-row p {
            margin: 0;
            font-weight: bold;
        }
        .info-row small {
            font-weight: normal;
        }
        table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            text-align: left;
        }
        table td {
            text-align: right;
        }
        table td:first-child {
            text-align: left;
        }
        .totals {
            border-top: 1px solid #000;
            padding-top: 8px;
            font-size: 12px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .totals div:nth-child(4) {
            font-size: 14px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 16px;
        }
        .footer p {
            margin: 6px 0;
        }
        .footer .italic {
            font-style: italic;
        }
        .text-right {
            text-align: right;
        }
      </style>
    </head>
    <body>
      <div class="receipt-container">

      <div class="header">
        <h1>${companyData.name}</h1>
        <p>${companyData.address}</p>
        <p>${companyData.phone} | ${companyData.phone2} | ${companyData.email}</p>
      </div>

        <div class="section">
            <div class="info-row">
                <div>
                    <p>Date:</p>
                    <small>
                        ${new Date(history.created_at).toLocaleDateString('en-US', {
                        dateStyle: 'medium',
                        })}

                    </small>
                </div>
                <div>
                    <p>Order No:</p>
                    <small>${history.order_id}</small>
                </div>
            </div>
            <div class="info-row">
                <div>
                    <p>Customer:</p>
                    <small>${history.customer?.name || ' '}</small>
                </div>

                <div>
                    <p>Cashier:</p>
                    <small>${history.user?.name || ' '}</small>
                </div>
            </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
           <th style="text-align:left;">Item</th>
       <th style="text-align:center;">Qty × Price</th>
       <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${productRows}
                </tbody>
            </table>
        </div>


        <div class="totals">
            <div>
                <span>Sub Total</span>
                <span>${history.total_amount || 0} LKR</span>
            </div>
            <div>
                <span>Discount</span>
                <span>${history.discount || 0} LKR</span>
            </div>
            <div>
                <span>Custome Discount</span>
                <span>${history.custom_discount || 0} LKR</span>
            </div>
            <div>
                <span>Total</span>
                <span>${(history.total_amount - (history.discount || 0) -(history.custom_discount || 0)).toFixed(2)} LKR</span>
            </div>
            <div>
                <span>Cash</span>
                <span>${history.cash || 0} LKR</span>
            </div>
            <div>
                <span>Balance</span>
                <span>${(history.cash - (history.total_amount - (history.discount || 0) -(history.custom_discount || 0))).toFixed(2)} LKR</span>
            </div>
        </div>

        <div class="footer">
            <p>THANK YOU COME AGAIN</p>
            <p class="italic">Let the quality define its own standards</p>
            <p style="font-weight: bold;">Powered by JAAN Network (Pvt) Ltd.</p>
            <p>${new Date(history.created_at).toLocaleTimeString('en-US', {
                        timeStyle: 'long',
                        hourCycle: 'h23',
                        })}</p>
        </div>
      </div>
    </body>
    </html>
  `;
  const printWindow = window.open('', '_blank');
  printWindow.document.write(receiptContent);
  printWindow.document.close();
  printWindow.focus();
  printWindow.print();
  printWindow.close();
};




</script>
