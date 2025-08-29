<template>
    <TransitionRoot as="template" :show="open">
      <Dialog class="relative z-10" @close="$emit('update:open', false)">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
        </TransitionChild>
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
                Add Reason For
              </DialogTitle>
              <form @submit.prevent="submit">
                <!-- Modal Form -->
                <div class="mt-6 space-y-4 text-left">
                  <div class="flex items-center gap-8 mt-6">
                    <div class="w-full">
                        <div class="mt-4">

                  <label class="block text-sm font-medium text-gray-300">Reason:</label>
                  <textarea
                    v-model="form.reason"
                    id="reason"
                    rows="4"
                    required
                    class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
                    placeholder="Enter reason"
                  ></textarea>
                  <span v-if="form.errors.reason" class="text-sm text-red-600">{{ form.errors.reason }}</span>
                </div>
                    </div>


                    <input type="hidden" :value="selectedStock?.id" disabled class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" />


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
           @click="() => {   emit('update:open', false); }"
                  type="button"
                >
                  Cancel
                </button>
              </div>

                </div>


              </form>
            </DialogPanel>
          </TransitionChild>




        </div>
      </Dialog>
    </TransitionRoot>
  </template>

  <script setup>
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from "@headlessui/vue";
  import { ref, watch } from "vue";
  import { useForm } from "@inertiajs/vue3";

  const emit = defineEmits(["update:open"]);
  const { open, selectedStock } = defineProps({
    open: Boolean,
    selectedStock: Object,
  });

  const form = useForm({
    stock_id: null,
    reason: "",
  });

  watch(
    () => selectedStock,
    (newStock) => {
      if (newStock) {
        form.stock_id = newStock.id || null; // Populate reason_id
        form.reason = newStock.reason || ""; // Populate reason if it exist
      }
    },
    { immediate: true }
  );

  const submit = () => {
    if (!selectedStock?.id) {
      console.error("No stock selected");
      return;
    }

    form.put(`/stock-transition/${selectedStock?.id }`, {
      onSuccess: () => {
        form.reset();
        emit("update:open", false);
      },
      onError: () => {
        console.error("Failed to update");
      },
    });
  };
  </script>
