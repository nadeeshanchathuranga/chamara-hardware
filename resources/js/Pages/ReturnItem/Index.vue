<!-- <template>

    <Head title="Return Bill" />
    <Banner />
    <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 md:px-36 px-16">
        <Header />
        <div class="w-full md:w-5/6 py-12 space-y-24">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <Link href="/">
                    <img src="/images/back-arrow.png" class="w-14 h-14" alt="Back" />
                    </Link>
                    <p class="text-4xl font-bold tracking-wide text-black uppercase">Return Bill</p>
                </div>
            </div>
            <!-- Return Bill Form -->
            <!-- <div class="bg-white p-8 rounded-lg shadow-lg">
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <!-- Order Code Dropdown -->
                        <!-- <div class="flex flex-col">
                            <label for="order_id" class="text-xl font-medium text-gray-700">Order Code</label>
                            <select id="order_id" v-model="form.order_id"
                                class="mt-2 p-4 border border-gray-300 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled>Select an order</option>
                                <option v-for="sale in sales" :key="sale.id" :value="sale.id">
                                    {{ sale.order_id }}
                                </option>
                            </select>
                            <p v-if="form.errors.order_id" class="text-red-500 text-sm mt-1">{{ form.errors.order_id }}
                            </p> -->
                        <!-- </div>
                        <!-- Display Selected Order Details -->
                        <!-- <div v-if="selectedSale" class="mt-6 p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-medium">Selected Order Details:</p>
                            <div class="mt-4 space-y-2">
                                <!-- <p><span class="font-bold"> ID:</span> {{ selectedSale.id }}</p> -->
                                <!-- <p><span class="font-bold">Order ID:</span> {{ selectedSale.order_id }}</p>
                                <p><span class="font-bold">Customer Name:</span> {{ selectedSale?.customer?.name ||
                                    'N/A' }}</p>

                                <p><span class="font-bold">Total Amount:</span> {{ selectedSale.total_amount }}</p>
                                <p><span class="font-bold">Discount:</span> {{ selectedSale.discount }}</p>
                                <p><span class="font-bold">Payment Method:</span> {{ selectedSale.payment_method }}</p>
                                <p><span class="font-bold">Sale Date:</span> {{ selectedSale.sale_date }}</p>
                            </div> --> 
                        <!-- </div> -->
                        <!-- Display Sale Items -->
                        <!-- <div v-if="filteredSaleItems.length" class="mt-6 p-4 border rounded-lg bg-gray-50">
                            <p class="text-lg font-medium">Items in this Sale:</p>
                            <table class="mt-4 w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2">Product ID</th>
                                        <th class="border border-gray-300 px-4 py-2">Quantity</th>
                                        <th class="border border-gray-300 px-4 py-2">Unit Price</th>
                                        <th class="border border-gray-300 px-4 py-2">Total Price</th>
                                        <th class="border border-gray-300 px-4 py-2">Reason</th>
                                        <th class="border border-gray-300 px-4 py-2">Return Date</th>
                                        <th class="border border-gray-300 px-4 py-2">Action</th>
                                    </tr>
                                </thead> -->
                                <!-- <tbody>
                                    <tr v-for="(item, index) in filteredSaleItems" :key="item.id">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <div class="pb-2"> {{ item.product.name }}</div>
                                            <img :src="item.product.image ? `/${item.product.image}` : '/images/placeholder.jpg'"
                                                alt="Product Image" class="w-20 h-20 object-cover rounded-lg" />
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ item.quantity }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ item.unit_price }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ item.total_price }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <textarea v-model="item.reason" placeholder="Enter reason for return"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input v-model="item.return_date" type="date"
                                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <button @click="removeItem(index)" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr> -->
                                <!-- </tbody>
                            </table>
                        </div> -->
                        <!-- Submit Button -->
                         
                        <!-- <div class="flex justify-center">
                            <Link href="/pos" class="px-8 py-2 text-2xl text-white bg-blue-600 rounded hover:bg-blue-700 flex items-center justify-center">
                                        Back to Pos
                            </Link> -->
                          
                            
                        <!-- </div> -->
                    <!-- </div>
                </form>
            </div>
        </div> -->
    <!-- </div> -->
    <!-- <Footer />
</template>  -->

<!-- <script setup>
import { ref, computed, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import Header from "@/Components/custom/Header.vue";
import Footer from "@/Components/custom/Footer.vue";
import Banner from "@/Components/Banner.vue"; --> 


<!-- // const selectedSale = computed(() => {
//     return props.sales.find((sale) => sale.id === form.order_id) || null;
// });

// // Form initialization
// const form = useForm({
//     order_id: "",
//     discount: 0,
//     items: [],
// }); -->
<!-- 
// watch(
//     () => form.order_id,
//     (newValue) => {
//         const sale = props.sales.find((sale) => sale.id === newValue) || null;
//         if (sale) {
//             form.discount = sale.discount || 0;
//         } else {
//             form.discount = 0; // Default if no sale is found
//         }
//         console.log(sale);
//     }
// ); -->

<!-- // import axios from "axios";

// watch(
//     () => form.order_id,
//     async (newValue) => {
//         if (!newValue) {
//             saleItemsState.value = [];
//             return;
//         } -->

<!-- //         try {
//             const response = await axios.post(route('sale.items'), { sale_id: newValue });
//             saleItemsState.value = response.data.map((item) => ({
//                 ...item,
//                 reason: "",
//                 return_date: "",
//             }));
//         } catch (error) {
//             console.error("Failed to fetch sale items:", error);
//             alert("Failed to load sale items. Please try again.");
//         } finally {
//             // isLoading.value = false;
//         }
//     }
// ); -->


<!-- // Props from backend
// const props = defineProps({
//     sales: { type: Array, required: true },
//     saleItems: { type: Array, required: true },
// });

// // Reactive list for selectedSaleItems
// const saleItemsState = ref([]); -->

<!-- // // Watch for selected order and update the state
// const filteredSaleItems = computed(() => {
//     const items = props.saleItems.filter((item) => item.sale_id === form.order_id);
//     saleItemsState.value = items.map((item) => ({ ...item, reason: "", return_date: "" }));
//     return saleItemsState.value;
// });

// // Remove item logic
// const removeItem = (index) => {
//     saleItemsState.value.splice(index, 1);
// }; -->






<!-- // const submit = () => {
//     if (!selectedSale.value) {
//         alert("Please select a valid order.");
//         return;
//     } -->

<!-- //     form.items = saleItemsState.value;

    // const payload = {
    //     sale_id: selectedSale.value.id,
    //     total_amount: selectedSale.value.total_amount,
    //     customer_name: selectedSale.value.customer?.name || "Unknown",
    //     discount: selectedSale.value.discount || 0,
    //     payment_method: selectedSale.value.payment_method || "",
    //     sale_date: selectedSale.value.sale_date || "",
    //     items: filteredSaleItems.value.map((item) => ({
    //         product_id: item.product?.id || null,
    //         quantity: item.quantity || 0,
    //         reason: item.reason || "",
    //         return_date: item.return_date || "",
    //     })),
    // };

    // console.log("Payload:", payload); -->

<!-- //     form.post(route("return-bill.store"), {
//         onSuccess: () => {
//             alert("Return submitted successfully!");
//             form.reset();
//         },
//         onError: (errors) => {
//             console.error("Submission errors:", errors);
//             alert("Failed to submit return. Check console for details.");
//         },
//     });


// }; -->

<!-- // </script> -->
<!-- 
<style scoped>
  /* Additional styles */
</style> -->
