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
            <!-- Modal Title -->
            <DialogTitle class="text-xl font-bold text-white">
              Add Supplier
            </DialogTitle>
        <form @submit.prevent="submit" enctype="multipart/form-data">
  <!-- Modal Form -->
  <div class="grid grid-cols-2 gap-6 mt-6 text-left">
    <!-- Supplier Name -->
    <div>
      <label class="block text-sm font-medium text-gray-300">
        Supplier Name:
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

    <!-- Contact -->
    <div>
      <label class="block text-sm font-medium text-gray-300">
        Contact:
      </label>
      <input
        v-model="form.contact"
        type="text"
        id="contact"
        required
         oninput="this.value = this.value.replace(/[^0-9]/g, '');"
        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
      />
      <span v-if="form.errors.contact" class="mt-4 text-red-500">
        {{ form.errors.contact }}
      </span>
    </div>

    <!-- Email -->
    <div>
      <label class="block text-sm font-medium text-gray-300">
        Email:
      </label>
      <input
        v-model="form.email"
        type="email"
        id="email"
        required
        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
      />
      <span v-if="form.errors.email" class="mt-4 text-red-500">
        {{ form.errors.email }}
      </span>
    </div>

    <!-- Address -->
    <div>
      <label class="block text-sm font-medium text-gray-300">
        Address:
      </label>
      <input
        v-model="form.address"
        type="text"
        id="address"
        required
        class="w-full px-4 py-2 mt-2 text-black rounded-md focus:outline-none focus:ring focus:ring-blue-600"
      />
      <span v-if="form.errors.address" class="mt-4 text-red-500">
        {{ form.errors.address }}
      </span>
    </div>

    <!-- Image -->
    <div class="col-span-2">
      <label class="block text-sm font-medium text-gray-300">
        Supplier Image:
      </label>

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

  <!-- Modal Buttons -->
  <div class="mt-6 space-x-4 text-center">
    <button @click="() => { playClickSound();}"
      class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
      type="submit"
    >
      Save
    </button>
    <button
      class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
    @click="() => { playClickSound(); emit('update:open', false); }"
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

const playClickSound = () => {
  const clickSound = new Audio("/sounds/click-sound.mp3");
  clickSound.play();
};

const emit = defineEmits(["update:open"]);

defineProps({
  open: {
    type: Boolean,
    required: true,
  },
});

const form = useForm({
  name: "",
  contact: "",
  email: "",
  address: "",
  image: null,
});


const handleImageUpload = (event) => {
  form.image = event.target.files[0]; // Set the file to the form object
};

const submit = () => {
  form.post("/suppliers", {
    onSuccess: () => {
      form.reset();
      emit("update:open", false);
    },
  });
};
</script>
