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
        <div class="fixed inset-0 transition-opacity bg-opacity-75" />
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
            class="bg-white border-1 border-gray-600 rounded-[20px] shadow-xl max-w-md w-full p-6 text-center"
          >
            <!-- Confirmation Message -->
            <p class="text-[15px] text-center text-gray-700">
              Are you sure you want to delete this Coupon? This action cannot be
              undone.
            </p>

            <!-- Modal Buttons -->
            <div class="mt-6 space-x-4">
              <button
                class="px-6 py-2 text-[15px] text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                @click="
                  () => {
                    playClickSound();
                    emit('update:open', false);
                  }
                "
              >
                Cancel
              </button>

              <button
                class="px-6 py-2 text-[15px] text-white bg-red-600 rounded hover:bg-red-700"
                @click.prevent="
                  () => {
                    playClickSound();
                    deleteItem();
                  }
                "
              >
                Delete
              </button>
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

// Props for the modal
const { open, selectedCoupon } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  selectedCoupon: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

// Form for handling deletion
const form = useForm({});

// Delete the selected category
const deleteItem = () => {
  if (!selectedCoupon?.id) return;

  form.delete(`/coupons/${selectedCoupon.id}`, {
    onSuccess: () => {
      emit("update:open", false); // Close the modal on success
    },
    onError: (errors) => {
      console.error("Delete failed:", errors);
    },
  });
};
</script>
