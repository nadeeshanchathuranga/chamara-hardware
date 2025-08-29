<template>
  <AdminLayout>
    <div class="min-h-screen p-6 bg-gray-100">
      <div class="max-w-4xl min-h-screen p-6 mx-auto bg-gray-100">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Edit Product</h1>
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Category Select -->
          <div>
            <label
              for="category_id"
              class="block text-sm font-medium text-gray-700"
              >Category</label
            >
            <select
              v-model="form.category_id"
              id="category_id"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
              <option :value="null" disabled>Select Category</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
            <span v-if="form.errors.category_id" class="text-sm text-red-500">{{
              form.errors.category_id
            }}</span>
          </div>

          <!-- Other Fields -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700"
              >Name</label
            >
            <input
              v-model="form.name"
              type="text"
              id="name"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.name" class="text-sm text-red-500">{{
              form.errors.name
            }}</span>
          </div>

          <!-- Description Input -->
          <!-- <div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea
      v-model="form.description"
      id="description"
      rows="4"
      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
    ></textarea>
    <span v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</span>
  </div> -->

          <!-- Size Select -->
          <div>
            <label for="size_id" class="block text-sm font-medium text-gray-700"
              >Size</label
            >
            <select
              v-model="form.size_id"
              id="size_id"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
              <option :value="null" disabled>Select Size</option>
              <option v-for="size in sizes" :key="size.id" :value="size.id">
                {{ size.name }}
              </option>
            </select>
            <span v-if="form.errors.size_id" class="text-sm text-red-500">{{
              form.errors.size_id
            }}</span>
          </div>

          <!-- Color Select -->
          <div>
            <label
              for="color_id"
              class="block text-sm font-medium text-gray-700"
              >Color</label
            >
            <select
              v-model="form.color_id"
              id="color_id"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
              <option :value="null" disabled>Select Color</option>
              <option v-for="color in colors" :key="color.id" :value="color.id">
                {{ color.name }}
              </option>
            </select>
            <span v-if="form.errors.color_id" class="text-sm text-red-500">{{
              form.errors.color_id
            }}</span>
          </div>

          <!-- Cost Price Input -->
          <div>
            <label
              for="cost_price"
              class="block text-sm font-medium text-gray-700"
              >Cost Price</label
            >
            <input
              v-model="form.cost_price"
              type="number"
              step="0.01"
              id="cost_price"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.cost_price" class="text-sm text-red-500">{{
              form.errors.cost_price
            }}</span>
          </div>

          <!-- Selling Price Input -->
          <div>
            <label
              for="selling_price"
              class="block text-sm font-medium text-gray-700"
              >Selling Price</label
            >
            <input
              v-model="form.selling_price"
              type="number"
              step="0.01"
              id="selling_price"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span
              v-if="form.errors.selling_price"
              class="text-sm text-red-500"
              >{{ form.errors.selling_price }}</span
            >
          </div>

          <!-- Stock Quantity Input -->
          <div>
            <label
              for="stock_quantity"
              class="block text-sm font-medium text-gray-700"
              >Stock Quantity</label
            >
            <input
              v-model="form.stock_quantity"
              type="number"
              id="stock_quantity"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span
              v-if="form.errors.stock_quantity"
              class="text-sm text-red-500"
              >{{ form.errors.stock_quantity }}</span
            >
          </div>

          <!-- Barcode Input -->
          <div>
            <label for="barcode" class="block text-sm font-medium text-gray-700"
              >Barcode</label
            >
            <input
              v-model="form.barcode"
              type="text"
              id="barcode"
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.barcode" class="text-sm text-red-500">{{
              form.errors.barcode
            }}</span>
          </div>

          <!-- Supplier Select -->

          <!-- <div>
  <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
  <select
    v-model="form.supplier_id"
    id="supplier_id"
    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"

  >
    <option :value="null" disabled>Select Supplier</option>
    <option
      v-for="supplier in suppliers"
      :key="supplier.id"
      :value="supplier.id"
    >
      {{ supplier.name }}
    </option>
  </select>
  <span v-if="form.errors.supplier_id" class="text-sm text-red-500">{{ form.errors.supplier_id }}</span>
</div> -->

          <div class="flex flex-wrap gap-4">
            <!-- Old Image -->
            <div class="w-full md:w-6/12">
              <label class="block text-sm font-medium text-gray-700"
                >Current Image</label
              >
              <div class="mt-2">
                <img
                  v-if="product.image"
                  :src="`/${product.image}`"
                  alt="Product Image"
                  class="rounded-lg h-50 w-50"
                />

                <p v-else class="text-sm text-gray-500">No image available</p>
              </div>
            </div>

            <!-- New Image Upload -->
            <div class="w-full md:w-6/12">
              <label for="image" class="block text-sm font-medium text-gray-700"
                >Upload New Image</label
              >
              <input
                type="file"
                id="image"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                @change="handleImageUpload"
              />
              <span v-if="form.errors.image" class="text-sm text-red-500">{{
                form.errors.image
              }}</span>
            </div>
          </div>

          <!-- Submit Button -->
          <div>
            <button
              type="submit"
              class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Props
const props = defineProps({
  product: Object,
  categories: Array,
  colors: Array,
  //   suppliers: Array,
  sizes: Array,
});

// Initialize form with old values
const form = useForm({
  category_id: props.product.category_id || null,
  name: props.product.name || "",
  //   description: props.product.description || '',
  size_id: props.product.size_id || "",
  color_id: props.product.color_id || "",
  cost_price: props.product.cost_price || null,
  selling_price: props.product.selling_price || null,
  stock_quantity: props.product.stock_quantity || null,
  barcode: props.product.barcode || "",
  //   supplier_id: props.product.supplier_id || null,
  image: null,
});

const handleImageUpload = (event) => {
  form.image = event.target.files[0];
};

const submit = () => {
  form.post(`/products/${props.product.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      console.log("Product updated successfully!");
    },
    onError: (errors) => {
      console.error("Form submission failed:", errors);
    },
  });
};
</script>
