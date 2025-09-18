<template>
  <Head title="Make Order" />
  <Banner />

  <div class="min-h-screen bg-gray-100 flex flex-col">
    <Header />
    <main class="flex-1 flex flex-col items-center md:px-36 px-6 py-8">
      <div class="w-full md:w-5/6 space-y-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <Link :href="route('paints.orders.index')">
              <img src="/images/back-arrow.png" class="w-12 h-12" />
            </Link>
            <h1 class="text-3xl font-bold tracking-wide text-black uppercase">Make Order</h1>
          </div>
          <Link :href="route('paints.orders.index')" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-100">Orders</Link>
        </div>

        <!-- form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Customer -->
          <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="font-bold text-lg mb-4">Customer</h2>

            <label class="block text-sm">Name *</label>
            <input v-model="form.customer_name" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="Jane Doe" autocomplete="off" />
            <p v-if="form.errors.customer_name" class="text-red-600 text-sm mt-1">{{ form.errors.customer_name }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <div>
                <label class="block text-sm">Phone</label>
                <input v-model="form.phone" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="+94..." autocomplete="off" />
                <p v-if="form.errors.phone" class="text-red-600 text-sm mt-1">{{ form.errors.phone }}</p>
              </div>
              <div>
                <label class="block text-sm">Email</label>
                <input v-model="form.email" type="email" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="jane@example.com" autocomplete="off" />
                <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
              </div>
            </div>
          </div>

          <!-- Order details -->
          <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="font-bold text-lg mb-4">Order Details</h2>

            <label class="block text-sm">Paint Type *</label>
            <select v-model.number="form.paint_type_id" class="w-full mt-1 rounded-md border border-gray-300 p-3">
              <option disabled value="">Select paint type</option>
              <option v-for="p in paintTypes" :key="p.id" :value="p.id">{{ p.name }}</option>
            </select>
            <p v-if="form.errors.paint_type_id" class="text-red-600 text-sm mt-1">{{ form.errors.paint_type_id }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <div>
                <label class="block text-sm">Color Card *</label>
                <select v-model.number="form.color_card_id" class="w-full mt-1 rounded-md border border-gray-300 p-3">
                  <option disabled value="">Select color card</option>
                  <option v-for="c in colorCards" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
                <p v-if="form.errors.color_card_id" class="text-red-600 text-sm mt-1">{{ form.errors.color_card_id }}</p>
              </div>

              <div>
                <label class="block text-sm">Base Type *</label>
                <select v-model.number="form.base_type_id" class="w-full mt-1 rounded-md border border-gray-300 p-3">
                  <option disabled value="">Select base type</option>
                  <option v-for="b in baseTypes" :key="b.id" :value="b.id">{{ b.name }}</option>
                </select>
                <p v-if="form.errors.base_type_id" class="text-red-600 text-sm mt-1">{{ form.errors.base_type_id }}</p>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
              <div>
                <label class="block text-sm">Can Size *</label>
                <select v-model="form.can_size" class="w-full mt-1 rounded-md border border-gray-300 p-3">
                  <option disabled value="">Select size</option>
                  <option v-for="s in CAN_SIZES" :key="s" :value="s">{{ s }}</option>
                </select>
                <p v-if="form.errors.can_size" class="text-red-600 text-sm mt-1">{{ form.errors.can_size }}</p>
              </div>

              <!-- ✅ Unit Price is optional now -->
              <div>
                <label class="block text-sm">Unit Price</label>
                <input
                  v-model.number="form.unit_price"
                  type="number" min="0" step="0.01"
                  class="w-full mt-1 rounded-md border border-gray-300 p-3"
                  placeholder="0.00"
                />
                <p v-if="form.errors.unit_price" class="text-red-600 text-sm mt-1">{{ form.errors.unit_price }}</p>
              </div>

              <div>
                <label class="block text-sm">Status</label>
                <select v-model="form.status" class="w-full mt-1 rounded-md border border-gray-300 p-3">
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                </select>
                <p v-if="form.errors.status" class="text-red-600 text-sm mt-1">{{ form.errors.status }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- actions -->
        <div class="flex items-center justify-between">
          <Link :href="route('paints.orders.index')" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-100 text-gray-900">Cancel</Link>
          <button @click="submit" type="button" :disabled="form.processing" class="px-5 py-2 rounded-md bg-[#0ea5e9] hover:bg-sky-600 text-white">
            Save Order
          </button>
        </div>
      </div>
    </main>
    <Footer />
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import Header from '@/Components/custom/Header.vue'
import Footer from '@/Components/custom/Footer.vue'
import Banner from '@/Components/Banner.vue'

const CAN_SIZES = ['1L','4L','10L']

const props = defineProps({
  paintTypes: { type: Array, default: () => [] },
  colorCards: { type: Array, default: () => [] },
  baseTypes:  { type: Array, default: () => [] },
})

const form = useForm({
  customer_name: '',
  phone: '',
  email: '',
  paint_type_id: '',
  color_card_id: '',
  base_type_id: '',
  can_size: '',
  unit_price: null,    // optional
  status: 'pending',
})

function submit () {
  form.post(route('paints.orders.store'), {
    onSuccess: () => form.reset(
      'customer_name','phone','email',
      'paint_type_id','color_card_id','base_type_id',
      'can_size','unit_price','status'
    ),
  })
}
</script>
