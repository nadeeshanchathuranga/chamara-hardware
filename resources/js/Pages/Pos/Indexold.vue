<template>
  <Banner />
  <div
    class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-36"
  >
    <!-- Include the Header -->
    <Header />

    <div class="w-5/6 py-12 space-y-16">
      <div class="flex items-center justify-between">
        <div class="w-full flex space-x-4">
          <a
            href="./includes/dash_page.php"
            class="text-3xl rounded-full border-2 border-black p-1 text-black"
          >
            <p><i class="ri-arrow-left-line"></i></p>
          </a>
          <p class="text-4xl font-bold uppercase tracking-wide text-black">
            PoS
          </p>
        </div>
        <div class="w-full flex justify-between items-center space-x-4">
          <p class="text-3xl font-bold tracking-wide text-black">
            Order ID : 202234344
          </p>
          <p class="text-3xl text-black"><i class="ri-restart-line"></i></p>
        </div>
      </div>
      <div class="w-full flex gap-4">
        <div class="w-1/3 flex flex-col">
          <div class="w-full flex flex-col">
            <div class="p-16 bg-black shadow-lg space-y-8 rounded-3xl">
              <p class="text-5xl text-white font-bold mb-4">Customer Details</p>
              <div class="mb-3">
                <input
                  type="text"
                  placeholder="Enter Customer Name"
                  class="w-full px-4 py-4 text-black placeholder-black rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="flex mb-3 gap-2 text-black">
                <select
                  class="w-[60px] px-2 py-2 bg-white placeholder-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option>+94</option>
                  <option>+1</option>
                  <option>+44</option>
                </select>
                <input
                  type="text"
                  placeholder="Enter Customer Contact Number"
                  class="flex-grow px-4 py-4 bg-white text-black placeholder-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="text-black">
                <input
                  type="email"
                  placeholder="Enter Customer Email"
                  class="w-full px-4 py-4 bg-white text-black placeholder-black rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
            </div>
          </div>
          <div
            class="w-full justify-center items-center flex flex-col pt-32 space-y-8"
          >
            <div class="w-full flex flex-col items-center space-y-4">
              <input
                type="text"
                v-model="form.barcode"
                placeholder="Enter Barcode"
                class="w-2/3 px-4 py-3 text-black placeholder-black rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              <button
                @click="submitBarcode"
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none"
              >
                Scan Barcode
              </button>
            </div>
            <img
              src="/images/Fading wheel.gif"
              class="h-32 w-32 object-cover rounded-full"
            />
            <p class="text-3xl text-black">
              Bar Code Scanner is in Progress...
            </p>
          </div>
        </div>
        <div class="w-2/3 flex flex-col border-4 border-black p-8 rounded-3xl">
          <div class="w-full flex flex-col justify-center items-start px-12">
            <h2 class="text-5xl text-black font-bold">Billing Details</h2>
            <div class="w-full flex py-4 items-center border-b border-black">
              <div class="flex w-1/6">
                <img
                  src="/images/temp.jpg"
                  class="h-16 w-16 object-cover rounded-lg"
                />
              </div>
              <div
                class="flex flex-col justify-start items-start space-y-4 w-4/6"
              >
                <p class="text-3xl text-black">
                  Ladies Sleeveless Dress / Black Color - S
                </p>
                <div class="flex w-full justify-between items-center">
                  <div class="w-full flex justify-start items-center space-x-4">
                    <p
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>
                    <p
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-8 text-black flex justify-center items-center rounded"
                    >
                      1
                    </p>
                    <p
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex justify-center items-center">
                    <p class="text-black">3500.00LKR</p>
                  </div>
                </div>
              </div>
              <div class="flex w-1/6 justify-end">
                <p
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>
            <div class="w-full flex py-4 items-center border-b border-black">
              <div class="flex w-1/6">
                <img
                  src="/images/temp.jpg"
                  class="h-16 w-16 object-cover rounded-lg"
                />
              </div>
              <div
                class="flex flex-col justify-start items-start space-y-4 w-4/6"
              >
                <p class="text-3xl text-black">
                  Ladies Sleeveless Dress / Black Color - S
                </p>
                <div class="flex w-full justify-between items-center">
                  <div class="w-full flex justify-start items-center space-x-4">
                    <p
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
                    >
                      <i class="ri-add-line"></i>
                    </p>
                    <p
                      class="bg-[#D9D9D9] border-2 border-black h-8 w-8 text-black flex justify-center items-center rounded"
                    >
                      1
                    </p>
                    <p
                      class="bg-black h-8 w-8 text-white flex justify-center items-center rounded cursor-pointer"
                    >
                      <i class="ri-subtract-line"></i>
                    </p>
                  </div>
                  <div class="flex justify-center items-center">
                    <p class="text-black">3500.00LKR</p>
                  </div>
                </div>
              </div>
              <div class="flex w-1/6 justify-end">
                <p
                  class="text-3xl text-black border-2 border-black rounded-full cursor-pointer"
                >
                  <i class="ri-close-line"></i>
                </p>
              </div>
            </div>
            <div class="w-full space-y-2 pt-6">
              <div class="w-full flex justify-between items-center px-16">
                <p class="text-xl">Sub Total</p>
                <p class="text-xl">11,500.00 LKR</p>
              </div>
              <div
                class="w-full flex justify-between items-center py-2 px-16 border-b border-black pb-4"
              >
                <p class="text-xl">Discount</p>
                <p class="text-xl">1500.00 LKR</p>
              </div>
              <div class="w-full flex justify-between items-center px-16 pt-4">
                <p class="text-3xl text-black">Total</p>
                <p class="text-3xl text-black">9500.00 LKR</p>
              </div>
            </div>
            <div class="w-full flex flex-col space-y-8">
              <div
                class="w-full flex justify-center items-center space-x-8 pt-8"
              >
                <p class="text-black text-xl">Payment Method :</p>
                <div
                  class="w-[80px] h-[50px] border border-black rounded-xl flex flex-col justify-center items-center text-center"
                >
                  <p><i class="ri-cash-line"></i></p>
                  <p>Cash</p>
                </div>
                <div
                  class="w-[80px] h-[50px] border border-black font-bold tracking-wider rounded-xl text-black flex flex-col bg-yellow-500 justify-center items-center text-center"
                >
                  <p><i class="ri-bank-card-line"></i></p>
                  <p>Credit Card</p>
                </div>
              </div>
              <div class="w-full flex justify-center items-center">
                <p
                  class="cursor-pointer bg-black text-white font-bold uppercase tracking-wider w-full text-center py-4 rounded-xl text-2xl"
                >
                  <i class="ri-add-circle-fill pr-4"></i> Confirm Order
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer />
</template>
<script setup>
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";

import Banner from "@/Components/Banner.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  barcode: "", // Form field for barcode
});
const submitBarcode = () => {
  alert(`Barcode Value: ${form.barcode}`);
};
</script>
