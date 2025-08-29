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
            <button
              @click="$emit('update:open', false)"
              class="absolute text-2xl text-white top-4 right-4 hover:text-gray-300"
              aria-label="Close"
            >
              &times;
            </button>

            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white">
              Add Employee
            </DialogTitle>

            <form @submit.prevent="submit">
              <!-- Modal Form -->
              <div class="mt-6 space-y-4 text-left">
                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Employee Name:</label
                  >
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

                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Address:</label
                  >
                  <input
                    v-model="form.address"
                    type="text"
                    id="address"
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <span v-if="form.errors.address" class="mt-4 text-red-500">
                    {{ form.errors.address }}
                  </span>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Email:</label
                  >
                  <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                  />
                  <span v-if="form.errors.email" class="mt-4 text-red-500">
                    {{ form.errors.email }}
                  </span>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-300"
                    >Phone:</label
                  >
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
                  type="button"
                  @click="$emit('update:open', false)"
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
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["update:open"]);

// The `open` prop controls the visibility of the modal
defineProps({
  open: {
    type: Boolean,
    required: true,
  },
  employees: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  name: "",
  employee_id: "",
  address: "",
  email: "",
  phone: "",
});

const submit = () => {
  form.post("/employees", {
    onSuccess: () => {
      form.reset();
      emit("update:open", false);
    },
  });
};
</script>