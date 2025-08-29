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
            class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl max-w-md w-full p-6 text-center"
          >
            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white">
              Edit Category
            </DialogTitle>
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <!-- Category Name -->
                <div>
                  <label class="block text-sm font-medium text-gray-300">
                    Category Name:
                  </label>
                  <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    required
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <span v-if="form.errors.name" class="mt-4 text-red-500">
                    {{ form.errors.name }}
                  </span>
                </div>

                <!-- Parent Category Dropdown -->
                <div>
                  <label class="block text-sm font-medium text-gray-300">
                    Parent Category:
                  </label>
                  <select
                    v-model="form.parent_id"
                    id="parent_id"
                    class="w-full px-4 py-2 mt-2 text-black bg-white rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  >
                    <option value="">No Parent</option>
                    <option
                      v-for="category in filteredCategories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{  (category.hierarchy_string ?   category.hierarchy_string + " ----> " + category.name : category.name) }}
                    </option>
                  </select>
                  <span v-if="form.errors.parent_id" class="mt-4 text-red-500">
                    {{ form.errors.parent_id }}
                  </span>
                </div>
              </div>

              <!-- Modal Buttons -->
              <div class="mt-6 space-x-4">
                <button
                  class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                  type="submit" @click="() => { playClickSound();}"
                >
                  Save
                </button>
                <button
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
           @click="() => { playClickSound(); emit('update:open', false); }"
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
import { ref, watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

const { open, categories, selectedCategory } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  selectedCategory: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

const form = useForm({
  name: "",
  parent_id: "",
});

// Computed property to filter categories
const filteredCategories = computed(() =>
  categories.filter((category) => category.id !== selectedCategory?.id)
);

// Watch for selectedCategory changes
watch(
  () => selectedCategory,
  (newValue) => {
    if (newValue) {
      form.name = newValue.name || ""; // Populate name
      form.parent_id = newValue.parent?.id || "" // Populate parent_id
    }
  },
  { immediate: true } // Run immediately when the component is mounted
);

// Submit form
const submit = () => {
  form.put(`/categories/${selectedCategory.id}`, {
    onSuccess: () => {
      form.reset();
      emit("update:open", false); // Close the modal
    },
  });
};
</script>
