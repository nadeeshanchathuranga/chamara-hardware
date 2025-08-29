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
            class="bg-black border-4 border-blue-600 rounded-[20px] shadow-xl w-5/6 lg:w-3/6 p-6 text-center"
          >
            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white">
              Edit Customer
            </DialogTitle>
            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300">
                        Customer Name:
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
                  </div>
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300">
                        Customer Phone:
                      </label>
                      <input
                        v-model="form.phone"
                        type="text"
                        id="phone"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.phone" class="mt-4 text-red-500">
                        {{ form.errors.phone }}
                      </span>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300">
                        Customer Email:
                      </label>
                      <input
                        v-model="form.email"
                        type="text"
                        id="email"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.email" class="mt-4 text-red-500">
                        {{ form.errors.email }}
                      </span>
                    </div>
                  </div>
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300">
                        Customer Address:
                      </label>
                      <input
                        v-model="form.address"
                        type="text"
                        id="address"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span
                        v-if="form.errors.address"
                        class="mt-4 text-red-500"
                      >
                        {{ form.errors.address }}
                      </span>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-8 mt-6">
                  <div class="w-full">
                    <div>
                      <label class="block text-sm font-medium text-gray-300">
                        Customer Loyalty Points:
                      </label>
                      <input
                        v-model="form.loyalty_points"
                        type="text"
                        id="loyalty_points"
                        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                      />
                      <span v-if="form.errors.loyalty_points" class="mt-4 text-red-500">
                        {{ form.errors.loyalty_points }}
                      </span>
                    </div>
                  </div>
                  <div class="w-full"></div>
                </div>
              </div>

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
                  class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
                  @click="
                    () => {
                      playClickSound();
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
import { ref, watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

const { open, customer, selectedCustomer } = defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  customer: {
    type: Array,
    required: true,
  },
  selectedCustomer: {
    type: Object,
    default: null, // Ensure it defaults to null
  },
});

const form = useForm({
  name: "",
  email: "",
  phone: "",
  address: "",
  loyalty_points: 0,
});

// Computed property to filter categories
const filteredCustomer = computed(() =>
  customers.filter((customer) => customer.id !== selectedCustomer?.id)
);

// Watch for selectedCategory changes
watch(
  () => selectedCustomer,
  (newValue) => {
    if (newValue) {
      form.name = newValue.name || "";
      form.email = newValue.email || "";
      form.phone = newValue.phone || "";
      form.address = newValue.address || "";
      form.loyalty_points = newValue.loyalty_points || 0;
    }
  },
  { immediate: true } // Run immediately when the component is mounted
);

// Submit form
const submit = () => {
  form.put(`/customers/${selectedCustomer.id}`, {
    onSuccess: () => {
      form.reset();
      emit("update:open", false); // Close the modal
    },
  });
};
</script>
