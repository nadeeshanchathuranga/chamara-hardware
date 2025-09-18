<template>
  <Head title="Orders" />
  <Banner />
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <Header />
    <main class="flex-1 flex flex-col items-center md:px-36 px-6 py-8">
      <div class="w-full md:w-5/6 space-y-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <Link :href="route('paints.index')">
              <img src="/images/back-arrow.png" class="w-12 h-12" />
            </Link>
            <h1 class="text-3xl font-bold uppercase">Orders</h1>
          </div>
          <button
            type="button"
            @click="openOrderModal"
            class="px-5 py-3 rounded-md bg-sky-600 text-white hover:bg-sky-700"
          >
            New Order
          </button>
        </div>

        <!-- Search and Filter Controls -->
        <div class="bg-white rounded-2xl shadow p-6">
          <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-auto flex-1">
              <div class="relative">
                <input
                  v-model="searchForm.search"
                  type="text"
                  placeholder="Search by order ID, customer, paint product, color card, or can size..."
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  @input="debouncedSearch"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </div>
              </div>
            </div>
            
            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
              <select
                v-model="searchForm.status"
                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[140px]"
                @change="performSearch"
              >
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
              </select>
              
              <button
                v-if="hasActiveFilters"
                @click="clearFilters"
                class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors whitespace-nowrap"
              >
                Clear Filters
              </button>
            </div>
          </div>
          
          <!-- Results summary -->
          <div v-if="hasActiveFilters" class="mt-4 text-sm text-gray-600">
            <span class="inline-flex items-center gap-2">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 2v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
              </svg>
              Showing {{ orders.length }} order{{ orders.length === 1 ? '' : 's' }}
              {{ searchForm.search ? `matching "${searchForm.search}"` : '' }}
              {{ searchForm.status ? `with status "${searchForm.status}"` : '' }}
            </span>
          </div>
        </div>

        <!-- Orders table -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">
          <div class="no-scrollbar overflow-x-auto">
            <table 
              class="w-full table-auto responsive-table"
            >
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-700 text-white uppercase tracking-wide">
                  <th class="px-2 py-4 text-left text-xs font-semibold">#</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Customer</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Paint Product</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Color Card</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Base Type</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Can Size</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Qty</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Unit Cost</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Status</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Created</th>
                  <th class="px-2 py-4 text-left text-xs font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="o in orders" :key="o.id" class="bg-white hover:bg-gray-50">
                  <td class="px-2 py-3 text-xs font-medium">#{{ o.id }}</td>
                  <td class="px-2 py-3 text-xs">
                    <div class="font-medium truncate" :title="o.customer?.name">
                      {{ o.customer?.name || 'N/A' }}
                    </div>
                  </td>
                  <td class="px-2 py-3 text-xs">
                    <div class="truncate" :title="o.paint_product?.name">
                      {{ o.paint_product?.name || 'N/A' }}
                    </div>
                  </td>
                  <td class="px-2 py-3 text-xs">
                    <div class="truncate" :title="o.color_card?.name">
                      {{ o.color_card?.name || 'N/A' }}
                    </div>
                  </td>
                  <td class="px-2 py-3 text-xs">
                    <div class="truncate" :title="o.base_type?.name">
                      {{ o.base_type?.name || 'N/A' }}
                    </div>
                  </td>
                  <td class="px-2 py-3 text-xs font-medium">{{ o.can_size }}</td>
                  <td class="px-2 py-3 text-xs">{{ o.quantity ?? 1 }}</td>
                  <td class="px-2 py-3 text-xs">{{ Number(o.unit_price).toFixed(2) }}</td>
                  <td class="px-2 py-3 text-xs">
                    <span class="inline-flex px-1 py-1 text-xs font-semibold rounded-full capitalize"
                          :class="o.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                      {{ o.status }}
                    </span>
                  </td>
                  <td class="px-2 py-3 text-xs">{{ new Date(o.created_at).toLocaleString() }}</td>
                  <td class="px-2 py-3">
                    <button
                      class="px-2 py-1 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 disabled:opacity-60 text-xs"
                      :disabled="o.status === 'completed'"
                      @click="openPaymentModal(o)"
                    >
                      Pay
                    </button>
                  </td>
                </tr>
                <tr v-if="!orders.length">
                  <td colspan="11" class="px-4 py-6 text-center text-gray-500 text-sm">
                    {{ hasActiveFilters ? 'No orders found matching your filters.' : 'No orders yet.' }}
                    <div v-if="hasActiveFilters" class="mt-2">
                      <button @click="clearFilters" class="text-blue-600 hover:text-blue-800 underline text-xs">
                        Clear filters to see all orders
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <Footer />
  </div>

  <!-- Payment Modal -->
  <transition name="fade">
    <div v-if="pay.selectedOrder" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="cancelPayment"></div>

      <div
        class="relative z-10 w-11/12 xl:w-[800px] max-h-[90vh] overflow-y-auto rounded-2xl
               border-4 border-emerald-600 bg-white text-gray-800 shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        role="dialog" aria-modal="true"
      >
        <div class="p-8">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-extrabold text-emerald-700">
              Make Payment — Order #{{ pay.selectedOrder.id }}
            </h3>
            <button @click="cancelPayment" class="text-sm px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
              Close
            </button>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Order Details -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h4 class="text-lg font-bold mb-4 text-gray-700">Order Details</h4>
              
              <div class="space-y-3">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Customer</label>
                  <div class="mt-1 p-3 bg-white rounded-md border border-gray-300">
                    {{ pay.selectedOrder.customer?.name || 'N/A' }}
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Paint Product</label>
                    <div class="mt-1 p-3 bg-white rounded-md border border-gray-300 text-sm">
                      {{ pay.selectedOrder.paint_product?.name || 'N/A' }}
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Color Card</label>
                    <div class="mt-1 p-3 bg-white rounded-md border border-gray-300 text-sm">
                      {{ pay.selectedOrder.color_card?.name || 'N/A' }}
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Base Type</label>
                    <div class="mt-1 p-3 bg-white rounded-md border border-gray-300 text-sm">
                      {{ pay.selectedOrder.base_type?.name || 'N/A' }}
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Can Size</label>
                    <div class="mt-1 p-3 bg-white rounded-md border border-gray-300 text-sm">
                      {{ pay.selectedOrder.can_size }}
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Unit Cost (LKR)</label>
                    <div class="mt-1 p-3 bg-white rounded-md border border-gray-300 text-sm font-medium">
                      {{ Number(pay.unit_cost).toFixed(2) }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-emerald-50 rounded-xl p-6">
              <h4 class="text-lg font-bold mb-4 text-emerald-700">Payment Information</h4>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Quantity *</label>
                  <input
                    type="number" min="1" step="1"
                    v-model.number="pay.quantity"
                    class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Selling Price (LKR) *</label>
                  <input
                    type="number" min="0" step="0.01"
                    v-model.number="pay.selling_price"
                    class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Payment Method *</label>
                  <div class="mt-1 flex gap-3">
                    <button
                      class="flex-1 px-4 py-3 rounded-md border-2 transition-colors"
                      :class="pay.method==='cash' ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-white border-gray-300'"
                      @click="pay.method='cash'"
                    >
                      💵 Cash
                    </button>
                    <button
                      class="flex-1 px-4 py-3 rounded-md border-2 transition-colors"
                      :class="pay.method==='card' ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-white border-gray-300'"
                      @click="pay.method='card'"
                    >
                      💳 Card
                    </button>
                  </div>
                </div>

                <div v-if="pay.method === 'cash'">
                  <label class="block text-sm font-medium text-gray-700">Cash Amount (LKR) *</label>
                  <input
                    type="number" min="0" step="0.01"
                    v-model.number="pay.cash"
                    class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  />
                </div>
              </div>

              <!-- Payment Summary -->
              <div class="mt-6 p-4 bg-white rounded-lg border-2 border-emerald-200">
                <div class="space-y-2">
                  <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Subtotal:</span>
                    <span class="font-medium">{{ paySubtotal.toFixed(2) }} LKR</span>
                  </div>
                  <div v-if="pay.method === 'cash'" class="flex justify-between">
                    <span class="text-sm text-gray-600">Cash:</span>
                    <span class="font-medium">{{ Number(pay.cash || 0).toFixed(2) }} LKR</span>
                  </div>
                  <div v-if="pay.method === 'cash'" class="flex justify-between border-t pt-2">
                    <span class="text-sm font-medium" :class="payBalance < 0 ? 'text-red-600' : 'text-emerald-600'">
                      Balance:
                    </span>
                    <span class="font-bold text-lg" :class="payBalance < 0 ? 'text-red-600' : 'text-emerald-600'">
                      {{ payBalance.toFixed(2) }} LKR
                    </span>
                  </div>
                  <div v-else class="flex justify-between border-t pt-2">
                    <span class="text-sm font-medium text-emerald-600">Total:</span>
                    <span class="font-bold text-lg text-emerald-600">{{ paySubtotal.toFixed(2) }} LKR</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center justify-end gap-4 mt-8">
            <button 
              class="px-6 py-3 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition-colors" 
              @click="cancelPayment"
            >
              Cancel
            </button>
            <button
              class="px-8 py-3 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 disabled:opacity-60 font-medium transition-colors"
              :disabled="pay.processing || paySubtotal <= 0 || (pay.method === 'cash' && payBalance < 0)"
              @click="confirmPayment"
            >
              <span v-if="pay.processing">Processing...</span>
              <span v-else>💸 Confirm Payment & Print</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <!-- New Order modal -->
  <transition name="fade">
    <div v-if="isOrderOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeOrderModal"></div>

      <div
        class="relative z-10 w-11/12 xl:w-[1200px] 2xl:w-[1400px] max-h-[92vh] overflow-y-auto rounded-2xl
               border-4 border-sky-600 bg-white text-gray-800 shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        role="dialog" aria-modal="true"
      >
        <div class="p-8">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-extrabold">New Order</h3>
            <button @click="closeOrderModal" class="text-sm px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Customer -->
            <div class="bg-white rounded-xl ring-1 ring-gray-200 p-6">
              <h2 class="font-bold text-xl mb-5">Customer</h2>

              <label class="block text-sm">Existing Customer</label>
              <select
                v-model="selectedCustomerId"
                class="w-full mt-1 rounded-md border border-gray-300 p-4"
              >
                <option value="">— New customer —</option>
                <option v-for="c in customers" :key="c.id" :value="String(c.id)">
                  {{ c.name }}{{ c.phone ? ' • ' + c.phone : (c.email ? ' • ' + c.email : '') }}
                </option>
              </select>

              <div class="mt-5">
                <label class="block text-sm">Name *</label>
                <input v-model="orderForm.customer_name" type="text"
                       class="w-full mt-1 rounded-md border border-gray-300 p-4"
                       placeholder="Jane Doe" autocomplete="off" />
                <p v-if="orderForm.errors.customer_name" class="text-red-600 text-sm mt-1">
                  {{ orderForm.errors.customer_name }}
                </p>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                <div>
                  <label class="block text-sm">Phone</label>
                  <input v-model="orderForm.phone" type="text"
                         class="w-full mt-1 rounded-md border border-gray-300 p-4"
                         placeholder="+94..." autocomplete="off" />
                  <p v-if="orderForm.errors.phone" class="text-red-600 text-sm mt-1">{{ orderForm.errors.phone }}</p>
                </div>
                <div>
                  <label class="block text-sm">Email</label>
                  <input v-model="orderForm.email" type="email"
                         class="w-full mt-1 rounded-md border border-gray-300 p-4"
                         placeholder="jane@example.com" autocomplete="off" />
                  <p v-if="orderForm.errors.email" class="text-red-600 text-sm mt-1">{{ orderForm.errors.email }}</p>
                </div>
              </div>
            </div>

            <!-- Order details -->
            <div class="bg-white rounded-xl ring-1 ring-gray-200 p-6">
              <h2 class="font-bold text-xl mb-5">Order Details</h2>

              <label class="block text-sm">Paint Type *</label>
              <select v-model.number="orderForm.paint_type_id" class="w-full mt-1 rounded-md border border-gray-300 p-4">
                <option disabled value="">Select paint type</option>
                <option v-for="p in paintTypes" :key="p.id" :value="p.id">{{ p.name }}</option>
              </select>
              <p v-if="orderForm.errors.paint_type_id" class="text-red-600 text-sm mt-1">
                {{ orderForm.errors.paint_type_id }}
              </p>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                <div>
                  <label class="block text-sm">Color Card *</label>
                  <select v-model.number="orderForm.color_card_id" class="w-full mt-1 rounded-md border border-gray-300 p-4">
                    <option disabled value="">Select color card</option>
                    <option v-for="c in colorCards" :key="c.id" :value="c.id">{{ c.name }}</option>
                  </select>
                  <p v-if="orderForm.errors.color_card_id" class="text-red-600 text-sm mt-1">
                    {{ orderForm.errors.color_card_id }}
                  </p>
                </div>

                <div>
                  <label class="block text-sm">Base Type *</label>
                  <select v-model.number="orderForm.base_type_id" class="w-full mt-1 rounded-md border border-gray-300 p-4">
                    <option disabled value="">Select base type</option>
                    <option v-for="b in baseTypes" :key="b.id" :value="b.id">{{ b.name }}</option>
                  </select>
                  <p v-if="orderForm.errors.base_type_id" class="text-red-600 text-sm mt-1">
                    {{ orderForm.errors.base_type_id }}
                  </p>
                </div>
              </div>

              <!-- Sizes / pricing row -->
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                <div>
                  <label class="block text-sm">Can Size *</label>
                  <select v-model="orderForm.can_size" class="w-full mt-1 rounded-md border border-gray-300 p-4">
                    <option disabled value="">Select size</option>
                    <option v-for="s in CAN_SIZES" :key="s" :value="s">{{ s }}</option>
                  </select>
                  <p v-if="orderForm.errors.can_size" class="text-red-600 text-sm mt-1">{{ orderForm.errors.can_size }}</p>
                </div>

                <div>
                  <label class="block text-sm">Quantity *</label>
                  <input v-model.number="orderForm.quantity" type="number" min="1" step="1"
                         class="w-full mt-1 rounded-md border border-gray-300 p-4" placeholder="1" />
                  <p v-if="orderForm.errors.quantity" class="text-red-600 text-sm mt-1">{{ orderForm.errors.quantity }}</p>
                </div>

                <div>
                  <label class="block text-sm">Unit Cost *</label>
                  <input v-model.number="orderForm.unit_price" type="number" min="0" step="0.01"
                         class="w-full mt-1 rounded-md border border-gray-300 p-4" placeholder="0.00" />
                  <p v-if="orderForm.errors.unit_price" class="text-red-600 text-sm mt-1">{{ orderForm.errors.unit_price }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between mt-8">
            <button @click="closeOrderModal" class="px-5 py-3 rounded-md bg-gray-200 hover:bg-gray-100 text-gray-900">
              Cancel
            </button>
            <button @click="submitOrder" type="button" :disabled="orderForm.processing"
                    class="px-6 py-3 rounded-md bg-sky-600 hover:bg-sky-700 text-white disabled:opacity-60">
              Save Order
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <!-- Print bill (reuse POS modal) -->
  <PosSuccessModel
    :open="print.open"
    @update:open="v => print.open = v"
    :products="print.products"
    :employee="null"
    :cashier="loggedInUser"
    :customer="print.customer"
    :orderid="print.orderid"
    :cash="String(print.cash)"
    :balance="String(print.balance)"
    :subTotal="String(print.subTotal)"
    :totalDiscount="'0'"
    :total="String(print.total)"
    :custom_discount_type="'fixed'"
    :custom_discount="0"
    :companyInfo="null"
  />
</template>

<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import { ref, watch, reactive, computed, onMounted, nextTick } from 'vue'
import axios from 'axios'
import Header from '@/Components/custom/Header.vue'
import Footer from '@/Components/custom/Footer.vue'
import Banner from '@/Components/Banner.vue'
import PosSuccessModel from '@/Components/custom/PosSuccessModel.vue'

const CAN_SIZES = ['1L','4L','10L']

const props = defineProps({
  orders:       { type: Array,  default: () => [] },
  paintTypes:   { type: Array,  default: () => [] },
  colorCards:   { type: Array,  default: () => [] },
  baseTypes:    { type: Array,  default: () => [] },
  customers:    { type: Array,  default: () => [] },
  loggedInUser: { type: Object, default: null },
  filters:      { type: Object, default: () => ({ search: '', status: '' }) },
})

/* --- Search and Filter --- */
const searchForm = reactive({
  search: props.filters.search || '',
  status: props.filters.status || '',
})

const hasActiveFilters = computed(() => {
  return searchForm.search.trim() !== '' || searchForm.status !== ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    performSearch()
  }, 500) // 500ms delay
}

const performSearch = () => {
  const params = {}
  
  if (searchForm.search.trim()) {
    params.search = searchForm.search.trim()
  }
  
  if (searchForm.status) {
    params.status = searchForm.status
  }
  
  router.get(route('paints.orders.index'), params, {
    preserveState: true,
    preserveScroll: true,
    only: ['orders', 'filters'],
  })
}

const clearFilters = () => {
  searchForm.search = ''
  searchForm.status = ''
  router.get(route('paints.orders.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    only: ['orders', 'filters'],
  })
}

/* --- Modal state --- */
const isOrderOpen = ref(false)
const selectedCustomerId = ref('')

function openOrderModal(){
  orderForm.clearErrors()
  selectedCustomerId.value = ''
  if (!props.customers?.length) {
    router.reload({ only: ['customers'], onFinish: () => { isOrderOpen.value = true } })
  } else {
    isOrderOpen.value = true
  }
}
function closeOrderModal(){ isOrderOpen.value = false }

/* --- New Order form --- */
const orderForm = useForm({
  customer_name: '',
  phone: '',
  email: '',
  paint_type_id: '',
  color_card_id: '',
  base_type_id: '',
  can_size: '',
  quantity: 1,
  unit_price: null, // COST
})

watch(selectedCustomerId, (id) => {
  if (!id) {
    orderForm.customer_name = ''
    orderForm.phone = ''
    orderForm.email = ''
    return
  }
  const c = props.customers.find(x => String(x.id) === String(id))
  if (c) {
    orderForm.customer_name = c.name || ''
    orderForm.phone = c.phone || ''
    orderForm.email = c.email || ''
  }
})

function submitOrder () {
  orderForm.post(route('paints.orders.store'), {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['orders'] })
      orderForm.reset(
        'customer_name','phone','email',
        'paint_type_id','color_card_id','base_type_id',
        'can_size','quantity','unit_price'
      )
      selectedCustomerId.value = ''
      isOrderOpen.value = true
    },
  })
}

/* ---------- PAY FLOW ---------- */
const pay = reactive({
  selectedOrder: null,
  quantity: 1,
  unit_cost: 0,        // read-only from order.unit_price
  selling_price: 0,    // entered at payment time
  cash: 0,
  method: 'cash',
  processing: false,
})

const paySubtotal = computed(() =>
  Number(pay.quantity || 0) * Number(pay.selling_price || 0)
)
const payBalance = computed(() =>
  Number(pay.cash || 0) - paySubtotal.value
)

function openPaymentModal(o){
  // Open payment modal with order data pre-filled
  pay.selectedOrder = o
  pay.quantity = Number(o.quantity ?? 1)
  pay.unit_cost = Number(o.unit_price ?? 0)        // cost from order
  pay.selling_price = Number(o.unit_price ?? 0)    // default selling = cost (editable)
  pay.method = 'cash'
  
  // Set cash after selling_price is set using nextTick for reactivity
  nextTick(() => {
    pay.cash = paySubtotal.value
  })
}

function cancelPayment(){
  pay.selectedOrder = null
  pay.quantity = 1
  pay.unit_cost = 0
  pay.selling_price = 0
  pay.cash = 0
  pay.method = 'cash'
}

/* print data */
const print = reactive({
  open: false,
  products: [],
  customer: null,
  orderid: '',
  cash: 0,
  balance: 0,
  subTotal: '0',
  total: '0',
})

async function confirmPayment(){
  if (!pay.selectedOrder) return
  if (payBalance.value < 0) return

  pay.processing = true
  try {
    await axios.post(route('paints.orders.pay', pay.selectedOrder.id), {
      quantity: pay.quantity,
      selling_price: pay.selling_price,
      cash: pay.cash,
      payment_method: pay.method,
    })

    // prepare print modal data (client-side)
    // NOTE: we include Unit Cost in the product label so it appears on the bill
    print.products = [{
      id: 'PAINT',
      name: `${pay.selectedOrder.paint_product?.name || 'Paint'} / ${pay.selectedOrder.can_size} (Unit ${Number(pay.unit_cost).toFixed(2)})`,
      selling_price: Number(pay.selling_price),      // shown as the line price in POS receipt
      quantity: Number(pay.quantity),
      discounted_price: Number(pay.selling_price),
      apply_discount: false,
    }]
    print.customer = {
      name: pay.selectedOrder.customer?.name || '',
      email: '',
      phone: '',
    }
    print.orderid = `PO-${pay.selectedOrder.id}`
    print.cash = Number(pay.cash)
    print.subTotal = paySubtotal.value.toFixed(2)
    print.total = paySubtotal.value.toFixed(2)
    print.balance = Number(payBalance.value.toFixed(2))
    print.open = true

    // hide cash panel immediately
    cancelPayment()

    // refresh order list (status -> completed)
    router.reload({ only: ['orders'] })
  } catch (e) {
    const msg = e?.response?.data?.message || e?.message || 'Payment failed.'
    const hint = e?.response?.data?.hint
    alert(hint ? `${msg}\n\n${hint}` : msg)
    console.error('Pay error:', e?.response?.data || e)
  } finally {
    pay.processing = false
  }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

/* Hide scrollbars completely */
.no-scrollbar {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* Internet Explorer 10+ */
}

.no-scrollbar::-webkit-scrollbar {
  display: none; /* WebKit browsers */
}

/* Responsive table that fits all screen sizes */
.responsive-table {
  table-layout: fixed; /* Use fixed layout for better control */
  width: 100%;
}

.responsive-table th,
.responsive-table td {
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 0.5rem 0.25rem; /* Compact padding */
  font-size: 0.75rem; /* Smaller text for better fit */
  line-height: 1.2;
}

/* Specific column width optimizations for laptop screens */
.responsive-table th:nth-child(1),
.responsive-table td:nth-child(1) { width: 5%; } /* Order ID */

.responsive-table th:nth-child(2),
.responsive-table td:nth-child(2) { width: 15%; } /* Customer */

.responsive-table th:nth-child(3),
.responsive-table td:nth-child(3) { width: 13%; } /* Paint Product */

.responsive-table th:nth-child(4),
.responsive-table td:nth-child(4) { width: 13%; } /* Color Card */

.responsive-table th:nth-child(5),
.responsive-table td:nth-child(5) { width: 10%; } /* Base Type */

.responsive-table th:nth-child(6),
.responsive-table td:nth-child(6) { width: 8%; } /* Can Size */

.responsive-table th:nth-child(7),
.responsive-table td:nth-child(7) { width: 5%; } /* Qty */

.responsive-table th:nth-child(8),
.responsive-table td:nth-child(8) { width: 10%; } /* Unit Cost */

.responsive-table th:nth-child(9),
.responsive-table td:nth-child(9) { width: 8%; } /* Status */

.responsive-table th:nth-child(10),
.responsive-table td:nth-child(10) { width: 13%; } /* Created */

.responsive-table th:nth-child(11),
.responsive-table td:nth-child(11) { width: 6%; } /* Actions */

/* Custom scrollbar styles */
.scrollbar-thin {
  scrollbar-width: thin;
}

.scrollbar-thin::-webkit-scrollbar {
  height: 8px;
}

.scrollbar-thin::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Table responsive container */
.table-container {
  position: relative;
}

.table-container::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 20px;
  background: linear-gradient(to left, rgba(255,255,255,1), rgba(255,255,255,0));
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.table-container:hover::after {
  opacity: 1;
}
</style>
