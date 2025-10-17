<template>

    <Head title="POS" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 md:px-36 px-16">
        <!-- Include the Header -->
        <Header />
        <div class="w-full md:w-5/6 w-full py-12 space-y-16">
            <div class="flex items-center justify-between space-x-4">
                <div class="flex w-full space-x-4">
                    <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" />
                    </Link>
                    <p class="pt-3 text-4xl font-bold tracking-wide text-black uppercase">
                        PoS
                    </p>
                </div>
                <div class="flex items-center justify-between w-full space-x-4">
                    <p class="text-3xl font-bold tracking-wide text-black">
                        Order ID : #{{ orderid  }}
                    </p>
                    <p class="text-3xl text-black cursor-pointer">
                        <i @click="refreshData" class="ri-restart-line"></i>
                    </p>
                </div>
            </div>
            <div class="flex md:flex-row flex-col w-full gap-4">
                <div class="flex flex-col md:w-1/2 w-full">
                    <div class="flex flex-col w-full">
                        <div class="p-16 space-y-8 bg-black shadow-lg rounded-3xl">
                            <p class="mb-4 text-5xl font-bold text-white">Customer Details</p>
                            <div class="mb-3">
                                <input v-model="customer.name" type="text" placeholder="Enter Customer Name"
                                    class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="flex gap-2 mb-3 text-black">
                                <!-- <select
                  v-model="customer.countryCode"
                  class="w-[60px] px-2 py-2 bg-white placeholder-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="+94">+94</option>
                  <option value="+1">+1</option>
                  <option value="+44">+44</option>
                </select> -->
                                <input v-model="customer.contactNumber" type="text"
                                    placeholder="Enter Customer Contact Number"
                                    class="flex-grow px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="text-black">
                                <input v-model="customer.email" type="email" placeholder="Enter Customer Email"
                                    class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <div class="text-black">
                                <select required v-model="employee_id" id="employee_id"
                                    class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled selected>Select an Employee</option>
                                    <option v-for="employee in allemployee" :key="employee.id" :value="employee.id">
                                        {{ employee.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center w-full md:pt-32 py-8 md:py-0 space-y-8">
                        <img src="/images/Fading wheel.gif" class="object-cover w-32 h-32 rounded-full" />
                        <p class="text-3xl text-black">
                            Bar Code Scanner is in Progress...
                        </p>
                    </div>
                </div>
                <div class="flex md:w-1/2 w-full p-8 border-4 border-black rounded-3xl">
                    <div class="flex flex-col items-start justify-center w-full md:px-12 px-4">
                        <div class="flex items-center justify-between w-full">
                            <h2 class="md:text-5xl text-4xl font-bold text-black">Billing Details</h2>
                            <button type="button" @click="openReturnBills"  >Return Bills</button>
                            <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
                                <p class="text-xl text-blue-600 font-bold">User Manual</p>
                                <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
                            </span>
                        </div>

                        <!-- <div class="flex items-center justify-between w-full">
                            <button >Return Bills</button>
                        </div> -->

                        <div class="flex items-end justify-between w-full my-5 border-2 border-black rounded-2xl">
                            <div class="flex items-center justify-center w-3/4">
                                <label for="search" class="text-xl font-medium text-gray-800"></label>
                                <input v-model="form.barcode" id="search" type="text" placeholder="Enter BarCode Here!"
                                    class="w-full h-16 px-4 rounded-l-2xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="flex items-end justify-end w-1/4">
                                <button @click="submitBarcode"
                                    class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-r-xl">
                                    Enter
                                </button>
                            </div>
                        </div>

                        <div class="max-w-xs relative space-y-3">
              <!-- <label for="searchProducts" class="text-gray-900">
                Type the product name to search
              </label>

              <input
                v-model="form.barcode"
                id="searchProducts"
                type="text"
                placeholder="Enter Product Name or BarCode!"
                class="w-full h-16 px-4 rounded-l-2xl focus:outline-none focus:ring-2 focus:ring-blue-500"
              /> -->

              <ul
                v-if="searchResults.length"
                class="w-full rounded bg-white border border-gray-300 px-4 py-2 space-y-1 absolute z-10"
              >
                <li class="px-1 pt-1 pb-2 font-bold border-b border-gray-200">
                  Showing {{ searchResults.length }} results
                </li>
                <li
                  v-for="product in searchResults"
                  :key="product.id"
                  @click="selectProduct(product.name)"
                  class="cursor-pointer hover:bg-gray-100 p-1"
                >
                  {{ product.name }} ({{ product.barcode || product.code }})
                </li>
              </ul>

              <p v-if="form.barcode" class="text-lg pt-2 absolute">
                You have selected:
                <span class="font-semibold">{{ form.barcode }}</span>
              </p>
            </div>

                        <div class="w-full text-center">
                            <p v-if="products.length === 0" class="text-2xl text-red-500">
                                No Products to show
                            </p>
                        </div>

                        <div class="flex items-center w-full py-4 border-b border-black" v-for="item in products"
                            :key="item.id">
                            <div class="flex w-1/6">
                                <img :src="item.image ? `/${item.image}` : '/images/placeholder.jpg'
                                    " alt="Supplier Image" class="object-cover w-16 h-16 border border-gray-500" />
                            </div>
                            <div class="flex flex-col justify-between w-5/6">
                          <!-- 2-column layout (left details, right actions/price) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

  <!-- LEFT -->
  <div class="space-y-2">
    <p class="text-xl text-black font-semibold">
      {{ item.name }}
    </p>

    <p class="text-xl text-black">
      <span class="font-semibold">Selling Price:</span>
      <span class="font-bold">{{ item.selling_price }}</span>
    </p>

    <p class="text-xl text-black">
      <span class="font-semibold">Cost Price:</span>
      <span class="font-bold">{{ item.cost_price }}</span>
    </p>

    <p
      v-if="item.unit_id"
      class="flex items-center gap-2 text-black text-xl"
    >
      <span class="text-base font-normal text-gray-500">Unit:</span>
      <span class="px-2 py-0.5 text-black font-bold">
        {{ item.unit?.name || '' }}
      </span>
    </p>
  </div>

  <!-- RIGHT -->
  <div class="flex justify-end">
    <div class="space-y-2 text-right md:border-l md:pl-6">
      <p
        v-if="
          item.discount &&
          item.discount > 0 &&
          item.apply_discount == false &&
          !appliedCoupon
        "
        @click="applyDiscount(item.id)"
        class="cursor-pointer py-1 px-1 bg-green-600 rounded-xl font-bold text-white tracking-wider inline-block"
      >
        Apply {{ item.discount }}% off
      </p>

      <p
        v-if="
          item.discount &&
          item.discount > 0 &&
          item.apply_discount == true &&
          !appliedCoupon
        "
        @click="removeDiscount(item.id)"
        class="cursor-pointer py-1 px-1 bg-red-600 rounded-xl font-bold text-white tracking-wider inline-block"
      >
        Remove {{ item.discount }}% Off
      </p>

      
    </div>
  </div>

</div>



                                <div class="flex items-center justify-between w-full">
                                    
                                    <div class="flex space-x-4">
                                        <p @click="incrementQuantity(item.id)"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                            <i class="ri-add-line"></i>
                                        </p>
                                        <!-- <p
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-8 text-black flex justify-center items-center rounded"
                    >
                      {{ item.quantity }}
                    </p> -->
                                        <!-- <input type="number" v-model="item.quantity" min="0"
                                            class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center" /> -->

 <input
                                            type="number"
                                            v-model.number="item.quantity"
                                            min="0"
                                            step="0.1"
                                            @input="updateItemTotal(item)"
                                            class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black text-center rounded"
                                            />



                                        <p @click="decrementQuantity(item.id)"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                            <i class="ri-subtract-line"></i>
                                        </p>


                                         
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <div>



 <div class="flex items-center space-x-2">
  <!-- Discount value -->

 

  <input
    type="number"
    v-model.number="item.discount"
    min="0"
    placeholder="Value"
    @input="onDiscountChange(item)"
    class="w-24 h-12 px-3 py-2 text-lg text-black text-center
           border border-gray-400 rounded-lg shadow-sm
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
  />

  <!-- Discount type -->
  <select
    v-model="item.discount_type"
    @change="onDiscountChange(item)"
    class="h-12 px-6 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
  >
    <option value="percent">%</option>
    <option value="fixed">Rs</option>
  </select>
</div>


 



 
                                            <p class="text-2xl font-bold text-black text-right">
                                               {{ item.apply_discount ? item.discounted_price : item.selling_price }} LKR
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end w-1/6">
                                <p @click="removeProduct(item.id)"
                                    class="text-3xl text-black border-2 border-black rounded-full cursor-pointer">
                                    <i class="ri-close-line"></i>
                                </p>
                            </div>
                        </div>
                        <div class="w-full pt-6 space-y-2">
                            <div class="flex items-center justify-between w-full px-8">
                                <p class="text-xl">Sub Total</p>
                                <p class="text-xl">{{ subtotal }} LKR</p>
                            </div>
                            <div class="flex items-center justify-between w-full px-8 py-2 pb-4 border-b border-black">
                                <p class="text-xl">Discount</p>
                                <p class="text-xl">( {{ totalDiscount }} LKR )</p>
                            </div>
                            <!-- <div class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Custom Discount</p>
                <span>
                  <CurrencyInput
                    v-model="custom_discount"
                  />
                  <span class="ml-2">LKR</span>
                </span>
              </div> -->

                            <div class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Custom Discount</p>
                                <span class="flex items-center">
                                    <CurrencyInput v-model="custom_discount" @blur="validateCustomDiscount"
                                        placeholder="Enter value" class=" rounded-md px-2 py-1 text-black text-md" />
                                    <select v-model="custom_discount_type"
                                        class="ml-2 px-8 border-black rounded-md text-black   py-1 text-md  ">
                                        <option value="percent">%</option>
                                        <option value="fixed">Rs</option>
                                    </select>
                                </span>
                            </div>
                            <div class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Cash</p>
                                <span>
                                    <CurrencyInput v-model="cash" :options="{ currency: 'EUR' }" />
                                    <span class="ml-2">LKR</span>
                                </span>
                            </div>
                            <div v-if="selectedPaymentMethod === 'Koko'" class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Koko Surcharge (11.5%)</p>
                                <p class="text-xl">{{ kokoSurcharge }} LKR</p>
                            </div>
                            <div class="flex items-center justify-between w-full px-8 pt-4">
                                <p class="text-3xl text-black">Total</p>
                                <p class="text-3xl text-black">{{ total }} LKR</p>
                            </div>


                            <div class="flex items-center justify-between w-full px-8 pt-4 pb-4 border-b border-black">
                                <p class="text-xl text-black">Balance</p>
                                <p>{{ balance }} LKR</p>
                            </div>
                        </div>

                        <div class="w-full my-5">
                            <div class="relative flex items-center">
                                <!-- Input Field -->
                                <label for="coupon" class="sr-only">Coupon Code</label>
                                <input id="coupon" v-model="couponForm.code" type="text" placeholder="Enter Coupon Code"
                                    class="w-full h-16 px-6 pr-40 text-lg text-gray-800 placeholder-gray-500 border-2 border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

                                <template v-if="!appliedCoupon">
                                    <button type="button" @click="submitCoupon"
                                        class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Apply Coupon
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" @click="removeCoupon"
                                        class="absolute right-2 top-2 h-12 px-6 text-lg font-semibold text-white uppercase bg-red-600 rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Remove Coupon
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="flex flex-col w-full space-y-8">
                            <div class="flex items-center justify-center w-full pt-8 space-x-8">
                                <p class="text-xl text-black">Payment Method :</p>
                                <div @click="selectedPaymentMethod = 'cash'" :class="[
                                    'cursor-pointer w-[100px]  border border-black rounded-xl flex flex-col justify-center items-center text-center',
                                    selectedPaymentMethod === 'cash'
                                        ? 'bg-yellow-500 font-bold'
                                        : 'text-black',
                                ]">
                                    <img src="/images/money-stack.png" alt="" class="w-24" />
                                </div>
                                <div @click="selectedPaymentMethod = 'card'" :class="[
                                    'cursor-pointer w-[100px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                                    selectedPaymentMethod === 'card'
                                        ? 'bg-yellow-500 font-bold'
                                        : 'text-black',
                                ]">
                                    <img src="/images/bank-card.png" alt="" class="w-24" />
                                </div>
                                <div @click="selectedPaymentMethod = 'Koko'" :class="[
                                    'cursor-pointer w-[100px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                                    selectedPaymentMethod === 'Koko'
                                        ? 'bg-yellow-500 font-bold'
                                        : 'text-black',
                                ]">
                                    <img src="/images/koko-logo.png" alt="Koko Payment" class="w-24" />
                                </div>
                            </div>

                            <div class="flex items-center justify-center w-full">
                                <button @click="() => {
                                    submitOrder();
                                }
                                    " type="button" :disabled="products.length === 0" :class="[
                                        'w-full bg-black py-4 text-2xl font-bold tracking-wider text-center text-white uppercase rounded-xl',
                                        products.length === 0
                                            ? ' cursor-not-allowed'
                                            : ' cursor-pointer',
                                    ]">
                                    <i class="pr-4 ri-add-circle-fill"></i> Confirm Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <PosSuccessModel :open="isSuccessModalOpen" @update:open="handleModalOpenUpdate" :products="products"
        :employee="employee" :cashier="loggedInUser" :customer="customer" :orderid="orderid" :cash="cash"
        :balance="balance" :subTotal="subtotal" :totalDiscount="totalDiscount" :total="total"
        :custom_discount_type="custom_discount_type"
        :custom_discount="custom_discount" :paymentMethod="selectedPaymentMethod" :kokoSurcharge="kokoSurcharge" />
    <AlertModel v-model:open="isAlertModalOpen" :message="message" />

    <SelectProductModel v-model:open="isSelectModalOpen" :allcategories="allcategories" :colors="colors" :sizes="sizes" :suppliers="suppliers"
        @selected-products="handleSelectedProducts" />

    <Footer />

    <template v-if="isReturnBillsModalOpen">
     <!-- Return Bill Form -->
     <div class="fixed inset-0 z-50 flex items-start justify-center bg-black bg-opacity-30 overflow-auto">
        <div class="bg-white mt-20 p-20 rounded-lg shadow-lg w-full max-w-7xl">
                   <!-- <form @submit.prevent="submitReturnBill"> -->
                    <div error v-if="errorMessage" class="mb-4 flex items-center justify-between text-red-600 font-medium text-center text-2xl bg-red-100 rounded-lg border border-black-300 px-4 py-2">
                    {{ errorMessage }}<button type="button" class=" text-black text-align:right" @click="errorMessage=''">X</button>
                    </div>
                    <div class="space-y-6">
                        <!-- Order Code Dropdown -->
                        <div class="flex flex-col">
                            <label for="order_id" class="text-xl font-medium text-gray-700">Order Code</label>
                            <select id="order_id" v-model="ReturnbillForm.order_id"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled>Select an order</option>
                                <option v-for="sale in props.sales" :key="sale.id" :value="sale.id">
                                    {{ sale.order_id }}
                                </option>
                            </select>
                            <p v-if="ReturnbillForm.errors.order_id" class="text-red-500 text-sm mt-1">{{ ReturnbillForm.errors.order_id }}
                            </p>
                        </div>
                        <!-- Display Selected Order Details -->
                        <div v-if="selectedSale" class="mt-6 p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-medium">Selected Order Details:</p>
                            <div class="mt-4 space-y-2">
                                <!-- <p><span class="font-bold"> ID:</span> {{ selectedSale.id }}</p> -->
                                <p><span class="font-bold">Order ID:</span> {{ selectedSale.order_id }}</p>
                                <p><span class="font-bold">Customer Name:</span> {{ selectedSale?.customer?.name ||
                                    'N/A' }}</p>

                                <p><span class="font-bold">Total Amount:</span> {{ selectedSale.total_amount }}</p>
                                <p><span class="font-bold">Discount:</span> {{ selectedSale.discount }}</p>
                                <p><span class="font-bold">Payment Method:</span> {{ selectedSale.payment_method }}</p>
                                <p><span class="font-bold">Sale Date:</span> {{ selectedSale.sale_date }}</p>
                            </div>
                        </div>
                        <!-- Display Sale Items -->
                        <div v-if="filteredSaleItems.length" class="mt-6 p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-medium">Items in this Sale:</p>
                            <div class="mt-4 max-h-96 overflow-y-auto">
                            <table class="mt-4 w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2">Product ID</th>
                                        <th class="border border-gray-300 px-8 py-4">Quantity</th>
                                        <th class="border border-gray-300 px-4 py-2">Unit Price</th>
                                        <th class="border border-gray-300 px-4 py-2">Total Price</th>
                                        <th class="border border-gray-300 px-4 py-2">Reason</th>
                                        <th class="border border-gray-300 px-4 py-2">Return Date</th>
                                        <th class="border border-gray-300 px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in filteredSaleItems" :key="item.id">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="pb-2"> {{ item.product.name }}</div>
                                            <img :src="item.product.image ? `/${item.product.image}` : '/images/placeholder.jpg'"
                                                alt="Product Image" class="w-20 h-20 object-cover rounded-lg" />
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2"><div class="flex items-center space-x-2"><p @click="incrementReturnQuantity(item.id)"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                            <i class="ri-add-line"></i>
                                        </p><span class="px-2">{{ item.quantity }}</span><p @click="decrementReturnQuantity(item.id)"
                                            class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                            <i class="ri-subtract-line"></i>
                                        </p></div></td>
                                        <td class="border border-gray-300 px-4 py-2">{{ item.unit_price }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ item.total_price }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <textarea v-model="item.reason" placeholder="Enter reason for return"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input v-model="item.return_date" type="date"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <button @click="removeItem(index)" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <!-- Submit Button -->

                        <div class="flex justify-center gap-between w-full space-x-8">
                            <button
                                @click="handleReturnBillSave"
                                class="px-8 py-3 text-lg font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none"
                            >
                                Save
                            </button>

                            <button type="button" @click="isReturnBillsModalOpen = false"
                                    class="px-8 py-3 text-lg font-bold tracking-wider text-gray-700 uppercase bg-gray-300 rounded-xl hover:bg-gray-400 focus:outline-none">
                                    Cancel
                            </button>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
     </div>
    </template>
</template>

<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import PosSuccessModel from "@/Components/custom/PosSuccessModel.vue";
import AlertModel from "@/Components/custom/AlertModel.vue";
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import CurrencyInput from "@/Components/custom/CurrencyInput.vue";
import SelectProductModel from "@/Components/custom/SelectProductModel.vue";
import ProductAutoComplete from "@/Components/custom/ProductAutoComplete.vue";
import { generateOrderId } from "@/Utils/Other.js";

// import ReturnSuccessModel from "@/Pages/ReturnItem/Index.vue";

const product = ref(null);
const returnReasons = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const isReturnBillsModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const custom_discount = ref(0);
const isSelectModalOpen = ref(false);
// const isSelectChequeModalOpen = ref(false);
const custom_discount_type = ref('percent');
const orderid = computed(() => generateOrderId());

const errorMessage = ref("");

const clamp = (num, min, max) => Math.min(Math.max(num, min), max);

const onDiscountChange = (item) => {
  // set & lock the original price
  if (!item.original_price) {
    item.original_price = Number(item.selling_price);
  }

  const original = Number(item.original_price) || 0;

  // normalize missing fields
  if (!item.discount_type) item.discount_type = 'percent';

  let d = Number(item.discount);
  if (Number.isNaN(d)) d = 0;

  if (item.discount_type === 'percent') {
    // 0–100%
    d = clamp(d, 0, 100);
    item.discount = d;
    if (d === 0) {
      item.apply_discount = false;
      item.discounted_price = original;
    } else {
      item.apply_discount = true;
      const price = original * (1 - d / 100);
      item.discounted_price = Number(price.toFixed(2));
    }
  } else {
    // fixed Rs: 0–original
    d = clamp(d, 0, original);
    item.discount = d;
    if (d === 0) {
      item.apply_discount = false;
      item.discounted_price = original;
    } else {
      item.apply_discount = true;
      const price = original - d;
      item.discounted_price = Number(price.toFixed(2));
    }
  }
};





// const balance = ref(0);

const handleModalOpenUpdate = (newValue) => {
    isSuccessModalOpen.value = newValue;
    if (!newValue) {
        refreshData();
    }
};

const props = defineProps({
    loggedInUser: Object, // Using backend product name to avoid messing with selected products
    allcategories: Array,
    allemployee: Array,
    colors: Array,
    sizes: Array,
    sales:Array,
    saleItems: { // Add this prop
        type: Array,
        default: () => []
    },
    products: { // Add products prop
        type: Array,
        default: () => []
    },
    suppliers: { type: Array, default: () => [] },
});

const sales = ref([]);
const saleItemsState = ref([]);

const incrementReturnQuantity = (id) => {
    const item = saleItemsState.value.find((item) => item.id === id);
    if (item) {
        item.quantity += 1;
        item.total_price = item.unit_price * item.quantity; // Update total price
    }
};

const decrementReturnQuantity = (id) => {
    const item = saleItemsState.value.find((item) => item.id === id);
    if (item && item.quantity > 1) {
        item.quantity -= 1;
        item.total_price = item.unit_price * item.quantity; // Update total price
    }
};
const discount = ref(0);

// const return_date = ref("");
// const sales_id = ref("");
// const reason = ref("");
// const orders = ref([]);

const customer = ref({
    name: "",
    countryCode: "",
    contactNumber: "",
    email: "",
});

const handleReturnBillSave = () => {
    const missingReason = filteredSaleItems.value.some(item => !item.reason.trim());
    if(missingReason){
     errorMessage.value = "Please provide a reason for all return items";
    return;
    }
    errorMessage.value = "";
    isReturnBillsModalOpen.value = false


};


const openReturnBills = () => {
    isReturnBillsModalOpen.value = true;
};
const ReturnbillForm = useForm({
    order_id:"",
    reason:"",
    return_date:"",

});

const employee_id = ref("");

const employee = computed(() => {
  if (!employee_id.value) return null;
  return props.allemployee.find(emp => emp.id === employee_id.value);
});

const selectedPaymentMethod = ref("cash");

const refreshData = () => {
    router.visit(route("pos.index"), {
        preserveScroll: false, // Reset scroll
        preserveState: false, // Reset component state
    });
};

const removeProduct = (id) => {
    products.value = products.value.filter((item) => item.id !== id);
};

const removeCoupon = () => {
    appliedCoupon.value = null; // Clear the applied coupon
    couponForm.code = ""; // Clear the coupon field
};

const incrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product) {
        product.quantity += 1;
    }
};

// const save= () => {
//     isReturnBillsModalOpen.value = false;
// }
const decrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product && product.quantity > 1) {
        product.quantity -= 1;
    }
};

// const orderId = computed(() => {
//   const timestamp = Date.now().toString(36).toUpperCase(); // Convert timestamp to a base-36 string
//   const randomString = Math.random().toString(36).substr(2, 5).toUpperCase(); // Generate a shorter random string
//   return `ORD-${timestamp}-${randomString}`; // Combine to create unique order ID
// });
const orderId = computed(() => {
    const characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    return Array.from({ length: 6 }, () =>
        characters.charAt(Math.floor(Math.random() * characters.length))
    ).join("");
});

const submitOrder = async () => {
    // if (window.confirm("Are you sure you want to confirm the order?")) {
    // console.log(products.value);
    if (balance.value < 0) {
        isAlertModalOpen.value = true;
        message.value = "Cash is not enough";
        return;
    }
    try {

        const returnItemsData = saleItemsState.value.map(item => ({
            sale_id: ReturnbillForm.order_id,
            customer_id: selectedSale.value?.customer_id || null,
            product_id: item.product_id,
            quantity: item.quantity,
            reason: item.reason,
            unit_price: item.unit_price,    // Make sure this is included
            return_date: item.return_date || new Date().toISOString().split('T')[0], // Default to today if not provided
        }));

        const response = await axios.post("/pos/submit", {
            customer: customer.value,
            products: products.value,
            employee_id: employee_id.value,
            paymentMethod: selectedPaymentMethod.value,
            userId: props.loggedInUser.id,
            orderid: orderid.value,
            cash: cash.value,
            custom_discount: custom_discount.value,
            custom_discount_type: custom_discount_type.value, // Add this
            appliedCoupon: appliedCoupon.value, // Add this
            return_items: returnItemsData // Add this
        });

        isSuccessModalOpen.value = true;
        console.log(response.data); // Handle success
    } catch (error) {
        if (error.response.status === 423) {
            isAlertModalOpen.value = true;
            message.value = error.response.data.message;
        }
        console.error(
            "Error submitting customer details:",
            error.response?.data || error.message
        );
        // alert("Failed to submit customer details. Please try again.");
    }
};

const filteredSaleItems = computed(() => {
    if (!props.saleItems || !Array.isArray(props.saleItems)) {
        return [];
    }

    const items = props.saleItems.filter((item) => item.sale_id === ReturnbillForm.order_id);
    saleItemsState.value = items.map((item) => ({ ...item, reason: "", return_date: "" }));
    return saleItemsState.value;
});

const returnBillTotal = computed(() => {
    if (!filteredSaleItems.value.length) return 0;
    return filteredSaleItems.value.reduce((sum, item) => {
        return sum + (parseFloat(item.total_price) || 0);
    }, 0);
});
// };
// In your script setup
// Initialize as empty array
// If not already defined
const selectedSale = ref(null); // If not already defined

// Add this method to handle return bill submission
// const submitReturnBill = () => {
//     // Your return bill submission logic here
//     console.log('Submitting return bill:', ReturnbillForm);
//     isReturnBillsModalOpen.value = false;
// };


// Add method to remove item
const removeItem = (index) => {
    saleItemsState.value.splice(index, 1);
};

// Watch for order_id changes to load sale details
// watch(() => ReturnbillForm.order_id, async (newOrderId) => {
//     if (newOrderId) {
//         try {
//             const response = await axios.get(`api/sale/items/${newOrderId}`);
//             selectedSale.value = response.data.sale;
//             filteredSaleItems.value = response.data.items || []; // Ensure items is always an array
//         } catch (error) {
//             console.error('Error fetching sale details:', error);
//             filteredSaleItems.value = []; // Reset to empty array on error
//         }
//     } else {
//         selectedSale.value = null;
//         filteredSaleItems.value = []; // Reset to empty array
//     }
// });

watch(
    () => ReturnbillForm.order_id,
    (newValue) => {
        const sale = props.sales.find((sale) => sale.id === newValue) || null;
        if (sale) {
            ReturnbillForm.discount = sale.discount || 0;
        } else {
            ReturnbillForm.discount = 0; // Default if no sale is found
        }
        console.log(sale);
    }
);


const subtotal = computed(() => {
    return products.value
        .reduce(
            (total, item) => total + parseFloat(item.selling_price) * item.quantity,
            0
        )
        .toFixed(2); // Ensures two decimal places
});

const totalDiscount = computed(() => {
    const productDiscount = products.value.reduce((total, item) => {
        // Check if item has a discount
        if (item.discount && item.discount > 0 && item.apply_discount == true) {
            const discountAmount =
                (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
                item.quantity;
            return total + discountAmount;
        }
        return total; // If no discount, return total as-is
    }, 0); // Ensures two decimal places

    const couponDiscount = appliedCoupon.value
        ? Number(appliedCoupon.value.discount)
        : 0;

    return (productDiscount + couponDiscount).toFixed(2);
});

const validateCustomDiscount = () => {
    if (!custom_discount.value || isNaN(custom_discount.value)) {
        custom_discount.value = 0; // Set default to 0 if the field is empty or invalid
    }
};

// const openReturnBills =() =>{
//     router.visit(route('return-bill.index'));
// }

const total = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customDiscount = parseFloat(custom_discount.value) || 0;
    const returnAmount = parseFloat(returnBillTotal.value) || 0;

    let customValue = 0;

    if (custom_discount_type.value === 'percent') {
        customValue = (subtotalValue * customDiscount) / 100;
    } else if (custom_discount_type.value === 'fixed') {
        customValue = customDiscount;
    }

    let baseTotal = subtotalValue - discountValue - customValue - returnAmount;
    
    // Add Koko surcharge if Koko payment method is selected
    if (selectedPaymentMethod.value === 'Koko') {
        const kokoSurcharge = baseTotal * 0.115; // 11.5% surcharge
        baseTotal += kokoSurcharge;
    }

    return baseTotal.toFixed(2);
});

const kokoSurcharge = computed(() => {
    if (selectedPaymentMethod.value === 'Koko') {
        const subtotalValue = parseFloat(subtotal.value) || 0;
        const discountValue = parseFloat(totalDiscount.value) || 0;
        const customDiscount = parseFloat(custom_discount.value) || 0;
        const returnAmount = parseFloat(returnBillTotal.value) || 0;

        let customValue = 0;

        if (custom_discount_type.value === 'percent') {
            customValue = (subtotalValue * customDiscount) / 100;
        } else if (custom_discount_type.value === 'fixed') {
            customValue = customDiscount;
        }

        const baseTotal = subtotalValue - discountValue - customValue - returnAmount;
        return (baseTotal * 0.115).toFixed(2); // 11.5% surcharge
    }
    return '0.00';
});

const balance = computed(() => {
    if (cash.value == null || cash.value === 0) {
        return 0; // If cash.value is null or 0, return 0
    }
    return (parseFloat(cash.value) - parseFloat(total.value)).toFixed(2);
});
// Check for product or handle errors
const form = useForm({
    employee_id: "",
    barcode: "", // Form field for barcode
});

const couponForm = useForm({
    code: "",
});

// Temporary barcode storage during scanning
let barcode = "";
let timeout; // Timeout to detect the end of the scan

const submitCoupon = async () => {
    try {
        const response = await axios.post(route("pos.getCoupon"), {
            code: couponForm.code, // Send the coupon field
        });

        const { coupon: fetchedCoupon, error: fetchedError } = response.data;

        if (fetchedCoupon) {
            appliedCoupon.value = fetchedCoupon;
            products.value.forEach((product) => {
                product.apply_discount = false;
            });
        } else {
            isAlertModalOpen.value = true;
            message.value = fetchedError;
            error.value = fetchedError;
        }
    } catch (err) {
        // console.error(error);
        if (err.response.status === 422) {
            isAlertModalOpen.value = true;
            message.value = err.response.data.message;
        }
    }
};

// Automatically submit the barcode to the backend
const submitBarcode = async () => {
    try {
        // Send POST request to the backend
        const response = await axios.post(route("pos.getProduct"), {
            barcode: form.barcode, // Send the barcode field
        });

        // Extract the response data
        const { product: fetchedProduct, error: fetchedError } = response.data;

        if (fetchedProduct) {
            if (fetchedProduct.stock_quantity < 1) {
                isAlertModalOpen.value = true;
                message.value = "Product is out of stock";
                return;
            }
            // Check if the product already exists in the products array
            const existingProduct = products.value.find(
                (item) => item.id === fetchedProduct.id
            );

            if (existingProduct) {
                // If it exists, increment the quantity
                existingProduct.quantity += 1;
            } else {
                // If it doesn't exist, add it to the products array with quantity 1
                products.value.push({
                    ...fetchedProduct,
                    quantity: 1,
                     discount_type: 'percent',
                    apply_discount: false, // Add the new attribute
                });
            }

            product.value = fetchedProduct; // Update product state for individual display
            error.value = null; // Clear any previous errors
            console.log(
                "Product fetched successfully and added to cart:",
                fetchedProduct
            );
        } else {
            isAlertModalOpen.value = true;
            message.value = fetchedError;
            error.value = fetchedError; // Set the error message
            console.error("Error:", fetchedError);
        }
    } catch (err) {
        if (err.response.status === 422) {
            isAlertModalOpen.value = true;
            message.value = err.response.data.message;
        }

        console.error("An error occurred:", err.response?.data || err.message);
        error.value = "An unexpected error occurred. Please try again.";
    }
};

// Handle input from the barcode scanner
const handleScannerInput = (event) => {
    clearTimeout(timeout); // Clear the timeout for each keypress
    if (event.key === "Enter") {
        // Barcode scanning completed
        form.barcode = barcode; // Set the scanned barcode into the form
        submitBarcode(); // Automatically submit the barcode
        barcode = ""; // Reset the barcode for the next scan
    } else {
        // Append the pressed key to the barcode
        barcode += event.key;
    }

    // Timeout to reset the barcode if scanning is interrupted
    timeout = setTimeout(() => {
        barcode = "";
    }, 100); // Adjust timeout based on scanner speed
};

// Attach the keypress event listener when the component is mounted
onMounted(async() => {
    document.addEventListener("keypress", handleScannerInput);

    try{
        const response = await axios.get('/pos');
        sales.value = response.data.sales || [];
    }
    catch(error){
        console.error("Error fetching sales:", error);
        sales.value = [];
    }

});

// const loadSales = async () => {
//     isLoading.value = true;
//     try {
//         const response = await axios.get("/api/sales");
//         sales.value = response.data.sales || [];
//     } catch(error) {
//         console.error("Error fetching sales:", error);
//         sales.value = [];
//     } finally {
//         isLoading.value = false;
//     }
// };

const updateItemTotal = (item) => {
  // Ensure quantity is a valid number
  if (item.quantity < 0 || isNaN(item.quantity)) {
    item.quantity = 1;
  }
};

const applyDiscount = (id) => {
    products.value.forEach((product) => {
        if (product.id === id) {
            product.apply_discount = true;
        }
    });
};

const removeDiscount = (id) => {
    products.value.forEach((product) => {
        if (product.id === id) {
            product.apply_discount = false;
        }
    });
};


const handleSelectedProducts = (selectedProducts) => {
    selectedProducts.forEach((fetchedProduct) => {
        const existingProduct = products.value.find(
            (item) => item.id === fetchedProduct.id
        );

        if (existingProduct) {
            // If the product exists, increment its quantity
            existingProduct.quantity += 1;
        } else {
            // If the product doesn't exist, add it with a default quantity
            products.value.push({
                ...fetchedProduct,
                quantity: 1,
                 discount_type: 'percent',
                apply_discount: false, // Default additional attribute
            });
        }
    });
};

// Watch for changes to isReturnBill
// watch(isReturnBill, (newValue) => {
//   if (newValue && selectedOrder.value) {
//     // If turning on return bill mode, make all products need a reason
//     products.value.forEach(product => {
//       if (!product.returnReason) {
//         product.returnReason = "";
//       }
//     });
//   }
// });


const searchTerm = ref('');

// Computed property for filtered product results in ascending order
const searchResults = computed(() => {
  if (searchTerm.value === "" || searchTerm.value.length < 2) {
    return [];
  }

  const searchLower = searchTerm.value.toLowerCase();
  
  return props.products
    .filter((product) => {
      const name = product.name.toLowerCase();
      const barcode = product.barcode?.toLowerCase() || '';
      const code = product.code?.toLowerCase() || '';
      
      // Match if name starts with search term, or exact barcode/code match
      return name.startsWith(searchLower) || 
             barcode === searchLower || 
             code === searchLower ||
             barcode.startsWith(searchLower) ||
             code.startsWith(searchLower);
    })
    .sort((a, b) => {
      // Sort by priority: exact start match first, then alphabetical
      const aStarts = a.name.toLowerCase().startsWith(searchLower);
      const bStarts = b.name.toLowerCase().startsWith(searchLower);
      
      if (aStarts && !bStarts) return -1;
      if (!aStarts && bStarts) return 1;
      
      return a.name.localeCompare(b.name);
    })
    .slice(0, 10); // Limit to 10 results
});

// Watch for changes in the form barcode field and update the search term
watch(
  () => form.barcode,
  (newValue) => {
    searchTerm.value = newValue;
  }
);

// Method to select a product (or barcode)
const selectProduct = (productName) => {
  form.barcode = productName; // Set the selected product name to the barcode field
  searchTerm.value = ""; // Clear the search term after selection
};
</script>
