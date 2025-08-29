
<template>
  <div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="mb-4 text-2xl font-bold text-gray-700">Product Details</h1>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      <!-- Name -->
      <div>
        <span class="font-medium text-gray-600">Name:</span>
        <p class="text-gray-800">{{ product.name || 'N/A' }}</p>
      </div>

      <!-- Category -->
      <div>
        <span class="font-medium text-gray-600">Category:</span>
        <p class="text-gray-800">{{ product.category?.name || 'N/A' }}</p>
      </div>

      <!-- Supplier -->
      <!-- <div>
        <span class="font-medium text-gray-600">Supplier:</span>
        <p class="text-gray-800">{{ product.supplier?.name || 'N/A' }}</p>
      </div> -->

      <!-- Description -->
      <!-- <div>
        <span class="font-medium text-gray-600">Description:</span>
        <p class="text-gray-800">{{ product.description || 'No description available' }}</p>
      </div> -->

      <!-- Size -->
      <div>
        <span class="font-medium text-gray-600">Size:</span>
        <p class="text-gray-800">{{ product.size?.name || 'N/A' }}</p>
      </div>

      <!-- Color -->
      <div>
        <span class="font-medium text-gray-600">Color:</span>
        <p class="text-gray-800">{{ product.color?.name  || 'N/A' }}</p>
      </div>

      <!-- Cost Price -->
      <div>
        <span class="font-medium text-gray-600">Cost Price:</span>
        <p class="text-gray-800">{{ product.cost_price || 'N/A' }}</p>
      </div>

      <!-- Selling Price -->
      <div>
        <span class="font-medium text-gray-600">Selling Price:</span>
        <p class="text-gray-800">{{ product.selling_price || 'N/A' }}</p>
      </div>

      <!-- Stock Quantity -->
      <div>
        <span class="font-medium text-gray-600">Stock Quantity:</span>
        <p class="text-gray-800">{{ product.stock_quantity || 'N/A' }}</p>
      </div>

      <!-- Barcode -->
      <div>
        <span class="font-medium text-gray-600">Barcode:</span>
        <p class="text-gray-800">{{ product.barcode || 'N/A' }}</p>
      </div>

      <!-- Product Image -->
      <div>
        <span class="font-medium text-gray-600">Image:</span>
        <div v-if="product.image">
          <img
            :src="`/${product.image}`"
            alt="Product Image"
            class="w-full max-w-sm mt-2 rounded-lg"
          />
        </div>
        <p v-else class="text-gray-800">No image available</p>
      </div>
    </div>
  </div>
</template>










<script setup>
import { defineProps, onMounted } from "vue";

const props = defineProps({
  product: Object,
});

onMounted(() => {
  console.log("Product:", props.product);
});
</script>
