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
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" />
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
            class="w-full max-w-md p-6 bg-white border border-gray-300 shadow-xl rounded-xl"
          >
            <!-- Confirmation Message -->
            <p class="text-[15px] text-center text-gray-700">
              Are you sure you want to delete this Product? This action cannot
              be undone.
            </p>

            <!-- Modal Buttons -->
            <div class="flex justify-center mt-6 space-x-4">
              <button
                class="px-6 py-2 text-[15px] text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
              @click="() => { playClickSound(); emit('update:open', false); }"
              >
                Cancel
              </button>

              <button
                class="px-6 py-2 text-[15px] text-white bg-red-600 rounded hover:bg-red-700"
                  @click.prevent="() => { playClickSound(); deleteItem(); }"
                :disabled="form.processing"
              >
                Delete
              </button>
            </div>

            <!-- Error Message -->
            <p
              v-if="form.errors && Object.keys(form.errors).length"
              class="mt-4 text-sm text-center text-red-500"
            >
              {{ form.errors[0] || "An error occurred while deleting the product." }}
            </p>
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
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";


const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);


const { open, selectedProduct } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  selectedProduct: {
    type: Object,
    default: null,
  },
});


const form = useForm({});

// Delete the selected product
const deleteItem = () => {
  if (!selectedProduct?.id) {
    console.error("No product selected for deletion");
    return;
  }

  form.delete(`/products/${selectedProduct.id}`, {
    onSuccess: () => {
      emit("update:open", false); // Close the modal on success
    },
    onError: (errors) => {
      console.error("Delete failed:", errors);
    },
  });
};
</script>
