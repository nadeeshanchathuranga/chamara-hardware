
<style lang="css">
.pagination-disabled {
  color: rgb(37 99 235);
  transition: all 0.5s ease;
  background: rgb(229 231 235 / var(--tw-bg-opacity));
}
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  font-size: 14px;
  float: right;
}

.pagination a:first-child,
.pagination a:last-child {
  padding: 8px 16px;
}
</style>
<template>
  <Head title="Products" />
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16"
  >
    <!-- Include the Header -->
    <Header />
    <div class="w-full md:w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4"></div>
        <p class="text-3xl italic font-bold text-black">
          <span class="px-4 py-1 mr-3 text-white bg-black rounded-xl">{{
            totalProducts
          }}</span>
          <span class="text-xl">/ Total Products</span>
        </p>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center space-x-4">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-14 h-14" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">
            Products
          </p>
        </div>
        <!-- <p
          :disabled="!HasRole(['Admin'])"
          @click="
            () => {
              if (HasRole(['Admin'])) {
                isCreateModalOpen = true;
              }
            }
          "
          :class="{
            'cursor-not-allowed opacity-50': !HasRole(['Admin']),
            'cursor-pointer': HasRole(['Admin']),
          }"
          class="px-12 py-4 text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl"
        >
          <i class="pr-4 ri-add-circle-fill"></i> Add More Productss
        </p> -->

        <p
          @click="
            () => {
              if (HasRole(['Admin'])) {
                isCreateModalOpen = true;
              }
            }
          "
          :class="
            HasRole(['Admin'])
              ? 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 rounded-xl'
              : 'md:px-12 py-4 px-4 md:text-2xl font-bold tracking-wider text-white uppercase bg-blue-600 cursor-not-allowed rounded-xl'
          "
          :title="
            HasRole(['Admin'])
              ? ''
              : 'You do not have permission to add more Products'
          "
        >
          <i class="md:pr-4 ri-add-circle-fill"></i> Add More Product
        </p>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Search Input on the Left -->
        <div class="md:w-1/4 w-full">
          <input
            v-model="search"
            @input="performSearch"
            type="text"
            placeholder="Search ..."
            class="w-full custom-input"
          />
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Search Input on the Left -->
        <!-- <div class="w-1/3">
          <input
            v-model="search"
            @input="performSearch"
            type="text"
            placeholder="Search ..."
            class="w-full custom-input"
          />
        </div> -->

        <!-- Filter Dropdowns on the Right -->
        <div class="flex justify-end w-full space-x-2">
          <select
            v-model="selectedCategory"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
          >
            <option value="">Filter by Category</option>
            <option
              v-for="category in props.allcategories"
              :key="category.id"
              :value="category.id"
            >
              {{
                category.hierarchy_string
                  ? category.hierarchy_string + " ----> " + category.name
                  : category.name
              }}
            </option>
          </select>

          <!-- Stocks Filter -->
          <select
            v-model="stockStatus"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
          >
            <option value="">Filter by Stock</option>
            <option value="in">In Stock</option>
            <option value="out">Out of Stock</option>
          </select>

          <!-- Price Filter -->
          <select
            v-model="sort"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg cursor-pointer custom-select"
          >
            <option value="">Filter by Price</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>

          <!-- Color Filter -->
          <select
            v-model="color"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
          >
            <option value="">Select Color</option>
            <option
              v-for="colorOption in props.colors"
              :key="colorOption.id"
              :value="colorOption.name"
            >
              {{ colorOption.name }}
            </option>
          </select>

          <!-- Size Filter -->
          <select
            v-model="size"
            @change="applyFilters"
            class="px-6 py-3 text-xl font-normal tracking-wider text-blue-600 bg-white rounded-lg custom-select"
          >
            <option value="">Select Size</option>
            <option
              v-for="sizeOption in props.sizes"
              :key="sizeOption.id"
              :value="sizeOption.name"
            >
              {{ sizeOption.name }}
            </option>
          </select>

          <Link
            href="/products"
            class="px-6 py-3 text-xl font-normal tracking-wider text-white text-center bg-blue-600 rounded-lg custom-select"
          >
            Reset
          </Link>
        </div>
      </div>

      <div class="grid md:grid-cols-4 grid-cols-1 gap-8">
        <template v-if="products.data.length > 0">
          <div
            v-for="product in products.data"
            :key="product.id"
            class="space-y-4 text-white transition-transform duration-300 transform bg-black border-4 border-black shadow-lg hover:-translate-y-4"
          >
            <div
              @click="
                () => {
                  openViewModal(product);
                }
              "
              class="cursor-pointer"
            >
              <!-- <img
                :src="`/${product.image}`"
                alt="Product Image"
                class="object-cover w-full h-64"
              /> -->

              <img
                :src="
                  product.image
                    ? `/${product.image}`
                    : '/images/placeholder.jpg'
                "
                alt="Product Image"
                class="object-cover w-full h-64"
              />
            </div>
            <div class="px-2 py-4 space-y-4">
              <div
                class="flex items-start space-x-3 justify-between text-[11px] font-bold tracking-wide"
              >
                <p class="text-justify">{{ product.name || "N/A" }}</p>
                <p
                  class="px-3 text-white bg-green-700 py-2 rounded-full flex items-center"
                >
                  {{ product.selling_price || "N/A" }}
                </p>
              </div>

              <div class="flex justify-center space-x-2 items-start w-full">
                <div class="flex space-x-1 text-gray-400">
                  <p class="font-bold">Color:</p>

                  <p>{{ product.color?.name || "N/A" }}</p>
                </div>

                <div class="flex space-x-1 text-gray-400">
                  <p class="font-bold">Size:</p>
                  <p>
                    {{ product.size?.name || "N/A" }}
                  </p>
                </div>
              </div>

              <div class="flex items-center justify-center w-full space-x-4">
                <p
                  class="flex items-center space-x-2 text-justify text-gray-400"
                >
                  Supplier :

                  <b> &nbsp; {{ product.supplier?.name || "N/A" }} </b>
                </p>
              </div>
              <div class="flex items-center justify-between">
                <p
                  v-if="product.stock_quantity > 0"
                  class="text-xl font-bold tracking-wider text-green-500"
                >
                  <i class="ri-checkbox-blank-circle-fill"></i> In Stock ({{ product.stock_quantity }})
                </p>
                <p v-else class="text-xl font-bold tracking-wider text-red-500">
                  <i class="ri-checkbox-blank-circle-fill"></i> Out of Stock
                </p>

                <div class="flex space-x-4">
                  <button
                    :disabled="!HasRole(['Admin'])"
                    @click="
                      () => {
                        if (HasRole(['Admin'])) {
                          openDuplicateModal(product);
                        }
                      }
                    "
                    :class="{
                      'cursor-not-allowed opacity-50': !HasRole(['Admin']),
                      'cursor-pointer hover:bg-green-600 hover:text-white':
                        HasRole(['Admin']),
                    }"
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full"
                  >
                    <i class="ri-file-copy-2-line"></i>
                  </button>

                  <button
                    :disabled="!HasRole(['Admin'])"
                    @click="
                      () => {
                        if (HasRole(['Admin'])) {
                          openEditModal(product);
                        }
                      }
                    "
                    :class="{
                      'cursor-not-allowed opacity-50': !HasRole(['Admin']),
                      'cursor-pointer hover:bg-green-600 hover:text-white':
                        HasRole(['Admin']),
                    }"
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full"
                  >
                    <i class="ri-pencil-line"></i>
                  </button>
                  <button
                    :disabled="!HasRole(['Admin'])"
                    @click="
                      () => {
                        if (HasRole(['Admin'])) {
                          openDeleteModal(product);
                        }
                      }
                    "
                    :class="{
                      'cursor-not-allowed opacity-50': !HasRole(['Admin']),
                      'cursor-pointer hover:bg-green-600 hover:text-white':
                        HasRole(['Admin']),
                    }"
                    class="flex items-center justify-center w-10 h-10 text-gray-800 transition duration-200 bg-gray-100 rounded-full"
                  >
                    <i class="ri-delete-bin-line"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="col-span-4 text-center text-gray-500">
            <p class="text-center text-red-500 text-[17px]">
              No Products Available
            </p>
          </div>
        </template>
      </div>

      <div class="flex space-x-2 pagination">
        <!-- Prev Button -->
        <span
          v-if="products.links[0]"
          @click.prevent="navigateTo(products.links[0].url)"
          :class="[
            'pagination-btn',
            { 'pagination-disabled': !products.links[0].url },
          ]"
        >
          Previous
        </span>

        <!-- Pagination Links -->
        <span
          v-for="(link) in products.links.slice(
            1,
            products.links.length - 1
          )"
          :key="link.label"
          @click.prevent="navigateTo(link.url)"
          :class="['pagination-btn', { 'pagination-active': link.active }]"
          v-html="link.label"
        ></span>

        <!-- Next Button -->
        <span
          v-if="products.links[products.links.length - 1]"
          @click.prevent="
            navigateTo(products.links[products.links.length - 1].url)
          "
          :class="[
            'pagination-btn',
            {
              'pagination-disabled':
                !products.links[products.links.length - 1].url,
            },
          ]"
        >
          Next
        </span>
      </div>
    </div>
  </div>

  <ProductCreateModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    :suppliers="suppliers"
    v-model:open="isCreateModalOpen"
  />
  <ProductUpdateModel
    :categories="allcategories"
    :colors="colors"
    :suppliers="suppliers"
    :sizes="sizes"
    v-model:open="isEditModalOpen"
    :selected-product="selectedProduct"
  />

  <ProductDuplicateModel
    :categories="allcategories"
    :colors="colors"
    :suppliers="suppliers"
    :sizes="sizes"
    v-model:open="isDuplicateModalOpen"
    :selected-product="selectedProduct"
  />

  <ProductViewModel
    :categories="allcategories"
    :colors="colors"
    :sizes="sizes"
    v-model:open="isViewModalOpen"
    :selected-product="selectedProduct"
  />
  <ProductDeleteModel
    v-model:open="isDeleteModalOpen"
    :selected-product="selectedProduct"
    @delete="deleteProduct"
  />
  <Footer />
</template>

<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, router } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";
import { defineProps, onMounted } from "vue";
import ProductCreateModel from "@/Components/custom/ProductCreateModel.vue";

import ProductDuplicateModel from "@/Components/custom/ProductDuplicateModel.vue";
import ProductUpdateModel from "@/Components/custom/ProductUpdateModel.vue";
import ProductViewModel from "@/Components/custom/ProductViewModel.vue";
import ProductDeleteModel from "@/Components/custom/ProductDeleteModel.vue";
import { debounce } from "lodash";
import { HasRole } from "@/Utils/Permissions";

const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDuplicateModalOpen = ref(false);
const isViewModalOpen = ref(false);
const selectedProduct = ref(null);
const isDeleteModalOpen = ref(false);

const emit = defineEmits(["update:open"]);

const openEditModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isEditModalOpen.value = true; // Open the edit modal
};

const openDuplicateModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isDuplicateModalOpen.value = true; // Open the edit modal
};

const openViewModal = (product) => {
  selectedProduct.value = product; // Set the selected product
  isViewModalOpen.value = true; // Open the view modal
};

const openDeleteModal = (product) => {
  selectedProduct.value = product;
  isDeleteModalOpen.value = true;
};

const props = defineProps({
  products: Object,
  categories: Array,
  suppliers: Array,
  colors: Array,
  sizes: Array,
  allcategories: Array,
  totalProducts: Number,
  search: String,
  sort: String,
  color: String,
  size: String,
  stockStatus: String,
  selectedCategory: String,
});

const search = ref(props.search || "");
const sort = ref(props.sort || "");
const color = ref(props.color || "");
const size = ref(props.size || "");
const suppliers = ref(props.suppliers || "");
const stockStatus = ref(props.stockStatus || "");
const selectedCategory = ref(props.selectedCategory || "");

const performSearch = debounce(() => {
  applyFilters();
}, 500);

const applyFilters = (page) => {
  router.get(
    route("products.index"),
    {
      search: search.value,
      sort: sort.value,
      color: color.value,
      size: size.value,
      stockStatus: stockStatus.value,
      selectedCategory: selectedCategory.value,
    },
    { preserveState: true }
  );
};

onMounted(() => {
  // console.log("Products:", props.products);
  // console.table(props.products);
});
const showModal = ref(false);
const form = useForm({});

const openModal = (id) => {
  productToDelete.value = id;
  showModal.value = true;
};
const deleteProduct = (id) => {
  const form = useForm({});
  form.delete(`/products/${id}`, {
    onSuccess: () => {
      isDeleteModalOpen.value = false; // Close the modal on success
    },
    onError: (errors) => {
      console.error("Delete failed:", errors);
    },
  });
};
const navigateTo = (url) => {
  if (!url) return; // Avoid null or undefined URLs

  // Extract the `page` parameter from the URL
  const urlParams = new URLSearchParams(
    new URL(url, window.location.origin).search
  );
  const page = urlParams.get("page");

  // Use Inertia's router.get with current filters
  router.get(
    route("products.index"),
    {
      page, // Add the page parameter
      search: search.value,
      sort: sort.value,
      color: color.value,
      size: size.value,
      stockStatus: stockStatus.value,
      selectedCategory: selectedCategory.value,
    },
    {
      preserveState: true, // Maintain the current state
      preserveScroll: true, // Prevent scroll reset
    }
  );
};
</script>


