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
        <!-- Left: form -->
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
              <div
                class="flex items-center w-full py-4 border-b border-black"
                v-for="item in products"
                :key="item.id"
              >
                <div class="flex w-1/6">
                  <img
                    :src="item.image ? `/${item.image}` : '/images/placeholder.jpg'"
                    alt="Supplier Image"
                    class="object-cover w-16 h-16 border border-gray-500"
                  />
                </div>
                <div class="flex flex-col justify-between w-5/6">
                  <p class="text-xl text-black">
                    {{ item.name }}
                  </p>
                  <div class="flex items-center justify-between w-full">
                    <div class="flex space-x-4">
                      <p
                        @click="incrementQuantity(item.id)"
                        class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                      >
                        <i class="ri-add-line"></i>
                      </p>

                      <input
                        type="number"
                        v-model.number="item.quantity"
                        min="0"
                        class="bg-[#D9D9D9] border-2 border-black h-8 w-24 text-black flex justify-center items-center rounded text-center"
                      />
                      <p
                        @click="decrementQuantity(item.id)"
                        class="flex items-center justify-center w-8 h-8 text-white bg-black rounded cursor-pointer"
                      >
                        <i class="ri-subtract-line"></i>
                      </p>
                    </div>
                    <div class="flex items-center justify-center">
                      <div>
                        <p
                          @click="applyDiscount(item.id)"
                          v-if="item.discount && item.discount > 0 && item.apply_discount == false && !appliedCoupon"
                          class="cursor-pointer py-1 text-center px-4 bg-green-600 rounded-xl font-bold text-white tracking-wider"
                        >
                          Apply {{ item.discount }}% off
                        </p>

                        <p
                          v-if="item.discount && item.discount > 0 && item.apply_discount == true && !appliedCoupon"
                          @click="removeDiscount(item.id)"
                          class="cursor-pointer py-1 text-center px-4 bg-red-600 rounded-xl font-bold text-white tracking-wider"
                        >
                          Remove {{ item.discount }}% Off
                        </p>

                        <input
                          v-model.number="item.selling_price"
                          type="number"
                          min="0"
                          class="w-40 m-2 text-right px-2 py-1 border-2 border-black rounded text-black font-bold text-xl"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex justify-end w-1/6">
                  <p
                    @click="removeProduct(item.id)"
                    class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                  >
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

        <!-- Right: preview -->
        <div id="quotation-content" class="w-[50%] bg-white border border-gray-300 rounded-lg shadow-md p-6">
          <div>
            <div class="text-center mb-6">
              <h1 class="text-4xl font-extrabold text-gray-800">{{ companyInfo ? companyInfo.name : 'Company Name' }}</h1>
              <h2 class="text-2xl font-semibold text-gray-600 mt-2">Sales Quotation</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
              <div>
                <p class="text-sm font-medium text-gray-500">Quotation ID:</p>
                <p class="text-base font-semibold text-gray-800">{{ orderId }}</p>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-500">Quote Date:</p>
                <p class="text-base font-semibold text-gray-800">{{ new Date().toISOString().split('T')[0] }}</p>
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
                    <tr v-for="item in products" :key="item.id">
                      <td class="px-4 py-2 text-gray-800 text-sm">{{ item.name }}</td>
                      <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.quantity }}</td>
                      <td class="px-4 py-2 text-gray-800 text-right text-sm">{{ item.selling_price }}</td>
                      <td class="px-4 py-2 text-gray-800 text-right text-sm">
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
                <p class="text-right text-sm font-semibold text-gray-800">{{ total }}</p>

                <template v-if="parseFloat(totalDiscount) > 0">
                  <p class="text-sm text-gray-500">Discount:</p>
                  <p class="text-right text-sm font-semibold text-gray-800">{{ totalDiscount }}</p>
                </template>

                <p class="text-sm text-gray-500">{{ description || ' ' }}</p>
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
import { useForm, router, Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
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
const custom_discount_type = ref("percent");
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
  companyInfo: Array,
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
  const p = products.value.find((item) => item.id === id);
  if (p) p.quantity += 1;
};

const decrementQuantity = (id) => {
  const p = products.value.find((item) => item.id === id);
  if (p && p.quantity > 1) p.quantity -= 1;
};

const orderId = computed(() => {
  const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  return Array.from({ length: 6 }, () =>
    characters.charAt(Math.floor(Math.random() * characters.length))
  ).join("");
});

const submitOrder = async () => {
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
    console.log(response.data);
  } catch (err) {
    if (err.response?.status === 423) {
      isAlertModalOpen.value = true;
      message.value = err.response.data.message;
    }
    console.error("Error submitting:", err.response?.data || err.message);
  }
};

const subtotal = computed(() =>
  products.value
    .reduce((t, item) => t + (Number(item.selling_price) || 0) * (item.quantity || 0), 0)
    .toFixed(2)
);

const totalDiscount = computed(() => {
  const productDiscount = products.value.reduce((total, item) => {
    if (item.discount && item.discount > 0 && item.apply_discount === true) {
      const discountAmount =
        (parseFloat(item.selling_price) - parseFloat(item.discounted_price)) * item.quantity;
      return total + discountAmount;
    }
    return total;
  }, 0);

  const couponDiscount = appliedCoupon.value ? Number(appliedCoupon.value.discount) : 0;
  const additionalDiscount = parseFloat(add_discount.value) || 0;

  return (productDiscount + couponDiscount + additionalDiscount).toFixed(2);
});

const total = computed(() => {
  const subtotalValue = parseFloat(subtotal.value) || 0;
  return subtotalValue.toFixed(2);
});

const totalquotation = computed(() => {
  const subtotalValue = parseFloat(subtotal.value) || 0;
  const discountValue = parseFloat(totalDiscount.value) || 0;
  const customAdditional = parseFloat(description_price.value) || 0;
  return (subtotalValue + customAdditional - discountValue).toFixed(2);
});

const form = useForm({
  employee_id: "",
  barcode: "",
  description: "",
  description_price: "",
  add_discount: "",
  valid_date: "",
  client_name: "",
  client_address: "",
});

const couponForm = useForm({ code: "" });

// barcode scanner helpers
let barcode = "";
let timeout;

const submitCoupon = async () => {
  try {
    const response = await axios.post(route("pos.getCoupon"), { code: couponForm.code });
    const { coupon: fetchedCoupon, error: fetchedError } = response.data;

    if (fetchedCoupon) {
      appliedCoupon.value = fetchedCoupon;
      products.value.forEach((p) => (p.apply_discount = false));
    } else {
      isAlertModalOpen.value = true;
      message.value = fetchedError;
      error.value = fetchedError;
    }
  } catch (err) {
    if (err.response?.status === 422) {
      isAlertModalOpen.value = true;
      message.value = err.response.data.message;
    }
  }
};

const submitBarcode = async () => {
  try {
    const response = await axios.post(route("pos.getProduct"), { barcode: form.barcode });
    const { product: fetchedProduct, error: fetchedError } = response.data;

    if (fetchedProduct) {
      if (fetchedProduct.stock_quantity < 1) {
        isAlertModalOpen.value = true;
        message.value = "Product is out of stock";
        return;
      }
      const existing = products.value.find((i) => i.id === fetchedProduct.id);
      if (existing) existing.quantity += 1;
      else
        products.value.push({
          ...fetchedProduct,
          quantity: 1,
          apply_discount: false,
        });

      product.value = fetchedProduct;
      error.value = null;
    } else {
      isAlertModalOpen.value = true;
      message.value = fetchedError;
      error.value = fetchedError;
    }
  } catch (err) {
    if (err.response?.status === 422) {
      isAlertModalOpen.value = true;
      message.value = err.response.data.message;
    }
    error.value = "An unexpected error occurred. Please try again.";
  }
};

const handleScannerInput = (event) => {
  clearTimeout(timeout);
  if (event.key === "Enter") {
    form.barcode = barcode;
    submitBarcode();
    barcode = "";
  } else {
    barcode += event.key;
  }
  timeout = setTimeout(() => (barcode = ""), 100);
};

onMounted(() => {
  document.addEventListener("keypress", handleScannerInput);
});

const applyDiscount = (id) => {
  products.value.forEach((p) => {
    if (p.id === id) p.apply_discount = true;
  });
};

const removeDiscount = (id) => {
  products.value.forEach((p) => {
    if (p.id === id) p.apply_discount = false;
  });
};

const handleSelectedProducts = (selectedProducts) => {
  selectedProducts.forEach((fetchedProduct) => {
    const existing = products.value.find((i) => i.id === fetchedProduct.id);
    if (existing) existing.quantity += 1;
    else
      products.value.push({
        ...fetchedProduct,
        quantity: 1,
        apply_discount: false,
      });
  });
};

const addQuotation = () => {
  validUntilDate.value = form.valid_date;
  description.value = form.description;
  description_price.value = form.description_price;
  add_discount.value = form.add_discount;
};

// ========== PDF GENERATION (with wrapped product names) ==========
const downloadPdf = async () => {
  const pdf = new jsPDF();

  const headerSize = 40;
  const titleSize = 10;

  const pageWidth = pdf.internal.pageSize.getWidth();
  const pageHeight = pdf.internal.pageSize.getHeight();

  // Header background
  pdf.setFillColor(25, 47, 66);
  pdf.rect(0, 0, pageWidth, 50, "F");

  // Quotation Title
  pdf.setTextColor(255, 255, 255);
  pdf.setFontSize(headerSize);
  pdf.setFont("helvetica", "bold");
  pdf.text("Quotation", 15, 30);

  // Logo (top-right)
  try {
    const logoImg = new Image();
    logoImg.crossOrigin = "Anonymous";
    await new Promise((resolve, reject) => {
      logoImg.onload = resolve;
      logoImg.onerror = reject;
      setTimeout(reject, 3000);
    });
    const canvas = document.createElement("canvas");
    canvas.width = logoImg.width;
    canvas.height = logoImg.height;
    const ctx = canvas.getContext("2d");
    ctx.drawImage(logoImg, 0, 0);
    const base64Img = canvas.toDataURL("image/png");
    const imgWidth = 40;
    const imgHeight = 20;
    const xPos = pageWidth - imgWidth - 10;
    const yPos = 5;
    pdf.addImage(base64Img, "PNG", xPos, yPos, imgWidth, imgHeight);
  } catch (err) {
   
  }

  // Right-side contact details (white)
  const contactDetails = [
    { text: "077 477 2910 | 011 218 9778", icon: "/images/phone-icon.png" },
    { text: "chamarahwts@gmail.com", icon: "/images/web-icon.png" },
    { text: "No 51/62, Rukmale, Pannipitiya", icon: "/images/location-icon.png" },
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
      iconImg.crossOrigin = "Anonymous";
      await new Promise((resolve, reject) => {
        iconImg.onload = resolve;
        iconImg.onerror = reject;
        setTimeout(reject, 3000);
      });
      const c = document.createElement("canvas");
      c.width = iconImg.width;
      c.height = iconImg.height;
      const cx = c.getContext("2d");
      cx.drawImage(iconImg, 0, 0);
      const base64Icon = c.toDataURL("image/png");
      pdf.addImage(base64Icon, "PNG", contactX, contactY, iconSize, iconSize);
    } catch {}
    pdf.setFontSize(10);
    pdf.setFont("helvetica", "normal");
    pdf.setTextColor(255, 255, 255);
    pdf.text(item.text, contactX + iconSize + iconGap, contactY + 4);
    contactY += lineSpacing;
  }

  // reset to black text
  pdf.setTextColor(0, 0, 0);
  let startY = 55;

  // Quotation Number + Date blocks
  pdf.setFillColor(240, 240, 240);
  pdf.setDrawColor(0, 0, 0);
  pdf.rect(10, startY, pageWidth / 2 - 15, 15);
  pdf.setFontSize(titleSize);
  pdf.setFont("helvetica", "bold");
  pdf.text("Quotation #: " + (orderId.value || "0012"), 15, startY + 10);

  pdf.rect(pageWidth / 2, startY, pageWidth / 2 - 10, 15);
  const formattedDate = new Date().toLocaleDateString("en-GB", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
  pdf.text("Quotation Date: " + formattedDate, pageWidth / 2 + 5, startY + 10);

  // Billed To + Address
  startY += 15;
  pdf.rect(10, startY, pageWidth / 2 - 15, 25);
  pdf.setFont("helvetica", "bold");
  pdf.text("Billed To:", 15, startY + 5);
  pdf.setFont("helvetica", "normal");
  const clientName = form.client_name || "Client Name Not Provided";
  pdf.text(clientName, 15, startY + 12);

  pdf.rect(pageWidth / 2, startY, pageWidth / 2 - 10, 25);
  pdf.setFont("helvetica", "bold");
  pdf.text("Address:", pageWidth / 2 + 5, startY + 5);
  pdf.setFont("helvetica", "normal");
  const clientAddress = form.client_address || "Client Address Not Provided";
  const addressLines = pdf.splitTextToSize(clientAddress, pageWidth / 2 - 20);
  pdf.text(addressLines, pageWidth / 2 + 5, startY + 12);

  // ===================== TABLE (WRAPPED ROWS) =====================
  startY += 25;

  const marginX = 10;
  const tableTopY = startY;
  const col = {
    product: { x: marginX, w: 60 },
    qty: { x: marginX + 60, w: 60 },
    unit: { x: marginX + 120, w: 30 },
    total: { x: marginX + 150, w: pageWidth - 20 - 150 },
  };
  const headerH = 10;
  const lineH = 7;
  const cellPadX = 3;
  const cellPadY = 4;
  const pageBottom = pageHeight - 20;

  // header
  pdf.setFillColor(240, 240, 240);
  pdf.rect(marginX, tableTopY, pageWidth - 20, headerH, "FD");
  pdf.setFont("helvetica", "bold");
  pdf.text("Product", col.product.x + col.product.w / 2, tableTopY + 7, { align: "center" });
  pdf.text("Quantity", col.qty.x + col.qty.w / 2, tableTopY + 7, { align: "center" });
  pdf.text("Unit Price", col.unit.x + col.unit.w / 2, tableTopY + 7, { align: "center" });
  pdf.text("Total", col.total.x + col.total.w / 2, tableTopY + 7, { align: "center" });
  pdf.line(col.qty.x, tableTopY, col.qty.x, tableTopY + headerH);
  pdf.line(col.unit.x, tableTopY, col.unit.x, tableTopY + headerH);
  pdf.line(col.total.x, tableTopY, col.total.x, tableTopY + headerH);

  let y = tableTopY + headerH;
  pdf.setFont("helvetica", "normal");

  const drawHeaderOnNewPage = () => {
    pdf.setFillColor(240, 240, 240);
    pdf.rect(marginX, 20, pageWidth - 20, headerH, "FD");
    pdf.setFont("helvetica", "bold");
    pdf.text("Product", col.product.x + col.product.w / 2, 27, { align: "center" });
    pdf.text("Quantity", col.qty.x + col.qty.w / 2, 27, { align: "center" });
    pdf.text("Unit Price", col.unit.x + col.unit.w / 2, 27, { align: "center" });
    pdf.text("Total", col.total.x + col.total.w / 2, 27, { align: "center" });
    pdf.line(col.qty.x, 20, col.qty.x, 20 + headerH);
    pdf.line(col.unit.x, 20, col.unit.x, 20 + headerH);
    pdf.line(col.total.x, 20, col.total.x, 20 + headerH);
    y = 20 + headerH;
  };

  const addPageIfNeeded = (neededHeight) => {
    if (y + neededHeight > pageBottom) {
      pdf.addPage();
      drawHeaderOnNewPage();
    }
  };

  products.value.forEach((item) => {
    const name = item.name || "Unnamed Product";
    const wrappedName = pdf.splitTextToSize(name, col.product.w - cellPadX * 2);
    const lines = Array.isArray(wrappedName) ? wrappedName.length : 1;
    const rowH = Math.max(headerH, lines * lineH + cellPadY);

    addPageIfNeeded(rowH);

    pdf.rect(marginX, y, pageWidth - 20, rowH, "D");
    pdf.line(col.qty.x, y, col.qty.x, y + rowH);
    pdf.line(col.unit.x, y, col.unit.x, y + rowH);
    pdf.line(col.total.x, y, col.total.x, y + rowH);

    pdf.setTextColor(0, 0, 0);
    pdf.text(wrappedName, col.product.x + cellPadX, y + cellPadY + 3);

    const qty = (item.quantity ?? 0).toString();
    const unit = (Number(item.selling_price) || 0).toFixed(2);
    const sub = ((Number(item.selling_price) || 0) * (Number(item.quantity) || 0)).toFixed(2);

    pdf.text(qty, col.qty.x + col.qty.w / 2, y + rowH / 2 + 2, { align: "center" });
    pdf.text(unit, col.unit.x + col.unit.w / 2, y + rowH / 2 + 2, { align: "center" });
    pdf.text(sub, col.total.x + col.total.w / 2, y + rowH / 2 + 2, { align: "center" });

    y += rowH;
  });

  // Optional description row
  if (description.value) {
    const descText = pdf.splitTextToSize(
      description.value,
      col.unit.x - marginX - cellPadX * 2
    );
    const descLines = descText.length || 1;
    const rowH = Math.max(headerH, descLines * lineH + cellPadY);
    addPageIfNeeded(rowH);

    pdf.rect(marginX, y, pageWidth - 20, rowH, "D");
    pdf.line(col.unit.x, y, col.unit.x, y + rowH);
    pdf.text(descText, marginX + cellPadX, y + cellPadY + 3);
    pdf.text((description_price.value || "0").toString(), col.total.x + col.total.w / 2, y + rowH / 2 + 2, {
      align: "center",
    });

    y += rowH;
  }

  // Grand Total row
  const gtRowH = headerH;
  addPageIfNeeded(gtRowH);
  pdf.rect(marginX, y, pageWidth - 20, gtRowH, "D");
  pdf.line(col.unit.x, y, col.unit.x, y + gtRowH);
  pdf.setFont("helvetica", "bold");
  pdf.text("Grand Total", col.qty.x + col.qty.w / 2, y + gtRowH / 2 + 2, { align: "center" });
  pdf.text((totalquotation.value ?? 0).toString(), col.total.x + col.total.w / 2, y + gtRowH / 2 + 2, {
    align: "center",
  });

  // Footer
  y += 20;
  pdf.setFont("helvetica", "italic", "bold");
  const validText = `The Quotation is Valid only: ${validUntilDate.value || "Not Specified"}`;
  pdf.text(validText, 10, y);

  y += 8;
  pdf.setFont("helvetica", "italic");
  pdf.text("Thank You!", 10, y);

  y += 8;
  const companyName = props.companyInfo?.name || "Your Company Name";
  pdf.text(companyName, 10, y);

  pdf.save(`Quotation_${orderId.value || "0012"}.pdf`);
};
</script>
