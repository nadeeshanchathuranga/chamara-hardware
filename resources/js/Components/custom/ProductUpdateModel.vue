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
            class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-10 text-center"
          >
            <!-- Close Button -->
            <!-- <button
              @click="$emit('update:open', false)"
              class="absolute text-xl text-white top-4 right-4 hover:text-gray-300"
            >
              &times;
            </button> -->

            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white"
              >Edit Product</DialogTitle
            >
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <div class="flex items-center gap-8 mt-6">
                  <!-- Selling Price input -->
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300"
                        >Product Name:</label
                      >
                      <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        required
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                        form.errors.name
                      }}</span>
                    </div>
                  </div>
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Batch No:</label
                    >
                    <input
                      v-model="form.batch_no"
                      type="text"
                      id="batch_no"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.batch_no"
                      class="mt-4 text-red-500"
                      >{{ form.errors.batch_no }}</span
                    >
                  </div>
                  <!-- Cost Price input -->
                </div>



                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <!-- Category Name -->
                    <div>
                      <label class="block text-sm font-medium text-gray-300"
                        >Product Code:</label
                      >
                      <input
                        v-model="form.code"
                        type="text"
                        id="code"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.code" class="mt-4 text-red-500">{{
                        form.errors.code
                      }}</span>
                    </div>

                  </div>
                  <!-- Cost Price input -->
                  <div class="w-full">
                    <!-- Category Name -->
                    <div>
                      <label class="block text-sm font-medium text-gray-300"
                        >Category Name:</label
                      >
                      <select
                        required
                        v-model="form.category_id"
                        id="parent_id"
                        class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      >
                        <option value="">Select a Category</option>
                        <option
                          v-for="category in categories"
                          :key="category.id"
                          :value="category.id"
                        >
                          {{
                            category.hierarchy_string
                              ? category.hierarchy_string +
                                " ----> " +
                                category.name
                              : category.name
                          }}
                        </option>
                      </select>
                      <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                        form.errors.name
                      }}</span>
                    </div>

                  </div>
                </div>

                 <div class="flex items-center gap-8 mt-6">
                  <!-- Selling Price input -->
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300"
                        >Purchase Date:</label
                      >
                      <input
                        v-model="form.purchase_date"
                        type="date"
                        id="purchase_date"

                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.purchase_date" class="mt-4 text-red-500">{{
                        form.errors.purchase_date
                      }}</span>
                    </div>
                  </div>
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Expire Date:</label
                    >
                    <input
                      v-model="form.expire_date"
                      type="date"
                      id="expire_date"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.expire_date"
                      class="mt-4 text-red-500"
                      >{{ form.errors.expire_date }}</span
                    >
                  </div>
                  <!-- Cost Price input -->
                </div>

                <div>
                  <div class="flex items-center gap-8">
                    <!-- First select box with label and error -->
                    <div class="w-full">
                      <label
                        for="size_id"
                        class="block text-sm font-medium text-gray-300"
                        >Size:</label
                      >
                      <select
                        v-model="form.size_id"
                        id="size_id"
                        class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      >
                        <option value="">Select a Size</option>
                        <option
                          v-for="size in sizes"
                          :key="size.id"
                          :value="size.id"
                        >
                          {{ size.name }}
                        </option>
                      </select>
                      <span
                        v-if="form.errors.size_id"
                        class="mt-2 text-red-500"
                      >
                        {{ form.errors.size_id }}
                      </span>
                    </div>

                    <!-- Second select box with label and error -->
                    <div class="w-full">
                      <label
                        for="color_id"
                        class="block text-sm font-medium text-gray-300"
                        >Color:</label
                      >
                      <select
                        v-model="form.color_id"
                        id="color_id"
                        class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      >
                        <option value="">Select a Color</option>
                        <option
                          v-for="color in colors"
                          :key="color.id"
                          :value="color.id"
                        >
                          {{ color.name }}
                        </option>
                      </select>
                      <span
                        v-if="form.errors.color_id"
                        class="mt-2 text-red-500"
                      >
                        {{ form.errors.color_id }}
                      </span>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <!-- Cost Price input -->
                  <div class="w-full">
                    <label
                      for="cost_price"
                      class="block text-sm font-medium text-gray-300"
                      >Cost Price:</label
                    >
                    <input
                      type="number"
                      step="0.01"
                      id="cost_price"
                      v-model="form.cost_price"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter cost price"
                      required
                    />
                    <span
                      v-if="form.errors.cost_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.cost_price }}
                    </span>
                  </div>

                  <!-- Selling Price input -->
                  <div class="w-full">
                    <label
                      for="selling_price"
                      class="block text-sm font-medium text-gray-300"
                      >Selling Price:</label
                    >
                    <input
                      type="text"
                      id="selling_price"
                      v-model="form.selling_price"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter selling price"
                      @blur="updateDiscountedPrice"
                      required
                    />
                    <span
                      v-if="form.errors.selling_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.selling_price }}
                    </span>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <!-- Cost Price input -->
                  <div class="w-full hidden">
                    <label
                      for="cost_price"
                      class="block text-sm font-medium text-gray-300"
                      >Discount (%):</label
                    >
                    <!-- <input
                      type="text"
                      id="discount"
                      v-model="form.discount"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter discount percentage"
                      min="0"
                      max="100"
                    /> -->
                    <input
                      type="text"
                      id="discount"
                      v-model="form.discount"
                      @blur="updateDiscountedPrice"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter discount percentage"
                    />
                    <span v-if="form.errors.discount" class="mt-2 text-red-500">
                      {{ form.errors.discount }}
                    </span>
                  </div>

                  <!-- Selling Price input -->
                  <div class="w-full hidden">
                    <label
                      for="discounted_price"
                      class="block text-sm font-medium text-gray-300"
                    >
                      Discounted Price:
                    </label>
                    <input
                      type="text"
                      id="discounted_price"
                      v-model="form.discounted_price"
                      @blur="updateDiscount"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Discounted price will appear here"
                    />
                    <span
                      v-if="form.errors.discounted_price"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.discounted_price }}
                    </span>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <label
                      for="stock_quantity"
                      class="block text-sm font-medium text-gray-300"
                      >Stock Quantity:</label
                    >

                    <input
                      type="number"
                      id="stock_quantity"
                      v-model="form.stock_quantity"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Stock quantity"
                      required
                    />
                  </div>

                  <div class="w-full">
                    <label
                      for="image"
                      class="block text-sm font-medium text-gray-300"
                      >Supplier Name :</label
                    >

                    <select
                      v-model="form.supplier_id"
                      id="supplier_id"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    >
                      <option value="">Select a Supplier</option>
                      <option
                        v-for="supplier in suppliers"
                        :key="supplier.id"
                        :value="supplier.id"
                      >
                        {{ supplier.name }}
                      </option>
                    </select>
                    <span v-if="form.errors.sub_id" class="mt-4 text-red-500">
                      {{ form.errors.sub_id }}
                    </span>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6" v-if="isPharma">
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Expire Date:</label
                    >
                    <input
                      v-model="form.expire_date"
                      type="date"
                      id="barcode"
                      placeholder="Enter Barcode"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.expire_date"
                      class="mt-4 text-red-500"
                      >{{ form.errors.expire_date }}</span
                    >
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <label
                      for="image"
                      class="block text-sm font-medium text-gray-300"
                      >Image:</label
                    >
                    <div class="w-full md:w-6/12">
                      <label class="block text-sm font-medium text-white"
                        >Current Image</label
                      >
                      <div class="mt-2">
                        <img
                          v-if="selectedProduct.image"
                          :src="`/${selectedProduct.image}`"
                          alt="Product Image"
                          class="rounded-lg"
                          style="width: 80px; height: 80px"
                        />

                        <p v-else class="text-sm text-gray-500">
                          No image available
                        </p>
                      </div>
                    </div>
                    <input
                      type="file"
                      id="image"
                      @change="handleImageUpload"
                      class="w-full px-4 py-2 mt-2 text-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span v-if="form.errors.image" class="mt-2 text-red-500">
                      {{ form.errors.image }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                  type="submit"
                  @click="
                    () => {
                      playClickSound();
                    }
                  "
                >
                  Save
                </button>
                <button
                  type="button"
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="
                    () => {
                      playClickSound();
                      emit('update:open', false);
                    }
                  "
                >
                  Cancel
                </button>
              </div>
            </form>
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

// Emit event to toggle modal visibility
const emit = defineEmits(["update:open"]);

const isPharma = computed(() => import.meta.env.VITE_APP_NAME === "pharma");

// Play click sound function
const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

// Define props
const { open, categories, colors, suppliers, sizes, selectedProduct } =
  defineProps({
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
    suppliers: {
      type: Array,
      required: true,
    },
    sizes: {
      type: Array,
      required: true,
    },
    selectedProduct: {
      type: Object,
      default: null,
    },
  });

// UseForm for form state
const form = useForm({
  category_id: "",
  supplier_id: "",
  stock_quantity: "",
  name: "",
  code: "",
  size_id: "",
  color_id: "",
  cost_price: null,
  discount: 0,
  selling_price: null,
  discounted_price: null,
  barcode: "",
  image: null,
  expire_date: null,
  batch_no: "",
  purchase_date: null,
});

// Handle file upload for images
const handleImageUpload = (event) => {
  form.image = event.target.files[0];
};

function limitToTwoDecimals(value) {
  if (value === null || value === undefined) return value;
  const strValue = value.toString();
  const match = strValue.match(/^(\d+)(\.\d{0,2})?/); // Match up to 2 decimal places
  return match ? parseFloat(match[0]) : value;
}

// Function to update discounted price based on selling price and discount
function updateDiscountedPrice() {
  if (form.selling_price && form.discount) {
    const discountAmount = (form.selling_price * form.discount) / 100;
    form.discounted_price = limitToTwoDecimals(
      form.selling_price - discountAmount
    );
  }
}

// Function to update discount based on selling price and discounted price
function updateDiscount() {
  if (form.selling_price && form.discounted_price) {
    const discountAmount = form.selling_price - form.discounted_price;
    form.discount = limitToTwoDecimals(
      (discountAmount / form.selling_price) * 100
    );
  }
}
// Utility function to limit to 2 decimal points
// function limitToTwoDecimals(value) {
//   if (value === null || value === undefined) return value;
//   const strValue = value.toString();
//   const match = strValue.match(/^(\d+)(\.\d{0,2})?/); // Match up to 2 decimal places
//   return match ? parseFloat(match[0]) : value;
// }

// // Computed property for dynamically calculating the discounted price
// const discountedPrice = computed(() => {
//   if (form.selling_price && form.discount) {
//     const discountAmount = (form.selling_price * form.discount) / 100;
//     return limitToTwoDecimals(form.selling_price - discountAmount);
//   }
//   return form.selling_price || 0;
// });

// // Watch the computed discounted price and update the form's discounted_price field
// watch(discountedPrice, (newValue) => {
//   form.discounted_price = limitToTwoDecimals(newValue);
// });

// // Watch the discounted_price field to dynamically calculate the discount percentage
// watch(
//   () => form.discounted_price,
//   (newDiscountedPrice) => {
//     if (form.selling_price && newDiscountedPrice) {
//       const discountAmount =
//         form.selling_price - parseFloat(newDiscountedPrice);
//       form.discount = limitToTwoDecimals(
//         (discountAmount / form.selling_price) * 100
//       );
//     }
//   }
// );

// Watch for changes in selectedProduct and populate form
watch(
  () => selectedProduct,
  (newValue) => {
    if (newValue) {
      form.category_id = newValue.category_id || "";
      form.name = newValue.name || "";
      form.code = newValue.code || "";
      form.supplier_id = newValue.supplier_id || "";
      form.stock_quantity = newValue.stock_quantity || null;
      form.size_id = newValue.size_id || "";
      form.color_id = newValue.color_id || "";
      form.cost_price = newValue.cost_price || null;
      form.discount = newValue.discount || 0;
      form.selling_price = newValue.selling_price || null;
      form.discounted_price = newValue.discounted_price || null;
      form.barcode = newValue.barcode || "";
      form.batch_no = newValue.batch_no || "";
      form.image = newValue.image || null;
      form.expire_date = newValue.expire_date
        ? new Date(newValue.expire_date).toISOString().split("T")[0]
        : null;
      form.purchase_date = newValue.purchase_date
        ? new Date(newValue.purchase_date).toISOString().split("T")[0]
        : null;
    }
  },
  { immediate: true }
);

// Submit the form
const submit = () => {
  form.post(`/products/${selectedProduct.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product updated successfully!");
      form.reset(); // Reset form fields after successful submission
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>
