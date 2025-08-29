<template>

    <Head title="CompanyInfo" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16">
        <!-- Include the Header -->
        <Header />

        <!-- Main Content -->
        <div class="w-full md:w-5/6 py-12 space-y-24">
            <div class="flex items-center justify-between">
                <!-- Back Button and Title -->
                <div class="flex items-center space-x-4">
                    <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" alt="Back" />
                    </Link>
                    <p class="text-4xl font-bold tracking-wide text-black uppercase">
                        Company Info
                    </p>
                </div>
            </div>

            <!-- Company Info Form -->
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <!-- Company Name Input -->
                        <div class="flex flex-col">
                            <label for="name" class="text-xl font-medium text-gray-700">Company Name</label>
                            <input id="name" v-model="form.name" type="text"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter company name" :class="{ 'border-red-500': form.errors.name }" />
                            <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                        </div>



                        <!-- <div class="flex flex-col">
                            <label for="phone" class="text-xl font-medium text-gray-700">Company Phone</label>



                            <input id="phone" v-model="form.phone" type="text"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter company phone" :class="{ 'border-red-500': form.errors.phone }" />
                            <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
                        </div> -->




                        <div class="flex flex-row gap-4">
  <!-- Left Phone Number -->
  <div class="flex flex-col w-1/2">
    <label for="address" class="text-xl font-medium text-gray-700">Company Address</label>
                            <input id="address" v-model="form.address" type="text"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter company address" :class="{ 'border-red-500': form.errors.address }" />
                            <p v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}
                            </p>
  </div>

  <!-- Right Phone Number -->
  <div class="flex flex-col w-1/2">
    <label for="email" class="text-xl font-medium text-gray-700">Company Email</label>
                            <input id="email" v-model="form.email" type="text"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter company email" :class="{ 'border-red-500': form.errors.email }" />
                            <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</p>
  </div>
</div>














                        <div class="flex flex-row gap-4">
  <!-- Left Phone Number -->
  <div class="flex flex-col w-1/2">
    <label for="phone" class="text-xl font-medium text-gray-700">Company Phone 1</label>
    <input
      id="phone"
      v-model="form.phone"
      type="text"
      class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter company phone 1"
      :class="{ 'border-red-500': form.errors.phone }"
    />
    <p v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</p>
  </div>

  <!-- Right Phone Number -->
  <div class="flex flex-col w-1/2">
    <label for="phone2" class="text-xl font-medium text-gray-700">Company Phone 2</label>
    <input
      id="phone2"
      v-model="form.phone2"
      type="text"
      class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter company phone 2"
      :class="{ 'border-red-500': form.errors.phone2 }"
    />
    <p v-if="form.errors.phone2" class="text-red-500 text-sm mt-1">{{ form.errors.phone2 }}</p>
  </div>
</div>




                        <div class="flex flex-col">
                            <label for="website" class="text-xl font-medium text-gray-700">Company Website</label>
                            <input id="website" v-model="form.website" type="text"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter company website" :class="{ 'border-red-500': form.errors.website }" />
                            <p v-if="form.errors.website" class="text-red-500 text-sm mt-1">{{ form.errors.website }}
                            </p>
                        </div>










                        <div class="w-full md:w-6/12">
                            <label class="block text-sm font-medium text-white"> Logo:</label>
                            <div class="mt-2">
                                <!-- Display Current Logo -->
                                <img v-if="form.logo" :src="`${form.logo}`" alt="companyInfo logo" class="rounded-lg" />
                                <p v-else class="text-sm text-gray-500">No logo available</p>
                            </div>

                            <!-- File Input -->
                            <input type="file" id="logo" @change="handleImageUpload"
                                class="w-full px-4 py-2 mt-2 text-white bg-gray-800 rounded-md focus:outline-none focus:ring focus:ring-blue-600" />

                            <!-- Error Message -->
                            <span v-if="form.errors.logo" class="mt-2 text-red-500">
                                {{ form.errors.logo }}
                            </span>
                        </div>








                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button class="px-8 py-2 text-2xl text-white bg-blue-600 rounded hover:bg-blue-700" type="submit">
                                Update Info
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <Footer />
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue";



const { companyInfo } = defineProps({
    companyInfo: Object,
});

const form = useForm({
    name: "",
    address: "",
    phone: "",
    phone2: "",
    email: "",
    website: "",
    logo: null,
});

// Handle file input for the image upload
const handleImageUpload = (event) => {
    form.logo = event.target.files[0];
};

// Watch for selectedCompanyInfo prop and update form values accordingly
watch(
    () => companyInfo,
    (newValue) => {
        if (newValue) {
            form.name = newValue.name || "";
            form.address = newValue.address || "";
            form.phone = newValue.phone || "";
            form.phone2 = newValue.phone2 || "";
            form.email = newValue.email || "";
            form.website = newValue.website || "";
            form.logo = newValue.logo || null;
        } else {
            form.reset(); // Reset form if no companyInfo selected
        }

    },
    { immediate: true }
);



// Handle form submission
const submit = () => { // Debugging line
    if (!companyInfo) {
        console.error("No company information selected.");
        return;
    }

    form.post(`/company-info/${companyInfo.id}`, {
        onSuccess: () => {

        },
        onError: () => {
            console.error("Form submission failed:", errors);
            // Handle errors here if needed
        },
    });
};

</script>
