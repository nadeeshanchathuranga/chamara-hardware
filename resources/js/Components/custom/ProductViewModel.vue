<template>
  <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="$emit('update:open', false)">
      <!-- Modal Overlay -->
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div
          class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
        />
      </TransitionChild>

      <!-- Modal Content -->
      <div class="fixed inset-0 z-10 flex items-center justify-center">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel
            class="bg-white text-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-6"
          >
            <div
              class="flex flex-col items-start justify-start w-full h-full px-2 pt-4"
            >
              <div
                class="flex justify-center w-full h-full py-4 space-x-8 items-start-center"
              >
                <!-- Left Side: Image -->
                <div class="w-1/2">
                  <img
                    :src="
                      selectedProduct.image
                        ? `/${selectedProduct.image}`
                        : '/images/placeholder.jpg'
                    "
                    alt="Product Image"
                    class="object-cover h-full rounded-2xl"
                  />
                </div>

                <!-- Right Side: Text Content -->
                <div class="flex flex-col justify-between w-1/2 h-full">
                  <div class="flex items-center justify-between">
                    <!-- Product Name -->
                    <p class="text-3xl font-bold text-black w-full break-words">
                      {{ selectedProduct.name }}

                      <span
                        v-if="
                          selectedProduct.discount &&
                          selectedProduct.discount > 0
                        "
                        class="inline-block px-2 py-2 text-sm font-medium text-white bg-red-600 rounded"
                      >
                        {{ selectedProduct.discount }} % OFF
                      </span>
                    </p>

                    <!-- Discounted Price -->
                  </div>

                  <p
                    class="pb-6 mt-2 text-[#00000099] text-xl font-normal italic"
                  >
                    {{ selectedProduct.category?.name ?? "No Category" }}
                  </p>

                  <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal">Supplier : </span
                    >{{ selectedProduct.supplier?.name || "N/A" }}
                  </p>

                  <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Product Code :
                    </span>

                    {{ selectedProduct?.code ?? "N/A" }}
                  </p>
                  <p class="pb-6 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Batch No :
                    </span>

                    {{ selectedProduct?.batch_no ?? "N/A" }}
                  </p>


                  <div
                    class="flex items-center justify-between w-full text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p
                        class="text-justify text-[#00000099] text-2xl flex items-center pb-6"
                      >
                        Color :

                        <span class="font-bold text-black">
                          {{ selectedProduct?.color?.name ?? "N/A" }}
                        </span>
                      </p>
                    </div>
                  </div>

                  <div
                    class="flex items-center justify-between w-full text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099] text-2xl pb-6">
                        Size :
                        <span
                          class="px-2 py-2 font-bold text-black border-2 border-gray-800 rounded-xl"
                        >
                          {{ selectedProduct?.size?.name ?? "N/A" }}
                        </span>
                      </p>
                    </div>
                  </div>

                  <div
                    class="flex items-center justify-between w-full pb-6 text-2xl"
                  >
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Selling Price :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.selling_price ?? "N/A" }}
                        LKR
                      </p>
                    </div>
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Cost Price :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.cost_price ?? "N/A" }}

                        LKR
                      </p>
                    </div>
                  </div>

                  <div
                    class="flex items-center justify-between w-full pb-6 text-2xl"
                  >
                    <div
                      class="flex flex-col w-full"
                      v-if="
                        selectedProduct.discount && selectedProduct.discount > 0
                      "
                    >
                      <p class="text-[#00000099]">Discount Price :</p>
                      <p class="font-bold text-black">
                        {{
                          selectedProduct.selling_price &&
                          selectedProduct.discount &&
                          selectedProduct.discount > 0
                            ? (
                                selectedProduct.selling_price -
                                (selectedProduct.selling_price *
                                  selectedProduct.discount) /
                                  100
                              ).toFixed(2)
                            : selectedProduct.selling_price
                        }}
                        LKR
                      </p>
                    </div>
                    <div class="flex flex-col w-full">
                      <p class="text-[#00000099]">Quantity :</p>
                      <p class="font-bold text-black">
                        {{ selectedProduct?.stock_quantity ?? "N/A" }}
                      </p>
                    </div>
                  </div>

                  <p class="pb-8 text-2xl font-bold text-black">
                    <span class="text-[#00000099] font-normal"
                      >Created On :
                    </span>
                    {{ formattedDate }}
                  </p>

                  <div class="mt-2">
                    <input
                      hidden
                      type="text"
                      id="barcodeInput"
                      v-model="selectedProduct.barcode"
                      class="w-full px-4 py-2 placeholder-gray-400 border-gray-300 rounded order f focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    />

                    <button
                      v-if="HasRole(['Admin', 'Manager'])"
                      class="w-full px-4 py-3 text-2xl font-semibold tracking-widest text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
                      @click="generateAndPrintBarcode"
                    >
                      Print Bar Code
                    </button>
                  </div>
                </div>
              </div>

              <!-- Hidden container for printing -->
              <div
                :class="{ hidden: !isVisible }"
                id="printContainer"
                class="print-container"
              >
                <div class="print-content">
                  <!-- <div class="product-details">
                    <p class="product-category">
                      {{ selectedProduct.category?.name || "N/A" }}
                    </p>
                    <p class="product-price">
                      {{ selectedProduct?.selling_price ?? "N/A" }} LKR
                    </p>
                  </div> -->

                  <p class="product-code">
                    {{ selectedProduct?.name || "N/A" }}
                  </p>

                  <!-- Barcode -->
                  <svg id="barcodePrint"></svg>

                  <!-- <p class="product-code">
                    {{ selectedProduct?.code ?? "N/A" }}
                  </p> -->

                  <div class="product-details">
                    <p class="product-category">
                      {{ selectedProduct?.code ?? "N/A" }}
                    </p>
                    <p class="product-price">
                      {{ selectedProduct?.selling_price ?? "N/A" }} LKR
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>




<script setup>
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref, watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { HasRole } from "@/Utils/Permissions";

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

// Extend Day.js for ordinal formatting
import advancedFormat from "dayjs/plugin/advancedFormat";
dayjs.extend(advancedFormat);

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
const { selectedProduct } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  colors: {
    type: Array,
    required: true,
  },
  sizes: {
    type: Array,
    required: true,
  },
  selectedProduct: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

// Computed property to format the date
const formattedDate = computed(() =>
  selectedProduct && selectedProduct.created_at
    ? dayjs(selectedProduct.created_at).format("Do MMMM YYYY")
    : ""
);

function generateAndPrintBarcode() {
  const input = document.getElementById("barcodeInput").value;
  const barcodePrintElement = document.getElementById("barcodePrint");

  if (input.trim() === "") {
    alert("Please enter text to generate and print a barcode.");
    return;
  }

  JsBarcode(barcodePrintElement, input, {
    format: "CODE128", // Code 128 is compact and ideal for small labels
    lineColor: "#000", // Black lines for high contrast
    width: 1.2, // Wider bars to fill the label width
    height: 50, // Barcode height adjusted for the label
    displayValue: false, // Disable text display
    margin: 0, // Remove default margins
  });

  const printContents = document.getElementById("printContainer").innerHTML;
  const originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;

  location.reload();
}
</script>

<style>
@media print {
  /* Label container */
  #printContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    margin-top: 0;
  }

  /* Print content */
  .print-content {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    width: 100%;
    margin-top: 2mm;
  }

  /* Barcode centered and full width */
  #barcodePrint {
    width: 100%;
    margin-left: 12mm;
  }

  /* Product details */
  .product-details {
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
    font-size: 10px;
    font-weight: bold;
    margin-bottom: 5px;
    margin-left: 12mm;
  }

  .product-category,
  .product-price {
    color: #000;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* Product code */
  .product-code {
    color: #000;
    font-size: 10px;
    font-weight: bold;
    margin-top: 5px;
    margin-left: 10mm;
  }
}
</style>

