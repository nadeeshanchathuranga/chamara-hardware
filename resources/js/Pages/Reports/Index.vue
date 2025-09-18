<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#stockQtyTbl_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px;
  /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#stockQtyTbl_filter label {
  font-size: 17px;
  color: #000000;
  /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#stockQtyTbl_filter input[type="search"] {
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

#stockQtyTbl_filter input[type="search"]:focus {
  outline: none;
  /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none;
  /* Removes any focus box-shadow */
}

#stockQtyTbl_filter {
  float: left;
}

/* Style the filter container */
#salesTbl_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px;
  /* Add spacing below the filter */
}

/* Style the label and input field inside the filter */
#salesTbl_filter label {
  font-size: 17px;
  color: #000000;
  /* Match text color of the table header */
  display: flex;
  align-items: center;
}

/* Style the input field */
#salesTbl_filter input[type="search"] {
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

#salesTbl_filter input[type="search"]:focus {
  outline: none;
  /* Removes the default outline */
  border: 1px solid #4b5563;
  box-shadow: none;
  /* Removes any focus box-shadow */
}

#salesTbl_filter {
  float: left;
}

/* Style the DataTable */
.dataTables_wrapper {
  margin-bottom: 10px;
}

/* Hide scrollbars completely */
.no-scrollbar {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* Internet Explorer 10+ */
}

.no-scrollbar::-webkit-scrollbar {
  display: none; /* WebKit browsers */
}

/* Responsive table that fits all screen sizes */
.responsive-table {
  table-layout: fixed; /* Use fixed layout for better control */
  width: 100%;
}

.responsive-table th,
.responsive-table td {
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 0.5rem 0.25rem; /* Compact padding */
  font-size: 0.75rem; /* Smaller text for better fit */
  line-height: 1.2;
}

/* Paint Orders table specific column widths */
.responsive-table th:nth-child(1),
.responsive-table td:nth-child(1) { width: 4%; } /* # */

.responsive-table th:nth-child(2),
.responsive-table td:nth-child(2) { width: 8%; } /* Order ID */

.responsive-table th:nth-child(3),
.responsive-table td:nth-child(3) { width: 12%; } /* Customer */

.responsive-table th:nth-child(4),
.responsive-table td:nth-child(4) { width: 12%; } /* Paint Product */

.responsive-table th:nth-child(5),
.responsive-table td:nth-child(5) { width: 12%; } /* Color Card */

.responsive-table th:nth-child(6),
.responsive-table td:nth-child(6) { width: 8%; } /* Can Size */

.responsive-table th:nth-child(7),
.responsive-table td:nth-child(7) { width: 6%; } /* Quantity */

.responsive-table th:nth-child(8),
.responsive-table td:nth-child(8) { width: 10%; } /* Unit Cost */

.responsive-table th:nth-child(9),
.responsive-table td:nth-child(9) { width: 10%; } /* Selling Price */

.responsive-table th:nth-child(10),
.responsive-table td:nth-child(10) { width: 10%; } /* Total Amount */

.responsive-table th:nth-child(11),
.responsive-table td:nth-child(11) { width: 8%; } /* Profit */

.responsive-table th:nth-child(12),
.responsive-table td:nth-child(12) { width: 10%; } /* Sale Date */
</style>



<template>
  <Head title="Reports" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-full py-12 space-y-16">
      <div class="flex md:flex-row flex-col md:items-center items-start justify-between md:space-y-0 space-y-4">
        <div class="flex items-center justify-center space-x-4 ">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Reports
          </p>
        </div>
        <div date-rangepicker class="flex items-center space-x-4">
          <!-- Start Date -->
          <div class="relative ">
            <input
              v-model="startDate"
              type="date"
              class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Start Date"
            />
          </div>
          <span class="text-xl font-bold tracking-wider text-blue-600">To</span>
          <!-- End Date -->
          <div class="relative">
            <input
              v-model="endDate"
              type="date"
              class="text-xl font-normal tracking-wider text-blue-600 bg-white border border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="End Date"
            />
          </div>
          <!-- Filter Button -->
          <button
            @click="filterData"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select hidden sm:inline-block"
          >
            Filter
          </button>
          <Link
            href="/reports"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select hidden sm:inline-block"
          >
            Reset
          </Link>

        </div>
        <div class="w-full flex justify-center items-center space-x-4 md:hidden">
            <!-- Filter Button -->
          <button
            @click="filterData"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
          >
            Filter
          </button>
          <Link
            href="/reports"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
          >
            Reset
          </Link>
          </div>
      </div>

    </div>
    <!-- Statistic Boxes -->
    <div class="grid w-full md:grid-cols-6 grid-cols-3 gap-4">
      <!-- Total Sales -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#EC6116] w-full space-y-4 rounded-2xl bg-[#EC611666] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Total Sales
          </h2>
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Amount
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ (totalSaleAmount + (paintOrderSummary.total_amount || 0)).toLocaleString() }} LKR</p>
        </div>
      </div>
      <!-- Net Profit -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#488D3F] w-full space-y-8 rounded-2xl bg-[#488D3F66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Net Profit
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ (netProfit + (paintOrderSummary.total_profit || 0)).toLocaleString() }} LKR</p>
        </div>
      </div>
      <!-- Total Products -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#16D0EC] w-full space-y-4 rounded-2xl bg-[#16D0EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Total Discount
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">
            {{ (totalDiscount || 0) + (customeDiscount || 0) }} LKR
          </p>
        </div>
      </div>
      <!-- Average Transaction Value -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#F6F20E] w-full space-y-4 rounded-2xl bg-[#F6F20E66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col text-center items-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Avg. Transaction Value
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">
            {{ (totalTransactions + (paintOrderSummary.total_orders || 0)) > 0 ? Math.round((totalSaleAmount + (paintOrderSummary.total_amount || 0)) / (totalTransactions + (paintOrderSummary.total_orders || 0))) : 0 }} LKR
          </p>
        </div>
      </div>
      <!-- Number of Transactions -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#9E16EC] w-full space-y-4 rounded-2xl bg-[#9E16EC66] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Number of Transactions
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ (totalTransactions + (paintOrderSummary.total_orders || 0)).toLocaleString() }}</p>
        </div>
      </div>
      <!-- Total Customers -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#EC16D7] w-full space-y-4 rounded-2xl bg-[#EC16D766] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
            Total Number of Customers
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-black">{{ totalCustomer }}</p>
        </div>
      </div>
    </div>

    <!-- Paint Orders Statistics Section -->
    <div class="grid w-full md:grid-cols-4 grid-cols-2 gap-4">
      <!-- Total Paint Orders -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#059669] w-full space-y-4 rounded-2xl bg-[#059669] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-lg font-extrabold tracking-wide text-white uppercase">
            Paint Orders
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-white">{{ paintOrderSummary.total_orders || 0 }}</p>
        </div>
      </div>

      <!-- Paint Orders Revenue -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#0891b2] w-full space-y-4 rounded-2xl bg-[#0891b2] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-lg font-extrabold tracking-wide text-white uppercase">
            Paint Orders Revenue
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-white">{{ (paintOrderSummary.total_amount || 0).toLocaleString() }} LKR</p>
        </div>
      </div>

      <!-- Paint Orders Profit -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#dc2626] w-full space-y-4 rounded-2xl bg-[#dc2626] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-lg font-extrabold tracking-wide text-white uppercase">
            Paint Orders Profit
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-white">{{ (paintOrderSummary.total_profit || 0).toLocaleString() }} LKR</p>
        </div>
      </div>

      <!-- Average Paint Order Value -->
      <div
        class="py-6 flex flex-col justify-center items-center border-2 border-[#7c3aed] w-full space-y-4 rounded-2xl bg-[#7c3aed] shadow-lg transform transition-transform duration-300 hover:-translate-y-4"
      >
        <div class="flex flex-col items-center text-center justify-center">
          <h2 class="text-lg font-extrabold tracking-wide text-white uppercase">
            Avg. Paint Order Value
          </h2>
        </div>
        <div class="flex flex-col items-center justify-center">
          <p class="text-2xl font-bold text-white">
            {{ paintOrderSummary.total_orders > 0 ? ((paintOrderSummary.total_amount || 0) / paintOrderSummary.total_orders).toFixed(0) : 0 }} LKR
          </p>
        </div>
      </div>
    </div>


     <div class="grid w-full md:grid-cols-3 grid-cols-2 gap-8">
            <!-- Total Products -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#ffb224] w-full space-y-4 rounded-2xl bg-[#ffb224] shadow-lg">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Quantity In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">{{ totalQty }} QTY </p>
                </div>
            </div>
            <!-- Average Transaction Value -->
            <!-- Number of Transactions -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#41ec16] w-full space-y-4 rounded-2xl bg-[#41ec16] shadow-lg ">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Selling Price In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">{{ totalSellingPrice.toFixed(2) }} LKR</p>
                </div>
            </div>
            <!-- Total Customers -->
            <div
                class="py-6 flex flex-col justify-center items-center border-2 border-[#3e41ff] w-full space-y-4 rounded-2xl bg-[#3e41ff] shadow-lg ">
                <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="text-xl font-extrabold tracking-wide text-black uppercase">
                        Total Cost Price In Stock:
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <p class="text-2xl font-bold text-black">
                        {{ totalRetailValue.toFixed(2) }} LKR</p>
                </div>
            </div>
        </div>
    <!-- Charts Section -->
    <div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4">
      <!-- Chart 1 -->
      <!-- <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-2xl font-medium tracking-wide text-slate-700 text-center pb-4 pt-12">
                      Sales by Category
                   </h2>

                   <Doughnut :data="chartData2" :options="chartOptions2" />
                </div>
                </div> -->

      <div
        class="flex flex-col justify-between items-center md:w-1/3 w-full bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <!-- Header with Title and Button -->
          <div class="w-full flex justify-between items-center pb-8">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Employee Sales
            </h2>
            <button
              @click="downloadPDF"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>
          <!-- Doughnut Chart -->
          <div class="w-full h-full flex justify-center items-center">
            <Doughnut :data="chartData4" :options="chartOptions4" />
          </div>
        </div>
      </div>

      <!-- Chart 3 -->
      <div
        class="flex flex-col justify-between items-center md:w-1/3 w-full bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <div class="w-full flex justify-between items-center md:pt-12">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Product
            </h2>
            <button
              @click="downloadPDF2"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>

          <Pie :data="chartData" :options="chartOptions" />
        </div>
      </div>
      <div
        class="flex flex-col justify-between items-center md:w-1/3 w-full bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <div class="w-full flex justify-between items-center md:pt-12">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Sales By Payment Method
            </h2>
            <button
              @click="downloadPDF3"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>
          <Doughnut :data="chartData1" :options="chartOptions1" />
        </div>
      </div>
      <br></br>
      <!-- <div
        class="flex flex-col justify-between items-center md:w-1/3 w-full bg-white border-4 border-black rounded-xl h-[450px]"
      >
        <div class="chart-container w-full p-4">
          <div class="w-full flex justify-between items-center md:pt-12">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Sales By Payment Method
            </h2>
            <button
              @click="downloadPDF3"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>
          <Doughnut :data="chartData1" :options="chartOptions1" />
        </div>
      </div> -->
    </div>
    <div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4 ">
      <!-- Chart 1 -->
      <!-- <div
                class="flex flex-col justify-between items-center w-1/3 bg-white border-4 border-black rounded-xl h-[450px]">
                <div class="chart-container">
                   <h2 class="text-2xl font-medium tracking-wide text-slate-700 text-center pb-4 pt-12">
                      Sales by Category
                   </h2>

                   <Doughnut :data="chartData2" :options="chartOptions2" />
                </div>
                </div> -->
      <!-- <div
        class="flex flex-col justify-between items-center md:w-1/2 w-full bg-white border-4 border-black rounded-xl h-[500px] p-4"
      >
        <div class="chart-container w-full h-full relative p-4">
          <div class="w-full flex justify-between items-center pb-4">
            <h2
              class="text-2xl font-medium tracking-wide text-slate-700 text-left"
            >
              Top Products Stock Chart
            </h2>
            <button
              @click="downloadTopProductsStockPDF"
              class="w-full mt-6 px-4 py-2 text-md font-normal tracking-wider text-white bg-orange-600 rounded-lg custom-select hover:bg-orange-700 hover:shadow-lg"
            >
              Download PDF
            </button>
          </div>

          <Doughnut :data="chartData5" :options="chartOptions5" />
        </div>
      </div> -->


      <div class="w-full bg-white border-4 border-black rounded-xl p-6">
  <h2 class="text-2xl font-semibold text-slate-700 text-center pb-4">
    Top Products Stock Table
  </h2>

  <!-- Buttons and Total Price in a Single Row -->
  <div class="flex justify-between items-center pb-4">
    <!-- Left: Buttons -->
    <div class="flex gap-4">
      <!-- <button
        @click="downloadTable"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download Excel
      </button> -->

      <button
        @click="downloadPDFTable"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download PDF
      </button>
    </div>

    <!-- Right: Total Price -->
    <div
      class="py-3 px-6 border-2 border-orange-600 rounded-xl bg-orange-400 shadow-lg text-center"
    >
      <h2 class="text-lg font-extrabold text-black uppercase">Total Price:
      <span class="text-xl font-bold text-black">
        {{ totalPrice.toLocaleString() }} LKR
      </span> </h2>
    </div>
  </div>


  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="no-scrollbar overflow-x-auto">
      <table
        id="stockQtyTbl"
        class="w-full table-auto responsive-table text-gray-800 bg-white"
      >
      <thead>
        <tr class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-700 text-white text-[14px] border-b border-blue-800">
          <th class="p-3 text-left font-semibold">#</th>
          <th class="p-3 text-left font-semibold">Name</th>
          <th class="p-3 text-center font-semibold">QTY</th>
          <th class="p-3 text-center font-semibold">Sales QTY</th>
          <th class="p-3 text-center font-semibold">Cost Price (LKR)</th>
          <th class="p-3 text-center font-semibold">Selling Price (LKR)</th>
          <th class="p-3 text-center font-semibold">Profit (LKR)</th>
          <th class="p-3 text-center font-semibold">Discount (%)</th>
          <th class="p-3 text-center font-semibold">Retail Value</th>
          <th class="p-3 text-center font-semibold">Total Price</th>
        </tr>
      </thead>

      <tbody class="text-[12px] font-medium">
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          class="border-b transition duration-200 hover:bg-gray-100"
        >
          <td class="p-3 text-center">{{ index + 1 }}</td>
          <td class="p-3 font-bold">{{ product.name || "N/A" }}</td>
          <td class="p-3 text-center">{{ product.stock_quantity }}</td>
          <td class="p-3 text-center">{{ product.sales_qty || "0" }}</td>
          <td class="p-3 text-center">{{ product.cost_price || "N/A" }}</td>
          <td class="p-3 text-center">{{ product.selling_price || "N/A" }}</td>
          <td class="p-3 text-center">
            {{ product.selling_price - product.cost_price || 0 }}
          </td>
          <td class="p-3 text-center">{{ product.discount || "N/A" }}</td>
          <td class="p-3 text-center">
            {{
              product.discount <= 100
                ? (
                    product.selling_price *
                    (1 - product.discount / 100)
                  ).toFixed(2)
                : (product.selling_price - product.discount).toFixed(2)
            }}
          </td>
          <td class="p-3 text-center">
            {{ product.sales_qty * product.selling_price || 0 }}
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>

    </div>
  <div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4 ">
    <div class="w-full bg-white border-4 border-black rounded-xl p-6">
      <h2 class="text-2xl font-semibold text-slate-700 text-center pb-4">
        Top Sales Table
      </h2>

  <!-- Buttons and Total Price in a Single Row -->
  <div class="flex justify-between items-center pb-4">
    <!-- Left: Buttons -->
    <div class="flex gap-4">
      <!-- <button
        @click="downloadTable"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download Excel
      </button> -->

      <button
        @click="downloadPDFTable1"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download PDF
      </button>
    </div>

    <!-- Right: Total Price -->
    <div
      class="py-3 px-6 border-2 border-orange-600 rounded-xl bg-orange-400 shadow-lg text-center"
    >
      <h2 class="text-lg font-extrabold text-black uppercase">Total Price:
      <span class="text-xl font-bold text-black">
        {{ totalPrice.toLocaleString() }} LKR
      </span> </h2>
    </div>
  </div>
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="no-scrollbar overflow-x-auto">
      <table
        id="salesTbl"
        class="w-full table-auto responsive-table text-gray-800 bg-white"
      >
      <thead>
        <tr class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-700 text-white text-[14px] border-b border-blue-800">
          <th class="p-3 text-left font-semibold">#</th>
          <th class="p-3 text-left font-semibold">Supplier Name</th>
          <th class="p-3 text-center font-semibold">Product</th>
          <th class="p-3 text-center font-semibold">Sales QTY</th>
          <th class="p-3 text-center font-semibold">Total Quantity</th>
          <th class="p-3 text-center font-semibold">Remaining QTY</th>
          <th class="p-3 text-center font-semibold">Selling Price (LKR)</th>
          <th class="p-3 text-center font-semibold">Cost Price</th>
          <th class="p-3 text-center font-semibold">Total Price</th>
        </tr>
      </thead>

      <tbody class="text-[12px] font-medium">
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          class="border-b transition duration-200 hover:bg-gray-100"
        >
          <td class="p-3 text-center">{{ index + 1 }}</td>
          <td class="p-3 font-bold">{{ product.supplier?.name || "N/A" }}</td>
          <td class="p-3 text-center">{{ product.name }}</td>  
          <td class="p-3 text-center">{{ product.sales_qty || "0" }}</td>
          <td class="p-3 text-center">{{ product.total_quantity || "0" }}</td>
          <td class="p-3 text-center">{{  product.total_quantity - product.sales_qty > 0
              ? product.total_quantity - product.sales_qty
              : 0 }}</td>
          <td class="p-3 text-center">{{ product.selling_price || "N/A" }}</td>
          <td class="p-3 text-center">{{ product.cost_price || "N/A" }}</td>
          <td class="p-3 text-center">
            {{ product.sales_qty * product.selling_price || 0 }}
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>
</div>

<div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4 ">
    <div class="w-full bg-white border-4 border-black rounded-xl p-6">
      <h2 class="text-2xl font-semibold text-slate-700 text-center pb-4">
        Monthly Sales  Table
      </h2>

  <!-- Buttons and Total Price in a Single Row -->
  <div class="flex justify-between items-center pb-4">
    <!-- Left: Buttons -->
    <div class="flex gap-4">
      <!-- <button
        @click="downloadTable"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download Excel
      </button> -->

      <button
        @click=" downloadPDFTableMonthly"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download PDF
      </button>
    </div>

    <!-- Right: Total Price -->
    <!-- <div
      class="py-3 px-6 border-2 border-orange-600 rounded-xl bg-orange-400 shadow-lg text-center"
    >
      <h2 class="text-lg font-extrabold text-black uppercase">Total Price:
      <span class="text-xl font-bold text-black">
        {{ totalPrice.toLocaleString() }} LKR
      </span> </h2>
    </div> -->
  </div>
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="no-scrollbar overflow-x-auto">
      <table
        id="MonthlySalesTbl"
        class="w-full table-auto responsive-table text-gray-800 bg-white"
      >
      <thead>
        <tr class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-700 text-white text-[14px] border-b border-blue-800">
          <th class="p-3 text-left font-semibold">#</th>
          <th class="p-3 text-center font-semibold">Month</th>
          <th class="p-3 text-center font-semibold">Date Range</th>
          <th class="p-3 text-center font-semibold">Number of Sales</th>
          <th class="p-3 text-center font-semibold">Total Amount(LKR)</th>
        </tr>
      </thead>

      <tbody class="text-[12px] font-medium">
        <tr
          v-for="(monthlySale, index) in monthlySalesData"
          :key="index"
          class="border-b transition duration-200 hover:bg-gray-100"
        >
          <td class="p-3 text-center">{{ index + 1 }}</td>
          <td class="p-3 text-center">{{ monthlySale.month_name}} {{ monthlySale.year }}</td>
          <td class="p-3 text-center">{{ monthlySale.date_range }}</td>
          <td class="p-3 text-center">{{ monthlySale.number_of_sales }}</td>
          <td class="p-3 text-center">
            {{ monthlySale.total_amount.toLocaleString() }}
          </td>
      
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>
</div>
<div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4 ">
    <div class="w-full bg-white border-4 border-black rounded-xl p-6">
      <h2 class="text-2xl font-semibold text-slate-700 text-center pb-4">
        Return Items Table
      </h2>

  <!-- Buttons and Total Price in a Single Row -->
  <div class="flex justify-between items-center pb-4">
    <!-- Left: Buttons -->
    <div class="flex gap-4">
      <!-- <button
        @click="downloadTable"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download Excel
      </button> -->

      <button
        @click="downloadPDFTableReturn"
        class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
      >
        Download PDF
      </button>
    </div>

    <!-- Right: Total Price -->
    <!-- <div
      class="py-3 px-6 border-2 border-orange-600 rounded-xl bg-orange-400 shadow-lg text-center"
    >
      <h2 class="text-lg font-extrabold text-black uppercase">Total Price:
      <span class="text-xl font-bold text-black">
        {{ totalPrice.toLocaleString() }} LKR
      </span> </h2>
    </div> -->
  </div>
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="no-scrollbar overflow-x-auto">
      <table
        id="StockTransactionTbl"
        class="w-full table-auto responsive-table text-gray-800 bg-white"
      >
      <thead>
        <tr class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-700 text-white text-[14px] border-b border-blue-800">
          <th class="p-3 text-left font-semibold">#</th>
          <th class="p-3 text-center font-semibold">Product Name</th>
          <th class="p-3 text-center font-semibold">Transaction Date</th>
          <th class="p-3 text-center font-semibold">Quantity</th>
          <th class="p-3 text-center font-semibold">Selling Price</th>
          <th class="p-3 text-center font-semibold">Total Selling Price</th> 
        </tr>
      </thead>

      <tbody class="text-[12px] font-medium">
        <tr
          v-for="(stock, index) in stockTransactionsReturn"
          :key="index"
          class="border-b transition duration-200 hover:bg-gray-100"
        >
          <td class="p-3 text-center">{{ index + 1 }}</td>
          <td class="p-3 text-center">{{ stock.product?.name }}</td>
          <td class="p-3 text-center">{{ stock.transaction_date }}</td>
          <td class="p-3 text-center">{{ stock.quantity}}</td>
          <td class="p-3 text-center">{{ stock.product?.selling_price}}</td>
          <td class="p-3 text-center">
            {{ (stock.quantity * stock.product?.selling_price).toLocaleString() }}
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>
</div>

<!-- Paint Orders Table -->
<div class="flex md:flex-row flex-col items-center justify-center w-full h-full md:space-x-4 md:space-y-0 space-y-4">
  <div class="w-full bg-white border-4 border-black rounded-xl p-6">
    <h2 class="text-2xl font-semibold text-slate-700 text-center pb-4">
      Paint Orders Sales Table
    </h2>

    <!-- Buttons and Summary in a Single Row -->
    <div class="flex justify-between items-center pb-4">
      <!-- Left: Buttons -->
      <div class="flex gap-4">
        <button
          @click="downloadPaintOrdersPDF"
          class="px-4 py-2 text-md font-semibold text-white bg-orange-600 rounded-lg hover:bg-orange-700 shadow-md"
        >
          Download PDF
        </button>
      </div>

      <!-- Right: Summary Stats -->
      <div class="grid grid-cols-2 gap-4 text-center">
        <div class="py-2 px-4 border-2 border-green-600 rounded-xl bg-green-400 shadow-lg">
          <h3 class="text-sm font-bold text-black uppercase">Total Orders</h3>
          <span class="text-lg font-bold text-black">{{ paintOrderSummary.total_orders }}</span>
        </div>
        <div class="py-2 px-4 border-2 border-blue-600 rounded-xl bg-blue-400 shadow-lg">
          <h3 class="text-sm font-bold text-black uppercase">Total Amount</h3>
          <span class="text-lg font-bold text-black">{{ paintOrderSummary.total_amount.toLocaleString() }} LKR</span>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
      <div class="no-scrollbar overflow-x-auto">
        <table
          id="paintOrdersTbl"
          class="w-full table-auto responsive-table text-gray-800 bg-white"
        >
          <thead>
            <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white uppercase tracking-wide">
              <th class="px-2 py-4 text-left text-xs font-semibold">#</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Order ID</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Customer</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Paint Product</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Color Card</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Can Size</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Quantity</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Unit Cost</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Selling Price</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Total Amount</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Profit</th>
              <th class="px-2 py-4 text-left text-xs font-semibold">Sale Date</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <tr
              v-for="(order, index) in paintOrderDetails"
              :key="index"
              class="bg-white hover:bg-gray-50"
            >
              <td class="px-2 py-3 text-xs">{{ index + 1 }}</td>
              <td class="px-2 py-3 text-xs font-medium">#{{ order.order_id }}</td>
              <td class="px-2 py-3 text-xs">
                <div class="truncate" :title="order.customer_name">
                  {{ order.customer_name || 'N/A' }}
                </div>
              </td>
              <td class="px-2 py-3 text-xs">
                <div class="truncate" :title="order.paint_product">
                  {{ order.paint_product || 'N/A' }}
                </div>
              </td>
              <td class="px-2 py-3 text-xs">
                <div class="truncate" :title="order.color_card">
                  {{ order.color_card || 'N/A' }}
                </div>
              </td>
              <td class="px-2 py-3 text-xs font-medium">{{ order.can_size }}</td>
              <td class="px-2 py-3 text-xs">{{ order.quantity }}</td>
              <td class="px-2 py-3 text-xs">{{ Number(order.unit_cost).toFixed(2) }}</td>
              <td class="px-2 py-3 text-xs">{{ Number(order.selling_price).toFixed(2) }}</td>
              <td class="px-2 py-3 text-xs font-medium">{{ Number(order.total_amount).toFixed(2) }}</td>
              <td class="px-2 py-3 text-xs font-medium" :class="order.profit > 0 ? 'text-green-600' : 'text-red-600'">
                {{ Number(order.profit).toFixed(2) }}
              </td>
              <td class="px-2 py-3 text-xs">{{ order.sale_date }}</td>
            </tr>
            <tr v-if="!paintOrderDetails.length">
              <td colspan="12" class="px-4 py-6 text-center text-gray-500 text-sm">No paint order sales yet.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Batch Management -->






  <Footer />
</template>
<script setup>
import { ref, computed } from "vue";
import { Doughnut } from "vue-chartjs";
import { Pie } from "vue-chartjs";
import { Bar } from "vue-chartjs";
import { Link, router } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import jsPDF from "jspdf";
import "jspdf-autotable";

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement,
} from "chart.js";

// Register necessary ChartJS components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
  LinearScale,
  BarElement
);

// Props from Laravel Inertia
const props = defineProps({
  products: { type: Array, required: true },
  sales: { type: Array, required: true },
  totalSaleAmount: { type: Number, required: true },
  averageTransactionValue: { type: Number, required: true },
  netProfit: { type: Number, required: true },
  totalTransactions: { type: Number, required: true },
  totalDiscount: { type: Number, required: true },
  customeDiscount: { type: Number, required: true },
  totalCustomer: { type: Number, required: true },
  startDate: { type: String, default: "" },
  endDate: { type: String, default: "" },
  categorySales: { type: Object, required: true },
  employeeSalesSummary: { type: Object, required: true },
  monthlySalesData: { type: Array, default: () => [] },
  stockTransactionsReturn: { type: Array, default: () => [] },
  paintOrderSummary: { type: Object, default: () => ({ total_orders: 0, total_amount: 0, total_profit: 0, total_cost: 0 }) },
  paintOrderDetails: { type: Array, default: () => [] },
});

const totalPrice = computed(() => {
  return products.value.reduce((sum, product) => {
    return sum + (product.sales_qty * product.selling_price || 0);
  }, 0);
});

const searchCode = ref('');
const batchProducts = ref([]);
const batchTotalQuantity = ref(0);
const batchRemainingQuantity = ref(0);
const showBatchTable = ref(false);

const fetchProductByCode = async () => {
    try {
        if (!searchCode.value) {
            showBatchTable.value = false;
            return;
        }

        const response = await axios.get('/batch-management/search', {
            params: { code: searchCode.value }
        });

        batchProducts.value = response.data.products;
        batchTotalQuantity.value = response.data.totalQuantity;
        batchRemainingQuantity.value = response.data.remainingQuantity;
        showBatchTable.value = true;
    } catch (error) {
        console.error('Error fetching batch data:', error);
        alert('Error fetching batch data. Please try again.');
    }
};

// Date filters
const startDate = ref(props.startDate);
const endDate = ref(props.endDate);

const products = ref(props.products);
const monthlySalesData = ref(props.monthlySalesData);
const stockTransactionsReturn = ref(props.stockTransactionsReturn);
const paintOrderSummary = ref(props.paintOrderSummary);
const paintOrderDetails = ref(props.paintOrderDetails);
const sales = ref(props.sales);
const totalQty = computed(() => {
  return products.value.reduce(
    (sum, product) => sum + (product.stock_quantity || 0),
    0
  );
});
const totalSellingPrice = computed(() => {
  return products.value.reduce((sum, product) => {
    const stockQuantity = product.stock_quantity || 0;
    const sellingPrice = parseFloat(product.selling_price) || 0;
    return sum + stockQuantity * sellingPrice;
  }, 0);
});


const totalRetailValue = computed(() => {
  return products.value.reduce((sum, product) => {
    const stockQuantity = product.stock_quantity || 0;
    const costPrice = parseFloat(product.cost_price) || 0;
    return sum + stockQuantity * costPrice;
  }, 0);
});










const downloadPDFTable = () => {
  const doc = new jsPDF("p", "mm", "a4"); // Portrait, A4 size

  // Title for the PDF
  doc.setFontSize(18);
  doc.text("Top Products Stock Table", 14, 15);

  // Prepare table headers
  const tableColumn = [
    "#",
    "Name",
    "QTY",
    "Sales QTY",
    "Cost Price (LKR)",
    "Selling Price (LKR)",
    "Profit (LKR)",
    "Discount (%)",
    "Retail Value",
    "Total Price",
  ];

  // Prepare table data
  const tableRows = products.value.map((product, index) => [
    index + 1,
    product.name || "N/A",
    product.stock_quantity || "N/A",
    product.sales_qty || "0",
    product.cost_price || "N/A",
    product.selling_price || "N/A",
    product.selling_price - product.cost_price || 0,
    product.discount || "N/A",
    product.discount <= 100
      ? (product.selling_price * (1 - product.discount / 100)).toFixed(2)
      : (product.selling_price - product.discount).toFixed(2),
    product.sales_qty * product.selling_price || 0,
  ]);

  // Calculate total sum of "Total Price"
  const totalSum = tableRows.reduce((sum, row) => sum + row[9], 0);

  // Add a total row at the end
  tableRows.push(["", "Total", "", "", "", "", "", "", "", totalSum.toFixed(2)]);

  // Adjust column widths
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 25, // Adjust start position to prevent overlap with title
    theme: "striped",
    styles: { fontSize: 10 },
    headStyles: { fillColor: [44, 62, 80] },
    columnStyles: {
      0: { cellWidth: 8 },  // #
      1: { cellWidth: 30 },  // Name (Increased for better visibility)
      2: { cellWidth: 12 },  // QTY
      3: { cellWidth: 15 },  // Sales QTY
      4: { cellWidth: 25 },  // Cost Price
      5: { cellWidth: 25 },  // Selling Price
      6: { cellWidth: 20 },  // Profit
      7: { cellWidth: 15 },  // Discount
      8: { cellWidth: 25 },  // Retail Value (Increased to prevent cut-off)
      9: { cellWidth: 30 },  // Total Price (Increased to make it visible)
    },
    margin: { left: 5, right: 10, top: 20 },
  });

  // Save the PDF
  doc.save("Top_Products_Stock.pdf");
};




const downloadTable = () => {
  // Map the products data with calculations
  const productsData = products.value.map((product, index) => ({
    "#": index + 1,
    "Name": product.name || "N/A",
    "QTY": product.stock_quantity || "N/A",
    "Sales QTY": product.sales_qty || 0,
    "Cost Price (LKR)": product.cost_price || "N/A",
    "Selling Price (LKR)": product.selling_price || "N/A",
    "Profit (LKR)": product.selling_price - product.cost_price || 0,
    "Discount (%)": product.discount || "N/A",
    "Retail Value": product.discount <= 100
      ? (product.selling_price * (1 - product.discount / 100)).toFixed(2)
      : (product.selling_price - product.discount).toFixed(2),
    "Total Price": product.sales_qty * product.selling_price || 0,
  }));

  // Calculate the sum of total prices
  const totalSum = productsData.reduce((sum, product) => sum + product["Total Price"], 0);

  // Add a total row
  const dataWithTotal = [
    ...productsData,
    {
      "#": "",
      "Name": "Total",
      "QTY": "",
      "Sales QTY": "",
      "Cost Price (LKR)": "",
      "Selling Price (LKR)": "",
      "Profit (LKR)": "",
      "Discount (%)": "",
      "Retail Value": "",
      "Total Price": totalSum,
    }
  ];

  // Create worksheet with the data including total
  const ws = XLSX.utils.json_to_sheet(dataWithTotal);

  // Add some styling to the total row (make the text bold)
  const lastRow = dataWithTotal.length;
  const range = XLSX.utils.decode_range(ws['!ref']);

  // Set column widths
  const colWidths = [
    { wch: 5 },  // #
    { wch: 30 }, // Name
    { wch: 10 }, // QTY
    { wch: 10 }, // Sales QTY
    { wch: 15 }, // Cost Price
    { wch: 15 }, // Selling Price
    { wch: 15 }, // Profit
    { wch: 12 }, // Discount
    { wch: 15 }, // Retail Value
    { wch: 15 }, // Total Price
  ];
  ws['!cols'] = colWidths;

  // Create a new workbook and append the worksheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Stock Data");

  // Generate Excel file and trigger download
  const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
  const blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
  });

  saveAs(blob, "Top_Products_Stock.xlsx");
};


const downloadPDFTableReturn = () => {
  const doc = new jsPDF("p", "mm", "a4"); // Portrait, A4 size

  // Title for the PDF
  doc.setFontSize(18);
  doc.text("Return Items Table", 14, 15);

  // Prepare table headers
  const tableColumn = [
    "#",
    "Product Name",
    "Transaction Date",
    "Quantity",
    "Selling Price",
    
  ];

  // Prepare table data
  const tableRows = stockTransactionsReturn.value.map((stock, index) => [
    index + 1,
    stock.product?.name||"N/A",
    stock.transaction_date || "N/A",
    stock.quantity||0,
    Number(stock.product?.selling_price)|| 0,
    
  ]);

  // Calculate total sum of "Total Price"
  const totalSum = tableRows.reduce((sum, row) => sum + row[4], 0);

  // Add a total row at the end
  tableRows.push(["", "Total", "", "", totalSum.toFixed(2)]);

  // Adjust column widths
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 25, // Adjust start position to prevent overlap with title
    theme: "striped",
    styles: { fontSize: 10 },
    headStyles: { fillColor: [44, 62, 80] },
    columnStyles: {
      0: { cellWidth: 20 },  // #
      1: { cellWidth: 30 },  // Name (Increased for better visibility)
      4: { cellWidth: 25 },  // Cost Price
      5: { cellWidth: 25},  // Selling Price
      6: { cellWidth: 20 },  // Profit
     
    },
    margin: { left: 5, right: 10, top: 20 },
  });

  // Save the PDF
  doc.save("Return Items.pdf");
};

const downloadPaintOrdersPDF = () => {
  const doc = new jsPDF("p", "mm", "a4"); // Portrait, A4 size

  // Title for the PDF
  doc.setFontSize(18);
  doc.text("Paint Orders Sales Report", 14, 15);

  // Prepare table headers
  const tableColumn = [
    "#",
    "Order ID",
    "Customer",
    "Paint Product",
    "Color Card",
    "Can Size",
    "Qty",
    "Unit Cost",
    "Selling Price",
    "Total Amount",
    "Profit",
    "Sale Date"
  ];

  // Prepare table data
  const tableRows = paintOrderDetails.value.map((order, index) => [
    index + 1,
    `PO-${order.order_id}`,
    order.customer_name || "N/A",
    order.paint_product || "N/A",
    order.color_card || "N/A",
    order.can_size || "N/A",
    order.quantity || 0,
    Number(order.unit_cost || 0).toFixed(2),
    Number(order.selling_price || 0).toFixed(2),
    Number(order.total_amount || 0).toFixed(2),
    Number(order.profit || 0).toFixed(2),
    order.sale_date || "N/A"
  ]);

  // Calculate total sums
  const totalAmount = paintOrderDetails.value.reduce((sum, order) => sum + (Number(order.total_amount) || 0), 0);
  const totalProfit = paintOrderDetails.value.reduce((sum, order) => sum + (Number(order.profit) || 0), 0);

  // Add summary rows
  tableRows.push(["", "", "", "", "", "", "", "", "Total:", totalAmount.toFixed(2), totalProfit.toFixed(2), ""]);

  // Generate the table
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 25,
    theme: "striped",
    styles: { fontSize: 8 },
    headStyles: { fillColor: [44, 62, 80] },
    columnStyles: {
      0: { cellWidth: 12 },   // #
      1: { cellWidth: 18 },   // Order ID
      2: { cellWidth: 20 },   // Customer
      3: { cellWidth: 20 },   // Paint Product
      4: { cellWidth: 18 },   // Color Card
      5: { cellWidth: 15 },   // Can Size
      6: { cellWidth: 12 },   // Qty
      7: { cellWidth: 18 },   // Unit Cost
      8: { cellWidth: 18 },   // Selling Price
      9: { cellWidth: 20 },   // Total Amount
      10: { cellWidth: 15 },  // Profit
      11: { cellWidth: 18 },  // Sale Date
    },
    margin: { left: 5, right: 5, top: 20 },
  });

  // Save the PDF
  doc.save("Paint_Orders_Sales_Report.pdf");
};




const downloadPDFTableReturnTable = () => {
  // Map the products data with calculations
  const stockTransactionData = stockTransactionsReturn.value.map((stock, index) => ({
    "#": index + 1,
    "Name":  stock.product?.name|| "N/A",
    "Transaction Date": stock.transaction_date || "N/A",
    "Quantity":stock.quantity||0,
    "Selling Price":stock.product?.selling_price|| 0,
  }));

  // Calculate the sum of total prices
  const totalSum = stockTransactionData.reduce((sum, product) => sum + product["Selling Price"], 0);

  // Add a total row
  const dataWithTotal = [
    ...stockTransactionData,
    {
      "#": "",
      "Name": "Total",
      "Transaction Date": "",
      "Quantity":"",
      "Selling Price":"",
    
    }
  ];

  // Create worksheet with the data including total
  const ws = XLSX.utils.json_to_sheet(dataWithTotal);

  // Add some styling to the total row (make the text bold)
  const lastRow = dataWithTotal.length;
  const range = XLSX.utils.decode_range(ws['!ref']);

  // Set column widths
  const colWidths = [
    { wch: 5 },  // #
    { wch: 30 }, // Name
    { wch: 20 }, // Transaction Date
    { wch: 10 }, // Quantity
    { wch: 25 }, // Cost Price
   
   
  ];
  ws['!cols'] = colWidths;

  // Create a new workbook and append the worksheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Stock Data");

  // Generate Excel file and trigger download
  const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
  const blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
  });

  saveAs(blob, "Return table.xlsx");
};

const downloadPDFTable1 = () => {
  const doc = new jsPDF("p", "mm", "a4"); // Portrait, A4 size

  // Title for the PDF
  doc.setFontSize(18);
  doc.text("Top Sales Table", 14, 15);

  // Prepare table headers
  const tableColumn = [
    "#",
    "Supplier Name",
    "Product Name",
    "Sales QTY",
    "Total Quantity",
    "Remaining QTY",
    "Selling Price(LKR)",
    "Cost Price(LKR)",
    "Total Price",
  ];

  // Prepare table data
  const tableRows = products.value.map((product, index) => [
    index + 1,
    product.supplier?.name || "N/A",
    product.name|| "N/A",
    product.sales_qty || "0",
    product.total_quantity || "N/A",
    product.total_quantity - product.sales_qty > 0
      ? product.total_quantity - product.sales_qty
      : 0,
    product.selling_price|| 0,
    product.cost_price || "N/A",
    product.sales_qty * product.selling_price || 0,
  ]);

  // Calculate total sum of "Total Price"
  const totalSum = tableRows.reduce((sum, row) => sum + row[8], 0);

  // Add a total row at the end
  tableRows.push(["", "Total", "", "", "", "", "", "", totalSum.toFixed(2)]);

  // Adjust column widths
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 25, // Adjust start position to prevent overlap with title
    theme: "striped",
    styles: { fontSize: 10 },
    headStyles: { fillColor: [44, 62, 80] },
    columnStyles: {
      0: { cellWidth: 20 },  // #
      1: { cellWidth: 25 },  // Name (Increased for better visibility)
      2: { cellWidth: 20 },  // QTY
      3: { cellWidth: 15 },  // Sales QTY
      4: { cellWidth: 25 },  // Cost Price
      5: { cellWidth: 25 },  // Selling Price
      6: { cellWidth: 25 },  // Profit
      7: { cellWidth: 25 },  // Discount
      8: { cellWidth: 25 },  // Retail Value (Increased to prevent cut-off)
    // Total Price (Increased to make it visible)
    },
    margin: { left: 5, right: 10, top: 20 },
  });

  // Save the PDF
  doc.save("Top_Sales.pdf");
};

const downloadTable1 = () => {
  // Map the products data with calculations
  const productsData = products.value.map((product, index) => ({
    "#": index + 1,
    "Supplier Name": product.name || "N/A",
    "Product Name": product.stock_quantity || "N/A",
    "Sales QTY": product.sales_qty || 0,
    "Total Quantity": product.total_quantity || "N/A",
    "Remaining QTY":   product.total_quantity - product.sales_qty > 0
      ? product.total_quantity - product.sales_qty
      : 0,
    "Selling Price(LKR)": product.selling_price|| 0,
    "Cost Price(LKR)": product.cost_price || "N/A",
    "Total Price": product.sales_qty * product.selling_price || 0,
  }));

  // Calculate the sum of total prices
  const totalSum = productsData.reduce((sum, product) => sum + product["Total Price"], 0);

  // Add a total row
  const dataWithTotal = [
    ...productsData,
    {
      "#": "",
      "Supplier Name":"",
      "Product Name":"",
      "Sales QTY":"",
      "Total Quantity": "",
      "Remaining QTY": "",
      "Selling Price(LKR)": "",
      "Cost Price(LKR)": "",
      "Total Price": totalSum,
    }
  ];

  // Create worksheet with the data including total
  const ws = XLSX.utils.json_to_sheet(dataWithTotal);

  // Add some styling to the total row (make the text bold)
  const lastRow = dataWithTotal.length;
  const range = XLSX.utils.decode_range(ws['!ref']);

  // Set column widths
  const colWidths = [
    { wch: 5 },  // #
    { wch: 30 }, // Name
    { wch: 10 }, // QTY
    { wch: 10 }, // Sales QTY
    { wch: 15 }, // Cost Price
    { wch: 15 }, // Selling Price
    { wch: 15 }, // Profit
    { wch: 12 }, // Discount
    { wch: 15 }, // Retail Value
  
  ];
  ws['!cols'] = colWidths;

  // Create a new workbook and append the worksheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Stock Data");

  // Generate Excel file and trigger download
  const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
  const blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
  });

  saveAs(blob, "Top_Sales.xlsx");
};


const  downloadPDFTableMonthly= () => {
  const doc = new jsPDF("p", "mm", "a4"); // Portrait, A4 size

  // Title for the PDF
  doc.setFontSize(18);
  doc.text("Monthly Sales Analysis", 14, 15);

  // Prepare table headers
  const tableColumn = [
    "#",
    "Month",
    "Date Range",
    "Number of Sales",
    "Total Amount(LKR)",
  ];

  // Prepare table data
  const tableRows = monthlySalesData .value.map((monthlySale, index) => [
    index + 1,
    monthlySale.month_name + ' ' + monthlySale.year || "N/A",
    monthlySale.date_range || "N/A",
    monthlySale.number_of_sales || 0,
    Number(monthlySale.total_amount )|| 0,
    
  ]);

  // Calculate total sum of "Total Price"
  const totalSum = tableRows.reduce((sum, row) => sum + row[4], 0);

  // Add a total row at the end
  tableRows.push(["", "Total", "","", totalSum.toFixed(2)]);

  // Adjust column widths
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 25, // Adjust start position to prevent overlap with title
    theme: "striped",
    styles: { fontSize: 10 },
    headStyles: { fillColor: [44, 62, 80] },
    columnStyles: {
      0: { cellWidth: 20 },  // #
      1: { cellWidth: 25 },  // Name (Increased for better visibility)
      7: { cellWidth: 25 },  // Discount
      8: { cellWidth: 25 },  // Retail Value (Increased to prevent cut-off)
    // Total Price (Increased to make it visible)
    },
    margin: { left: 5, right: 10, top: 20 },
  });

  // Save the PDF
  doc.save("Monthly Sales.pdf");
};

const downloadtableMonthly = () => {
  // Map the products data with calculations
  const monthlySalesData = monthlySale.value.map((monthlySale, index) => ({
    "#": index + 1,
    "Month": monthlySale.month_name + ' ' + monthlySale.year,
    "Date Range": monthlySale.date_range || "N/A",
    "Number of Sales": monthlySale.number_of_sales || 0,
    "Total Amount(LKR)": monthlySale.total_amount || 0,

  }));

  // Calculate the sum of total prices
  const totalSum =monthlySalesData .reduce((sum,monthlySale ) => sum + monthlySale["Total Amount"], 0);


  // Add a total row
  const dataWithTotal = [
    ...monthlySalesData,
    {
      "#": "",
      "Month": "",
      "Date Range": "",
      "Number of Sales": "",
      "Total Amount": totalSum,
    }
  ];

  // Create worksheet with the data including total
  const ws = XLSX.utils.json_to_sheet(dataWithTotal);

  // Add some styling to the total row (make the text bold)
  const lastRow = dataWithTotal.length;
  const range = XLSX.utils.decode_range(ws['!ref']);

  // Set column widths
  const colWidths = [
    { wch: 20 },  // #
    { wch: 25 }, // Name
    { wch: 25 }, // QTY
    { wch: 25 }, // Sales QTY
  ];
  ws['!cols'] = colWidths;

  // Create a new workbook and append the worksheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "MonthlySale Data");

  // Generate Excel file and trigger download
  const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
  const blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
  });

  saveAs(blob, "Monlysales.xlsx");
};



// const totalRetailValue = computed(() => {

//     return products.value.reduce((total, product) => {
//         return total + (parseFloat(product.c) || 0);
//     }, 0);
// });




// Handle filter submission
const filterData = () => {
  if (new Date(startDate.value) > new Date(endDate.value)) {
    alert("Start date cannot be greater than end date.");
    return;
  }
  router.get(route("reports.index"), {
    start_date: startDate.value,
    end_date: endDate.value,
  });
};

const downloadPDF = () => {
  const doc = new jsPDF();
  const tableColumn = ["Employee", "Total Sales Amount"];
  const tableRows = [];

  Object.entries(sortedEmployeeSales.value).forEach(([employee, entry]) => {
    tableRows.push([employee, entry["Total Sales Amount"]]);
  });

  doc.text("Top Employee Sales", 14, 10);
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 20,
  });
  doc.save("EmployeeSales.pdf");
};

const downloadPDF2 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Product Quantities ", 14, 10);

  // Step 2: Add Table for Product Quantities
  const tableData = Object.entries(productQuantities.value).map(
    ([product, quantity]) => [product, quantity]
  );

  doc.autoTable({
    head: [["Product Name", "Quantity"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart Image (Optional)
  const chartElement = document.getElementById("myPieChart"); // Assume chart has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("ProductQuantities.pdf");
};

// Descending Order Helper Function
const sortDescending = (data) => {
  return Object.entries(data)
    .sort((a, b) => b[1] - a[1])
    .reduce((acc, [key, value]) => {
      acc[key] = value;
      return acc;
    }, {});
};

// Aggregate data for Pie Chart (Product Quantities)
const productQuantities = computed(() => {
  const quantities = {};
  props.sales.forEach((sale) => {
    sale.sale_items.forEach((item) => {
      const productName = item.product && item.product.name ? item.product.name : "N/A";
      quantities[productName] = (quantities[productName] || 0) + item.quantity;
    });
  });
  return sortDescending(quantities);
});

// Pie Chart Data
const chartData = computed(() => ({
  labels: Object.keys(productQuantities.value),
  datasets: [
    {
      data: Object.values(productQuantities.value),
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: true, position: "bottom" },
  },
};

// Doughnut Chart Data for Payment Methods
const paymentMethodTotals = computed(() => {
  const totals = {};
  props.sales.forEach((item) => {
    const method = item.payment_method;
    totals[method] = (totals[method] || 0) + parseFloat(item.total_amount);
  });
  return sortDescending(totals);
});

const chartData1 = computed(() => ({
  labels: Object.keys(paymentMethodTotals.value),
  datasets: [
    {
      data: Object.values(paymentMethodTotals.value),
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions1 = {
  responsive: true,
  plugins: {
    legend: { display: true, position: "bottom" },
    tooltip: {
      callbacks: {
        label: function (context) {
          const value = context.raw || 0;
          return `LKR ${value.toLocaleString()}`;
        },
      },
    },
  },
};

const downloadPDF3 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Payment Method Totals", 14, 10);

  // Step 2: Add Table for Payment Method Totals
  const tableData = Object.entries(paymentMethodTotals.value).map(
    ([method, total]) => [method, `LKR ${total.toLocaleString()}`]
  );

  doc.autoTable({
    head: [["Payment Method", "Total Amount"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart as an Image (Optional)
  const chartElement = document.getElementById("paymentChart"); // Ensure your chart canvas has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("PaymentMethodTotals.pdf");
};

// Doughnut Chart Data for Sales by Category
const sortedCategorySales = computed(() => sortDescending(props.categorySales));

const chartData2 = computed(() => ({
  labels: Object.keys(sortedCategorySales.value),
  datasets: [
    {
      data: Object.values(sortedCategorySales.value),
      backgroundColor: [
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
    },
  ],
}));

const chartOptions2 = {
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `LKR ${context.raw.toLocaleString()}`,
      },
    },
  },
};

const sortedEmployeeSales = computed(() => {
  return Object.fromEntries(
    Object.entries(props.employeeSalesSummary).sort(
      ([, a], [, b]) => b["Total Sales Amount"] - a["Total Sales Amount"]
    )
  );
});

// Data for the Doughnut chart
const chartData4 = computed(() => ({
  labels: Object.keys(sortedEmployeeSales.value),
  datasets: [
    {
      data: Object.values(sortedEmployeeSales.value).map(
        (entry) => entry["Total Sales Amount"]
      ),
      backgroundColor: [
        "#6610f2",
        "#36A2EB",
        "#8ac926",
        "#ff595e",
        "#198754",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#ffc93c",
      ],
    },
  ],
}));

// Options for the Doughnut chart
const chartOptions4 = {
  responsive: true,
  plugins: {
    legend: {
      display: true,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `LKR ${context.raw.toLocaleString()}`,
      },
    },
  },
};

const sortedProductsStock = computed(() => {
  return props.products.reduce((acc, product) => {
    acc[product.name] = product.stock_quantity;
    return acc;
  }, {});
});



const sortedProductsStock2 = computed(() => {
  return props.products.map((product) => ({
    name: product.name,
    stock: product.stock_quantity,
    costPrice: product.cost_price,
    sellingPrice: product.selling_price,
    createdAt: product.created_at,
  }));
});




// Doughnut Chart Data
const chartData5 = computed(() => ({
  labels: Object.keys(sortedProductsStock.value), // Product names
  datasets: [
    {
      label: "Stock Quantity",
      data: Object.values(sortedProductsStock.value), // Stock quantities
      backgroundColor: [
        "#28a745",
        "#ffc107",
        "#17a2b8",
        "#e83e8c",
        "#fd7e14",
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#6610f2",
        "#6f42c1",
        "#dc3545",
        "#adb5bd",
        "#20c997",
        "#ffc93c",
        "#6a0572",
        "#8ac926",
        "#ff595e",
        "#198754",
      ],
      borderColor: "#ffffff",
      borderWidth: 1,
    },
  ],
}));

const chartOptions5 = {
  responsive: true,
  plugins: {
    legend: {
      display: false,
      position: "bottom",
    },
    tooltip: {
      callbacks: {
        label: (context) => `${context.label}: ${context.raw} units`,
      },
    },
  },
};

const downloadPDF4 = () => {
  const doc = new jsPDF();

  // Step 1: Add Title
  doc.text("Product Stock Quantities", 14, 10);

  // Step 2: Add Table for Product Stock Quantities
  const tableData = Object.entries(sortedProductsStock.value).map(
    ([product, stock]) => [product, `${stock} units`]
  );

  doc.autoTable({
    head: [["Product Name", "Stock Quantity"]],
    body: tableData,
    startY: 20,
  });

  // Step 3: Add Chart as an Image (Optional)
  const chartElement = document.getElementById("stockChart"); // Ensure your chart canvas has this ID
  if (chartElement) {
    const chartInstance = chartElement.__chartjsInstance; // Get Chart.js instance
    const chartImage = chartInstance.toBase64Image(); // Generate base64 image of chart
    doc.addImage(chartImage, "PNG", 14, doc.lastAutoTable.finalY + 10, 180, 90); // Adjust positioning
  }

  // Step 4: Save the PDF
  doc.save("ProductStockQuantities.pdf");
};





const downloadTopProductsStockPDF = () => {
  const doc = new jsPDF();

  // Title for the PDF
  doc.text("Top Products Stock Table", 14, 10);

  // Table Headings
  const tableColumn = [
    "#",
    "Name",
    "QTY",
    "Selling Price (LKR)",
    "Cost Price (LKR)",
  ];

  // Prepare data for the table rows
  const tableRows = [];
  products.value.forEach((product, index) => {
    tableRows.push([
      index + 1, // Serial number
      product.name || "N/A",
      product.stock_quantity || "N/A",
      product.selling_price || "N/A",
      product.cost_price || "N/A",

    ]);
  });

  // Add table to PDF
  doc.autoTable({
    head: [tableColumn],
    body: tableRows,
    startY: 20,
    theme: "striped",
    headStyles: { fillColor: [30, 144, 255] }, // Blue heading
    margin: { top: 10 },
  });

  // Save the PDF
  doc.save("TopProductsStockTable.pdf");
};


$(document).ready(function () {
  let table = $("#stockQtyTbl").DataTable({
    dom: "Bfrtip",
    buttons: [],
    paging: false, // Disable pagination
    buttons: [],
    columnDefs: [
      {
        targets: 0, // Adjust the target column if needed
        searchable: false,
        orderable: false, // Disable sorting for this specific column
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

$(document).ready(function () {
  let table = $("#salesTbl").DataTable({
    dom: "Bfrtip",
    buttons: [],
    paging: false, // Disable pagination
    buttons: [],
    columnDefs: [
      {
        targets: 0, // Adjust the target column if needed
        searchable: false,
        orderable: false, // Disable sorting for this specific column
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
<style scoped>
.chart-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  /* Full width of the card */
  height: calc(100% - 50px);
  /* Adjust height to leave space for the title */
  position: relative;
}

thead {
  position: sticky;
  top: 0;
  z-index: 10;
}

.max-h-64 {
  max-height: 16rem;
  /* Adjust the height to your preference */
}
</style>
