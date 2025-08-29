<template>
    <Head title="QUOTATION" />
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
                        Quotation
                    </p>
                </div>
                <div class="flex items-center justify-between w-full space-x-4">
                    <p class="text-3xl font-bold tracking-wide text-black">
                        Quotation ID : #{{ orderId }}
                    </p>
                    <p class="text-3xl text-black cursor-pointer">
                        <i @click="refreshData" class="ri-restart-line"></i>
                    </p>
                </div>
        </div>

        <div class="flex md:flex-row flex-col w-full gap-4">
          <div class="flex md:w-3/6 w-full p-8 border-4 border-black rounded-3xl">
            <div class="flex flex-col items-start justify-center w-full md:px-12">
              <div class="flex items-center justify-between w-full">
                <h2 class="text-5xl font-bold text-black">Quotation </h2>
                 <span class="flex cursor-pointer" @click="isSelectModalOpen = true">
                    <p class="text-xl text-blue-600 font-bold">Product Manual</p>
                    <img src="/images/selectpsoduct.svg" class="w-6 h-6 ml-2" />
                </span>
              </div>


              <div class="space-y-6 mt-6 w-full">
                 <div class="flex items-center w-full py-4 border-b border-black" v-for="item in products"
                    :key="item.id">
                    <div class="flex w-1/6">
                        <img :src="item.image ? `/${item.image}` : '/images/placeholder.jpg'
                            " alt="Supplier Image" class="object-cover w-16 h-16 border border-gray-500" />
                    </div>
                    <div class="flex flex-col justify-between w-5/6">
                        <p class="text-xl text-black">
                            {{ item.name }}
                        </p>
                        <div class="flex items-center justify-between w-full">
                            <div class="flex space-x-4">
                                <p @click="incrementQuantity(item.id)"
                                    class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                    <i class="ri-add-line"></i>
                                </p>

                                <input type="number" v-model="item.quantity" min="0"
                                    class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center" />
                                <p @click="decrementQuantity(item.id)"
                                    class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer">
                                    <i class="ri-subtract-line"></i>
                                </p>
                            </div>
                            <div class="flex items-center justify-center">
                                <div>
                                    <p @click="applyDiscount(item.id)" v-if="
                                        item.discount &&
                                        item.discount > 0 &&
                                        item.apply_discount == false &&
                                        !appliedCoupon
                                    "
                                        class="cursor-pointer py-1 text-center px-4 bg-green-600 rounded-xl font-bold text-white tracking-wider">
                                        Apply {{ item.discount }}% off
                                    </p>

                                    <p v-if="
                                        item.discount &&
                                        item.discount > 0 &&
                                        item.apply_discount == true &&
                                        !appliedCoupon
                                    " @click="removeDiscount(item.id)"
                                        class="cursor-pointer py-1 text-center px-4 bg-red-600 rounded-xl font-bold text-white tracking-wider">
                                        Remove {{ item.discount }}% Off
                                    </p>

                                    <input
  v-model="item.selling_price"
  type="number"
  min="0"
  class="w-40 m-2 text-right px-2 py-1 border-2 border-black rounded text-black font-bold text-xl"
  @input="item.selling_price = parseFloat(item.selling_price) || 0"
/>
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

                <div>
                    <label for="description" class="block mb-2 text-lg font-medium">Description:</label>
                    <input
                    v-model="form.description"
                    id="description"
                    name="description"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div>
                    <label for="description_price" class="block mb-2 text-lg font-medium">Price:</label>
                    <input
                    v-model="form.description_price"
                    id="description_price"
                    name="description_price"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div>
                    <label for="add_discount" class="block mb-2 text-lg font-medium">Discount:</label>
                    <input
                    v-model="form.add_discount"
                    id="add_discount"
                    name="add_discount"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label for="valid_date" class="block mb-2 text-lg font-medium">Valid Date:</label>
                    <input
                    v-model="form.valid_date"
                    id="valid_date"
                    name="valid_date"
                    type="date"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>


                <!-- Client Name -->
<div>
  <label for="client_name" class="block mb-2 text-lg font-medium">Client Name:</label>
  <input
    v-model="form.client_name"
    id="client_name"
    name="client_name"
    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
    placeholder="Enter client name"
  />
</div>

<!-- Client Address -->
<div>
  <label for="client_address" class="block mb-2 text-lg font-medium">Client Address:</label>
  <textarea
    v-model="form.client_address"
    id="client_address"
    name="client_address"
    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
    placeholder="Enter client address"
    rows="2"
  ></textarea>
</div>


                <button
                  class="pr-4"
                   @click="addQuotation"
                  style="background-color: lightgreen; border: 2px solid #4CAF50; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 15px; transition: opacity 0.3s;"
                >
                  Add Quotation
                </button>
              </div>
            </div>
          </div>

          <!-- Quotation Report -->
          <div id="quotation-content" class="w-[50%] bg-white border border-gray-300 rounded-lg shadow-md p-6">

            <div>
            <div class="text-center mb-6">
                <!-- <img
                    :src="
                    companyInfo && companyInfo.logo
                        ? companyInfo.logo
                        : '/images/jaan_logo.jpg'
                    "
                    class="w-[100px] h-[50px] mx-auto"
                    alt="Logo"
                />

                <img src="/images/billlogo.png" style="width: 120px; height: 70px;" /> -->
              <h1 class="text-4xl font-extrabold text-gray-800"> {{ companyInfo ? companyInfo.name : 'Company Name' }}</h1>
              <h2 class="text-2xl font-semibold text-gray-600 mt-2">Sales Quotation</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
              <div>
                <p class="text-sm font-medium text-gray-500">Quotation ID:</p>
                <p class="text-base font-semibold text-gray-800">{{ orderId }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Quote Date:</p>
                <p class="text-base font-semibold text-gray-800">{{new Date().toISOString().split("T")[0]}}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Valid Until:</p>
                <p class="text-base font-semibold text-gray-800">{{ validUntilDate }}</p>
              </div>
            </div>

            <div class="mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Products</h3>
              <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                  <thead class="bg-gray-100 text-gray-700">
                    <tr>
                      <th class="px-4 py-2 text-left text-sm font-medium">Product</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Quantity</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Unit Price</th>
                      <th class="px-4 py-2 text-right text-sm font-medium">Sub Total</th>
                    </tr>
                  </thead>
                        <tbody>
                            <tr v-for="(item) in products" :key="item.id">
                                <td class="px-4 py-2 text-gray-800 text-sm">{{ item.name }}</td>
                                <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.quantity }}</td>
                                <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.selling_price }}</td>                                <td class="px-4 py-2 text-gray-800 text-right text-sm">
                                {{ (item.selling_price * item.quantity).toFixed(2) }}
                                </td>
                            </tr>
                            </tbody>
                </table>
              </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-3">Summary</h3>
              <div class="grid grid-cols-2 gap-4">

                <p class="text-sm text-gray-500">Product Total:</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{total}}</p>
                <p v-if="parseFloat(totalDiscount) > 0" class="text-sm text-gray-500">Discount:</p>
                <p v-if="parseFloat(totalDiscount) > 0" class="text-right text-sm font-semibold text-gray-800">
                {{ totalDiscount }}
                </p>
                <p class="text-sm text-gray-500">{{ description || " "}}</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{ description_price }}</p>
                <p class="text-sm text-gray-500">Grand Quotation Total:</p>
                <p class="text-right text-sm font-semibold text-gray-800">{{ totalquotation }}</p>


              </div>
            </div>

            <div class="flex justify-between items-center">
              <span class="text-gray-500">Thank you for your business!</span>
              <button
                @click="() => downloadPdf()"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none"
              >
                Download PDF
              </button>
            </div>
          </div>

          </div>
        </div>
      </div>
    </div>
    <SelectProductModel
    v-model:open="isSelectModalOpen"
    :allcategories="allcategories"
    :colors="colors"
    :sizes="sizes"
    @selected-products="handleSelectedProducts"
    />
    <Footer />
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
import jsPDF from "jspdf";
import html2canvas from "html2canvas";

const product = ref(null);
const error = ref(null);
const products = ref([]);
const isSuccessModalOpen = ref(false);
const isAlertModalOpen = ref(false);
const message = ref("");
const appliedCoupon = ref(null);
const cash = ref(0);
const custom_discount = ref(0);
const isSelectModalOpen = ref(false);
const custom_discount_type = ref('percent');
const validUntilDate = ref("");
const description = ref("");
const description_price = ref("");
const add_discount = ref("");




const handleModalOpenUpdate = (newValue) => {
    isSuccessModalOpen.value = newValue;
    if (!newValue) {
        refreshData();
    }
};

const props = defineProps({
    loggedInUser: Object,
    allcategories: Array,
    allemployee: Array,
    colors: Array,
    sizes: Array,
    companyInfo : Array,
});

const discount = ref(0);

const customer = ref({
    name: "",
    countryCode: "",
    contactNumber: "",
    email: "",
});

const employee_id = ref("");

const selectedPaymentMethod = ref("cash");

const refreshData = () => {
    router.visit(route("quotation.index"), {
        preserveScroll: false,
        preserveState: false,
    });
};

const removeProduct = (id) => {
    products.value = products.value.filter((item) => item.id !== id);
};



const incrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product) {
        product.quantity += 1;
    }
};

const decrementQuantity = (id) => {
    const product = products.value.find((item) => item.id === id);
    if (product && product.quantity > 1) {
        product.quantity -= 1;
    }
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
        // alert("Failed to submit customer details. Please try again.");
    }
};
// };

const subtotal = computed(() => {
    return products.value
        .reduce(
            (total, item) => total + parseFloat(item.selling_price) * item.quantity,
            0
        )
        .toFixed(2);
});

const totalDiscount = computed(() => {
    const productDiscount = products.value.reduce((total, item) => {
        if (item.discount && item.discount > 0 && item.apply_discount == true) {
            const discountAmount =
                (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) *
                item.quantity;
            return total + discountAmount;
        }
        return total; // If no discount, return total as-is
    }, 0);

    const couponDiscount = appliedCoupon.value
        ? Number(appliedCoupon.value.discount)
        : 0;

    const additionalDiscount = parseFloat(add_discount.value) || 0;

    return (productDiscount + couponDiscount + additionalDiscount).toFixed(2);
});




const total = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customDiscount = parseFloat(custom_discount.value) || 0;

    let customValue = 0;

    if (custom_discount_type.value === 'percent') {
        customValue = (subtotalValue * customDiscount) / 100;
    } else if (custom_discount_type.value === 'fixed') {
        customValue = customDiscount;
    }

    return (subtotalValue ).toFixed(2);
});

const totalquotation = computed(() => {
    const subtotalValue = parseFloat(subtotal.value) || 0;
    const discountValue = parseFloat(totalDiscount.value) || 0;
    const customAdditional = parseFloat(description_price.value) || 0;

    return (subtotalValue + customAdditional - discountValue ).toFixed(2);
});



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
    }, 100);
};


onMounted(() => {
    document.addEventListener("keypress", handleScannerInput);
    console.log(props.products);
});

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
        apply_discount: false, // Default additional attribute
      });
    }
  });
};

const addQuotation = () => {
  validUntilDate.value = form.valid_date;
  description.value = form.description;
  description_price.value = form.description_price;
  add_discount.value = form.add_discount;

  const quotationTotal = computed(() => {
  const totalValue = parseFloat(total.value) || 0;
  const additionalCharge = parseFloat(description_price.value) || 0;

  return (totalValue + additionalCharge ).toFixed(2);
});
};







const downloadPdf = async () => {
  const pdf = new jsPDF();

  const headerSize =  40;
  const titleSize = 10;
  const normalSize = 10;
  const smallSize = 9;

  const pageWidth = pdf.internal.pageSize.getWidth();
  const pageHeight = pdf.internal.pageSize.getHeight();

  // Header background
  pdf.setFillColor(25, 47, 66);
  pdf.rect(0, 0, pageWidth, 50, 'F');

  // Quotation Title (left side)
  pdf.setTextColor(255, 255, 255);
  pdf.setFontSize(headerSize);
  pdf.setFont('helvetica', 'bold');
  pdf.text('Quotation', 15, 30); // Left-aligned

  // Add Logo (positioned top-right)
  try {
    const logoImg = new Image();
    logoImg.src = '/images/billlogo-white.png';
    logoImg.crossOrigin = 'Anonymous';

    await new Promise((resolve, reject) => {
      logoImg.onload = resolve;
      logoImg.onerror = reject;
      setTimeout(reject, 3000);
    });

    const canvas = document.createElement('canvas');
    canvas.width = logoImg.width;
    canvas.height = logoImg.height;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(logoImg, 0, 0);

    const base64Img = canvas.toDataURL('image/png');
    const imgWidth = 40;
    const imgHeight = 20;
    const xPos = 110;
    const yPos = 2;
    pdf.addImage(base64Img, 'PNG', xPos, yPos, imgWidth, imgHeight);
  } catch (error) {
    console.error('Error adding logo to PDF:', error);
    pdf.setFontSize(12);
    pdf.text('Company Logo', pageWidth - 60, 20);
  }

  // --- CMSPORTS-style Right-Side Contact Info ---
  const contactDetails = [
    {
      text:  '075 549 1437 | 075 738 7608',
      icon: '/images/phone-icon.png',
    },
    {
      text:  'cmsports.info',
      icon: '/images/web-icon.png',
    },
    {
      text:  '441/B, Colombo Road, Piliyandala',
      icon: '/images/location-icon.png',
    },
  ];

  let contactY = 23;
  const contactX = pageWidth - 95;
  const iconSize = 4;
  const iconGap = 3;
  const lineSpacing = 9;

  for (const item of contactDetails) {
    try {
      const iconImg = new Image();
      iconImg.src = item.icon;
      iconImg.crossOrigin = 'Anonymous';

      await new Promise((resolve, reject) => {
        iconImg.onload = resolve;
        iconImg.onerror = reject;
        setTimeout(reject, 3000);
      });

      const canvas = document.createElement('canvas');
      canvas.width = iconImg.width;
      canvas.height = iconImg.height;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(iconImg, 0, 0);

      const base64Icon = canvas.toDataURL('image/png');
      pdf.addImage(base64Icon, 'PNG', contactX, contactY, iconSize, iconSize);
    } catch (error) {
      console.error(`Failed to load icon ${item.icon}:`, error);
    }

    pdf.setFontSize(10);
    pdf.setFont('helvetica', 'normal');
    pdf.setTextColor(255, 255, 255);
    pdf.text(item.text, contactX + iconSize + iconGap, contactY + 4);
    contactY += lineSpacing;
  }

  // Reset to black text
  pdf.setTextColor(0, 0, 0);

  let startY = 55;

  // Quotation Number + Date
  pdf.setFillColor(240, 240, 240);
  pdf.setDrawColor(0, 0, 0);

  pdf.rect(10, startY, pageWidth / 2 - 15, 15);
  pdf.setFontSize(titleSize);
  pdf.setFont('helvetica', 'bold');
  pdf.text('Quotation #: ' + (orderId.value || '0012'), 15, startY + 10);

  pdf.rect(pageWidth / 2, startY, pageWidth / 2 - 10, 15);
  const formattedDate = new Date().toLocaleDateString('en-GB', {
    day: 'numeric', month: 'long', year: 'numeric'
  });
  pdf.text('Quotation Date: ' + formattedDate, pageWidth / 2 + 5, startY + 10);

  // Billed To + Address
  startY += 15;

  pdf.rect(10, startY, pageWidth / 2 - 15, 25);
  pdf.setFont('helvetica', 'bold');
  pdf.text('Billed To:', 15, startY + 5);
  pdf.setFont('helvetica', 'normal');
  const clientName = form.client_name || 'Client Name Not Provided';
  pdf.text(clientName, 15, startY + 12);

  pdf.rect(pageWidth / 2, startY, pageWidth / 2 - 10, 25);
  pdf.setFont('helvetica', 'bold');
  pdf.text('Address:', pageWidth / 2 + 5, startY + 5);
  pdf.setFont('helvetica', 'normal');
  const clientAddress = form.client_address || 'Client Address Not Provided';
  const addressLines = pdf.splitTextToSize(clientAddress, pageWidth / 2 - 20);
  pdf.text(addressLines, pageWidth / 2 + 5, startY + 12);

  startY += 25;

  // Table Header
  pdf.setFillColor(240, 240, 240);
  pdf.rect(10, startY, pageWidth - 20, 10, 'FD');

  pdf.setFont('helvetica', 'bold');
  pdf.text('Product', 40, startY + 7, { align: 'center' });
  pdf.text('Quantity', 110, startY + 7, { align: 'center' });
  pdf.text('Unit Price', 145, startY + 7, { align: 'center' });
  pdf.text('Total', 180, startY + 7, { align: 'center' });

  pdf.line(70, startY, 70, startY + 10);
  pdf.line(130, startY, 130, startY + 10);
  pdf.line(160, startY, 160, startY + 10);

  startY += 10;
  let currentY = startY;
  const rowHeight = 10;
  pdf.setFont('helvetica', 'normal');

  products.value.forEach((item) => {
    if (currentY > 250) {
      pdf.addPage();
      currentY = 20;
    }

    pdf.rect(10, currentY, pageWidth - 20, rowHeight, 'D');
    pdf.line(70, currentY, 70, currentY + rowHeight);
    pdf.line(130, currentY, 130, currentY + rowHeight);
    pdf.line(160, currentY, 160, currentY + rowHeight);

    const itemName = item.name || 'Unnamed Product';
    const quantity = item.quantity?.toString() || '0';
    const price = item.selling_price?.toString() || '0';
    const subtotal = (item.selling_price * item.quantity).toString();

    pdf.setTextColor(0, 0, 0);
    pdf.text(itemName, 15, currentY + 7);
    pdf.text(quantity, 110, currentY + 7, { align: 'center' });
    pdf.text(price, 145, currentY + 7, { align: 'center' });
    pdf.text(subtotal, 180, currentY + 7, { align: 'center' });

    currentY += rowHeight;
  });

  if (description.value) {
    if (currentY > 250) {
      pdf.addPage();
      currentY = 20;
    }

    pdf.rect(10, currentY, pageWidth - 20, rowHeight, 'D');
    pdf.line(130, currentY, 130, currentY + rowHeight);
    pdf.text(description.value, 15, currentY + 7);
    pdf.text(description_price.value, 180, currentY + 7, { align: 'center' });
    currentY += rowHeight;
  }

  // Grand Total
  pdf.rect(10, currentY, pageWidth - 20, rowHeight, 'D');
  pdf.line(130, currentY, 130, currentY + rowHeight);
  pdf.setFont('helvetica', 'bold');
  pdf.text('Grand Total', 70, currentY + 7, { align: 'center' });
  pdf.text(totalquotation.value?.toString() || '0', 180, currentY + 7, { align: 'center' });

  // Footer
  currentY += 20;
  pdf.setFont('helvetica', 'italic', 'bold');
  const validText = `The Quotation is Valid only: ${validUntilDate.value || 'Not Specified'}`;
  pdf.text(validText, 10, currentY);

  currentY += 8;
  pdf.setFont('helvetica', 'italic');
  pdf.text('Thank You!', 10, currentY);

  currentY += 8;
  pdf.setFont('helvetica', 'italic');
  const companyName = props.companyInfo?.name || 'Your Company Name';
  pdf.text(companyName, 10, currentY);

  // Save
  pdf.save(`Quotation_${orderId.value || '0012'}.pdf`);
};




</script>
