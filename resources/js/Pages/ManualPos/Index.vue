<template>
  <Head title="Manual POS" />
  <Banner />
  <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-4 bg-gray-100 md:px-36 px-16">
    <Header />
    <div class="w-full md:w-5/6 py-12 space-y-16">
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
            Order ID : #{{ orderId }}
          </p>
          <p class="text-3xl text-black cursor-pointer">
            <i @click="refreshData" class="ri-restart-line"></i>
          </p>
        </div>
      </div>
    </div>

     <div class="flex md:flex-row flex-col w-full gap-4 md:px-32">
        <div class="flex flex-col md:w-1/2 w-full">
          <div class="flex flex-col w-full">
            <div class="p-16 space-y-8 bg-black shadow-lg rounded-3xl">
              <p class="mb-4 text-5xl font-bold text-white">Customer Details</p>
              <div class="mb-3">
                <input
                  v-model="customer.name"
                  type="text"
                  placeholder="Enter Customer Name"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex gap-2 mb-3 text-black">
                <input
                  v-model="customer.contactNumber"
                  type="text"
                  placeholder="Enter Customer Contact Number"
                  class="flex-grow px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="text-black">
                <input
                  v-model="customer.email"
                  type="email"
                  placeholder="Enter Customer Email"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div class="text-black">
                <select
                  required
                  v-model="employee_id"
                  id="employee_id"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="" disabled selected>Select an Employee</option>
                  <option
                    v-for="employee in allemployee"
                    :key="employee.id"
                    :value="employee.id"
                  >
                    {{ employee.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          
        </div>
        <div class="flex md:w-1/2 w-full p-8 border-4 border-black rounded-3xl">
          <div class="flex flex-col items-start justify-center w-full md:px-12">
            <div class="flex items-center justify-between w-full">
              <h2 class="text-5xl font-bold text-black">Billing Details</h2>
            </div>

            <div class="w-full pt-6 space-y-2">
             <div class="w-full flex flex-col  ">
              <div class="flex flex-col w-full pt-4 pb-4 ">
                <p class="text-xl text-black">Product Name</p>
              <span>
                <input
                  v-model="product_name"
                  type="text"
                  placeholder="Enter Product Name"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </span>
              </div>
            <div class="w-full flex space-x-4 border-b border-black">
              <div class="flex flex-col w-1/2 pt-4 pb-4 ">
                <p class="text-xl text-black">quantity</p>
                <span>
                  <input
                  v-model="product_quantity"
                  type="Number"
                  placeholder="Enter quantity"
                  min="1"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                </span>
              </div>
              <div class="flex flex-col w-1/2  pt-4 pb-4">
                <p class="text-xl text-black">Unit Price</p>
                <span>
                  <input
                  v-model="product_unit_price"
                  type="Number"
                  placeholder="Enter unit price"
                  class="w-full px-4 py-4 text-black placeholder-black bg-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                
                </span>
              </div>
            </div>
            
             </div>
              
              <div class="flex items-center justify-center w-full px-16 py-4">
                <button
                    @click="addProduct"
                    class="w-full px-6 py-3 text-xl font-bold text-white bg-black rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black"
                >
                    <i class="pr-2 ri-add-circle-line"></i>
                    Add Product
                </button>
                </div>
              
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4" v-for="(product, index) in products" :key="index"  >
              
              <div class="flex flex-col justify-start w-4/6">
                <p class="text-3xl text-black">
                  {{ product.name }}
                </p>
                <div class="flex items-end justify-between w-full">
                  <div class="flex space-x-4">
                    <p
                      @click="incrementQuantity(product)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>
                    <p
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-8 text-black flex justify-center items-center rounded"
                    >
                     {{ product.quantity }}
                    </p>
                    <p
                      @click="decrementQuantity(product)"
                      class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  
                </div>
              </div>
              <div class="flex justify-end w-1/6">
                <p
                  @click="removeProduct(index)"
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>

              <div class="flex items-center justify-between w-full px-16">
                <p class="text-xl">Sub Total</p>
                <p class="text-xl">{{ subtotal }} LKR</p>
              </div>
            
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Custom Discount</p>
                <span>
                  <CurrencyInput
                    v-model="custom_discount"
                  />
                  <span class="ml-2">LKR</span>
                </span>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black">
                <p class="text-xl text-black">Cash</p>
                <span>
                  <CurrencyInput
                    v-model="cash"
                    :options="{ currency: 'EUR' }"
                  />
                  <span class="ml-2">LKR</span>
                </span>
              </div>
              <div class="flex items-center justify-between w-full px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">{{ total }} LKR</p>
              </div>
              
              
              <div
                class="flex items-center justify-between w-full px-16 pt-4 pb-4 border-b border-black"
              >
                <p class="text-xl text-black">Balance</p>
                <p>{{ balance }} LKR</p>
              </div>
            </div>

           <div class="flex flex-col w-full space-y-8">
              <div
                class="flex items-center justify-center w-full pt-8 space-x-8"
              >
                <p class="text-xl text-black">Payment Method :</p>
                <div
                  @click="selectedPaymentMethod = 'cash'"
                  :class="[
                    'cursor-pointer w-[100px]  border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'cash'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <img src="/images/money-stack.png" alt="" class="w-24" />
                </div>
                <div
                  @click="selectedPaymentMethod = 'card'"
                  :class="[
                    'cursor-pointer w-[100px] border border-black rounded-xl flex flex-col justify-center items-center text-center',
                    selectedPaymentMethod === 'card'
                      ? 'bg-yellow-500 font-bold'
                      : 'text-black',
                  ]"
                >
                  <img src="/images/bank-card.png" alt="" class="w-24" />
                </div>
              </div>

              <div class="flex items-center justify-center w-full">
                <button
                type="button"
                @click="openPrintSlip"
                :class="[
                    'w-full bg-black py-4 text-2xl font-bold tracking-wider text-center text-white uppercase rounded-xl',
                    products.length === 0
                    ? ' cursor-not-allowed'
                    : ' cursor-pointer',
                ]"
                >
                <i class="pr-4 ri-add-circle-fill"></i> Confirm Order
                </button>

              </div>
            </div>

            
          </div>
        </div>
      </div>

    
  </div>

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

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const cash = ref(0);
const product_name = ref('');
const custom_discount = ref(0);
const product_quantity = ref(1);
const product_unit_price = ref(0);


const handleModalOpenUpdate = (newValue) => {
  isSuccessModalOpen.value = newValue;
  if (!newValue) {
    refreshData();
  }
};

const addProduct = () => {
  if (product_name.value && product_quantity.value > 0 && product_unit_price.value > 0) {
    products.value.push({
      name: product_name.value,
      quantity: parseFloat(product_quantity.value),
      unitPrice: parseFloat(product_unit_price.value),
      total: parseFloat(product_quantity.value) * parseFloat(product_unit_price.value)
    });

    // Reset input fields after adding the product
    product_name.value = '';
    product_quantity.value = 1;
    product_unit_price.value = 0;
  } else {
    alert("Please enter valid product details.");
  }
};
const incrementQuantity = (product) => {
  if (product) {
    product.quantity += 1;
  }
};

const decrementQuantity = (product) => {
  if (product && product.quantity > 1) {
    product.quantity -= 1;
  }
};



const props = defineProps({
  loggedInUser: Object, // Using backend product name to avoid messing with selected products
  allcategories: Array,
  allemployee: Array,
  colors: Array,
  sizes: Array,
  companyInfo: Object,
});


const customer = ref({
  name: "",
  countryCode: "",
  contactNumber: "",
  email: "",
});

const employee_id = ref("");

const selectedPaymentMethod = ref("cash");

const refreshData = () => {
  router.visit(route("pos.index"), {
    preserveScroll: false, // Reset scroll
    preserveState: false, // Reset component state
  });
};




const orderId = computed(() => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  return Array.from({ length: 6 }, () =>
    characters.charAt(Math.floor(Math.random() * characters.length))
  ).join("");
});

const submitOrder = async () => {
  // if (window.confirm("Are you sure you want to confirm the order?")) {
  console.log(products.value);
  if (balance.value < 0) {
    isAlertModalOpen.value = true;
    message.value = "Cash is not enough";
    return;
  }
  try {
    const response = await axios.post("/pos/submit", {
      customer: customer.value,
      products: products.value,
      employee_id: employee_id.value,
      paymentMethod: selectedPaymentMethod.value,
      userId: props.loggedInUser.id,
      orderId: orderId.value,
      cash: cash.value,
      custom_discount: custom_discount.value,
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
    
  }
};


const subtotal = computed(() => {
  return products.value.reduce((sum, product) => {
    return sum + (product.quantity * product.unitPrice);
  }, 0).toFixed(2);
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

 
  return (productDiscount).toFixed(2);
});

const total = computed(() => {
  const subtotalValue = parseFloat(subtotal.value);
  const discountValue = parseFloat(custom_discount.value) || 0;
  return (subtotalValue - discountValue).toFixed(2);
});

const balance = computed(() => {
  const cashValue = parseFloat(cash.value) || 0;
  const totalValue = parseFloat(total.value);
  return (cashValue - totalValue).toFixed(2);
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

const removeProduct = (index) => {
  products.value.splice(index, 1);
};

watch([cash, custom_discount], ([newCash, newDiscount]) => {
  cash.value = parseFloat(newCash) || 0;
  custom_discount.value = parseFloat(newDiscount) || 0;
});

// Attach the keypress event listener when the component is mounted
onMounted(() => {
  document.addEventListener("keypress", handleScannerInput);
  console.log(props.products);
});

const openPrintSlip = () => {
  const printContent = `
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
        </style>
      </head>
      <body>
        <div class="receipt-container">

        <div class="header">
          <h1>${props.companyInfo?.name || 'Company Name'}</h1>
          <p>${props.companyInfo?.address || ''}</p>
          ${props.companyInfo?.phone || props.companyInfo?.phone2 || props.companyInfo?.email 
            ? `
              <p>
                ${props.companyInfo?.phone ? props.companyInfo.phone : ''}
                ${props.companyInfo?.phone && props.companyInfo?.phone2 ? ' | ' : ''}
                ${props.companyInfo?.phone2 ? props.companyInfo.phone2 : ''}
                ${(props.companyInfo?.phone || props.companyInfo?.phone2) && props.companyInfo?.email ? ' | ' : ''}
                ${props.companyInfo?.email ? props.companyInfo.email : ''}
              </p>
              `
            : ''
          }
        </div>

          <div class="section">
              <div class="info-row">
                  <div>
                      <p>Date:</p>
                      <small>${new Date().toLocaleString()}</small>
                  </div>
                  <div>
                      <p>Order No:</p>
                      <small>${orderId.value}</small>
                  </div>
              </div>
              <div class="info-row">
                  <div>
                      <p>Customer:</p>
                      <small>${customer.value.name}</small>
                  </div>
                  <div>
                      <p>Cashier:</p>
                      <small>${props.loggedInUser?.name || ''}</small>
                  </div>
              </div>
          </div>

          <div class="section">
              <table>
                  <thead>
                      <tr>
                          <th>Description</th>
                          <th style="text-align: center;">Qty</th>
                          <th style="text-align: right;">Price</th>
                      </tr>
                  </thead>
                  <tbody>
                      ${products.value
                          .map(
                              (product) => `
                              <tr>
                                  <td>${product.name}</td>
                                  <td style="text-align: center;">${product.quantity}</td>
                                  <td>${product.unitPrice}</td>
                              </tr>`
                          )
                          .join("")}
                  </tbody>
              </table>
          </div>
         
          <div class="totals">
              <div>
                  <span>Sub Total</span>
                  <span>${subtotal.value} LKR</span>
              </div>
              <div>
                  <span>Custom Discount</span>
                  <span>${custom_discount.value} LKR</span>
              </div>
              <div>
                  <span>Total</span>
                  <span>${total.value} LKR</span>
              </div>
              <div>
                  <span>Cash</span>
                  <span>${cash.value} LKR</span>
              </div>
              <div style="font-weight: bold;">
                  <span>Balance</span>
                  <span>${balance.value} LKR</span>
              </div>
          </div>
          
          <div class="footer">
              <p>THANK YOU COME AGAIN</p>
              <p class="italic">Let the quality define its own standards</p>
              <p style="font-weight: bold;">Powered by JAAN Network (Pvt) Ltd.</p>
          </div>
        </div>
      </body>
    </html>
  `;

  const printWindow = window.open("", "_blank");
  if (!printWindow) {
    alert("Failed to open print window. Please check your browser settings.");
    return;
  }

  // Write the content to the new window
  printWindow.document.open();
  printWindow.document.write(printContent); // Changed from openPrintSlip to printContent
  printWindow.document.close();

  // Wait for the content to load before triggering print
  printWindow.onload = () => {
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  };
};


</script>