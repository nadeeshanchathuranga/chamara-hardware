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
            <p v-if="successMessage" class="text-lg text-green-400 mt-2">
              {{ successMessage }}
            </p>
            <DialogTitle class="text-xl font-bold text-white"
              >Add Product</DialogTitle
            >

            <div class="grid grid-cols-1 gap-4 pt-4">
              <!-- Single Column with Buttons -->
              <div class="p-4 rounded-lg text-center">
                <button
                  @click="openDialog('size')"
                  class="px-8 py-3 text-white bg-blue-600 rounded hover:bg-blue-700 text-lg font-medium mx-4"
                >
                  Add Size
                </button>
                <button
                  @click="openDialog('color')"
                  class="px-8 py-3 text-white bg-green-600 rounded hover:bg-green-700 text-lg font-medium mx-4"
                >
                  Add Color
                </button>
                <button
                  @click="openDialog('category')"
                  class="px-8 py-3 text-white bg-purple-600 rounded hover:bg-purple-700 before: text-lg font-medium mx-4"
                >
                  Add Category
                </button>
              </div>
            </div>

            <!-- Dialog -->
            <TransitionRoot
              as="template"
              :show="isDialogOpen"
              @close="closeDialog"
            >
              <Dialog as="div" class="relative z-10" @close="closeDialog">
                <div
                  class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"
                ></div>
                <div class="fixed inset-0 overflow-y-auto">
                  <div
                    class="flex items-center justify-center min-h-full p-4 text-center sm:p-0"
                  >
                    <DialogPanel
                      class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full"
                    >
                      <div class="bg-gray-100 p-6">
                        <!-- Dynamic Dialog Title -->
                        <DialogTitle
                          class="text-lg font-medium leading-6 text-gray-900"
                        >
                          {{
                            dialogType === "size"
                              ? "Add Size"
                              : dialogType === "color"
                              ? "Add Color"
                              : "Add Category"
                          }}
                        </DialogTitle>

                        <div class="mt-4">
                          <!-- Conditional Rendering of Forms -->
                          <form
                            v-if="dialogType === 'size'"
                            @submit.prevent="submitSize"
                          >
                            <label class="block text-md font-bold text-gray-700"
                              >Size Name:</label
                            >
                            <input
                              v-model="sizeForm.sizeName"
                              type="text"
                              required
                              class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                            />
                            <span
                              v-if="sizeForm.errors.sizeName"
                              class="mt-2 text-red-500"
                            >
                              {{ sizeForm.errors.sizeName }}
                            </span>
                            <div class="mt-4">
                              <button
                                type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                              >
                                Save
                              </button>
                              <button
                                type="button"
                                @click="closeDialog"
                                class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400 ml-2"
                              >
                                Cancel
                              </button>
                            </div>
                          </form>

                          <form
                            v-if="dialogType === 'color'"
                            @submit.prevent="submitColor"
                          >
                            <label class="block text-md font-bold text-gray-700"
                              >Color Name:</label
                            >
                            <input
                              v-model="colorForm.colorName"
                              type="text"
                              required
                              class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-green-600"
                            />
                            <span
                              v-if="colorForm.errors.colorName"
                              class="mt-2 text-red-500"
                            >
                              {{ colorForm.errors.colorName }}
                            </span>
                            <div class="mt-4">
                              <button
                                type="submit"
                                class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700"
                              >
                                Save
                              </button>
                              <button
                                type="button"
                                @click="closeDialog"
                                class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400 ml-2"
                              >
                                Cancel
                              </button>
                            </div>
                          </form>

                          <form
                            v-if="dialogType === 'category'"
                            @submit.prevent="submitCategory"
                          >
                            <label class="block text-md font-bold text-gray-700"
                              >Category Name:</label
                            >
                            <input
                              v-model="categoryForm.categoryName"
                              type="text"
                              required
                              class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-purple-600"
                            />
                            <label
                              class="block text-md font-bold text-gray-700 mt-4"
                              >Parent Category:</label
                            >
                            <select
                              v-model="categoryForm.parent_id"
                              class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-purple-600"
                            >
                              <option value="">No Parent</option>
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
                            <span
                              v-if="categoryForm.errors.parent_id"
                              class="mt-2 text-red-500"
                            >
                              {{ categoryForm.errors.parent_id }}
                            </span>
                            <div class="mt-4">
                              <button
                                type="submit"
                                class="px-4 py-2 text-white bg-purple-600 rounded hover:bg-purple-700"
                              >
                                Save
                              </button>
                              <button
                                type="button"
                                @click="closeDialog"
                                class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400 ml-2"
                              >
                                Cancel
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </DialogPanel>
                  </div>
                </div>
              </Dialog>
            </TransitionRoot>

            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                  <div class="flex items-center gap-8">
                    <div class="w-full">
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
                <div class="w-full">
                  <label class="block text-sm font-medium text-gray-300"
                    >Supplier Name:</label
                  >
                  <select
                    v-model="form.supplier_id"
                    id="parent_id"
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
                  <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                    form.errors.name
                  }}</span>
                  </div>
                  </div>
                <div class="flex items-center gap-8">
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Bar code:</label
                    >
                    <input
                      v-model="form.barcode"
                      type="text"
                      id="barcode"
                      placeholder="Enter Barcode"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.barcode"
                      class="mt-4 text-red-500"
                      >{{ form.errors.barcode }}</span
                    >
                  </div>
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Product code:</label
                    >
                    <input
                      v-model="form.code"
                      type="text"
                      id="code"
                      placeholder="Enter product code"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.code"
                      class="mt-4 text-red-500"
                      >{{ form.errors.code }}</span
                    >
                  </div>
                </div>

                <div class="flex items-center gap-8">
                  <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Batch No:</label
                    >
                    <input
                      v-model="form.batch_no"
                      type="text"
                      id="batch_no"
                      placeholder="Enter batch no"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.batch_no"
                      class="mt-4 text-red-500"
                      >{{ form.errors.batch_no }}</span
                    >
                  </div>
                  <div class="w-full">
                      <label class="block text-sm font-medium text-gray-300"
                        >Product Name:</label
                      >
                      <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        required
                        placeholder="Enter Product Name"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.name" class="mt-4 text-red-500">{{
                        form.errors.name
                      }}</span>
                    </div>
                </div>

                <div>
                  <div class="flex items-center gap-8">
                    <!-- First select box with label and error -->
                    <div class="w-full">
                    <label class="block text-sm font-medium text-gray-300"
                      >Purchase Date:</label
                    >
                    <input
                      v-model="form.purchase_date"
                      type="date"
                      id="purchase_date"
                      placeholder="Enter purchase date"
                      class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    />
                    <span
                      v-if="form.errors.purchase_date"
                      class="mt-4 text-red-500"
                      >{{ form.errors.purchase_date }}</span
                    >
                  </div>

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
                </div>
                <div>
                  <div class="flex items-center gap-8">
                    <!-- First select box with label and error -->
                    <div class="w-full">
                      <label
                        for="parent_id"
                        class="block text-sm font-medium text-gray-300"
                        >Size:</label
                      >
                      <select
                        v-model="form.size_id"
                        id="parent_id"
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
                        v-if="form.errors.parent_id"
                        class="mt-2 text-red-500"
                      >
                        {{ form.errors.parent_id }}
                      </span>
                    </div>
                    <!-- Second select box with label and error -->
                    <div class="w-full">
                      <label
                        for="sub_id"
                        class="block text-sm font-medium text-gray-300"
                        >Color:</label
                      >
                      <select
                        v-model="form.color_id"
                        id="sub_id"
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
                      <span v-if="form.errors.sub_id" class="mt-2 text-red-500">
                        {{ form.errors.sub_id }}
                      </span>
                    </div>

                     <div class="w-full">
    <label class="block text-sm font-medium text-gray-300">Type:</label>
    <select
      v-model="form.type"
      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
    >
      <option value="">Select Type</option>
      <option value="Normal">Normal</option>
      <option value="Weight Based">Weight Based</option>
    </select>
    <span v-if="form.errors.type" class="mt-2 text-red-500">
      {{ form.errors.type }}
    </span>
  </div>

                    
                    <div class="w-full" v-if="form.type === 'Weight Based'">
                    <label class="block text-sm font-medium text-gray-300">Unit:</label>
                    <select
                    id="unit_id"
                      v-model="form.unit_id"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    >
                      <option value="">Select a Unit</option>
                      <option
                        v-for="unit in units"
                        :key="unit.id"
                        :value="unit.id"
                      >
                        {{ unit.name }}
                      </option>
                    </select>
                    <span v-if="form.errors.unit_id" class="mt-2 text-red-500">
                      {{ form.errors.unit_id }}
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
                      placeholder="Enter stock quantity"
                      required
                    />
                    <span
                      v-if="form.errors.stock_quantity"
                      class="mt-2 text-red-500"
                    >
                      {{ form.errors.stock_quantity }}
                    </span>
                  </div>


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

                  <div class="w-full ">
                    <label
                      for="discount"
                      class="block text-sm font-medium text-gray-300"
                    >
                      Discount (%):
                    </label>
                    <input
                      type="text"
                      id="discount"
                      v-model="form.discount"
                      @blur="updateDiscountedPrice"
                      class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      placeholder="Enter discount percentage"
                    />
                  </div>
                  <div class="w-full  ">
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
                  </div>
                </div>
                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <label
                      for="image"
                      class="block text-sm font-medium text-gray-300"
                      >Image:</label
                    >
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
                >
                  Save
                </button>
                <button
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="
                    () => {
                      emit('update:open', false);
                    }
                  "
                  type="button"
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
import { ref, computed, watch } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["update:open"]);

const isPharma = computed(() => import.meta.env.VITE_APP_NAME === "pharma");


 
// Define props
const { open, categories, colors, suppliers, sizes, units ,selectedProduct } =
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
    units: {
      type: Array,
      required: true,
    },
    selectedProduct: {
      type: Object,
      default: null,
    },
  });

const form = useForm({
  category_id: "",
  supplier_id: "",
  name: "",
  code: "",
  size_id: "",
  color_id: "",
  cost_price: null,
  discount: 0,
  discounted_price: null,
  selling_price: null,
  stock_quantity: null,
  barcode: "",
  image: null, // For file upload
  expire_date: null,
  batch_no: "",
  purchase_date: null,
   unit_id: "",
   type: "Normal",

});

const isDialogOpen = ref(false);
const dialogType = ref("size");

// Form states for Size and Product
const sizeForm = useForm({
  sizeName: "",
});

const colorForm = useForm({
  colorName: "",
});

const categoryForm = useForm({
  categoryName: "",
  parent_id: "",
});

// Functions to handle dialog open/close
const openDialog = (type) => {
  dialogType.value = type;
  isDialogOpen.value = true;
};

const closeDialog = () => {
  isDialogOpen.value = false;
};

const successMessage = ref("");

// Utility function to limit to 2 decimal points
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

const handleImageUpload = (event) => {
  form.image = event.target.files[0]; // Set the file to the form object
};

const submit = () => {
  form.post("/products", {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product created successfully!");
      form.reset(); // Reset form fields after successful submission
      emit("update:open", false);
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};

const submitSize = () => {
  sizeForm.post("/sizes", {
    onSuccess: () => {
      successMessage.value = "Size created successfully!";
      sizeForm.sizeName = ""; // Clear the sizeName field
      closeDialog();
    },
    onError: (errors) => {
      console.error("Size form submission failed:", errors);
    },
  });
};

const submitColor = () => {
  colorForm.post("/colors", {
    onSuccess: () => {
      successMessage.value = "Color created successfully!";
      colorForm.colorName = "";
      closeDialog();
    },
    onError: (errors) => {
      console.error("Color form submission failed:", errors);
    },
  });
};

const submitCategory = () => {
  categoryForm.post("/categories", {
    onSuccess: () => {
      successMessage.value = "Category created successfully!";
      categoryForm.categoryName = "";
      closeDialog();
    },
    onError: (errors) => {
      console.error("Category form submission failed:", errors);
    },
  });
};
</script>
