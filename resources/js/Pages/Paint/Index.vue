<!-- resources/js/Pages/Paint/Index.vue -->
<template>
  <Head title="Color Bank" />
  <Banner />

  <div class="min-h-screen bg-gray-100 flex flex-col">
    <Header />

    <main class="flex-1 flex flex-col items-center md:px-36 px-6 py-8">
      <div class="w-full md:w-5/6">
        <!-- Page header -->
        <div class="flex items-center justify-between mb-8">
          <div class="flex items-center space-x-4">
            <Link href="/"><img src="/images/back-arrow.png" class="w-12 h-12" /></Link>
            <h1 class="text-3xl font-bold tracking-wide text-black uppercase">Color Bank</h1>
          </div>
        </div>

        <!-- GRID -->
        <div v-if="HasRole(['Admin','Manager'])" class="space-y-6">
          <!-- Row 1: small cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Paint Type -->
            <div role="button" @click="openModal('paint')" class="cursor-pointer">
              <div class="dashboard-card bg-[#c62e51] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-5 space-x-4">
                  <Paintbrush class="w-14 h-14 text-white shrink-0" />
                  <div>
                    <p class="text-white text-xl font-extrabold uppercase">Paint Type (Products)</p>
                    <p class="text-white/90 text-sm">Add a new paint type name.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Color Card -->
            <div role="button" @click="openModal('colorCard')" class="cursor-pointer">
              <div class="dashboard-card bg-[#2e7ac6] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-5 space-x-4">
                  <Palette class="w-14 h-14 text-white shrink-0" />
                  <div>
                    <p class="text-white text-xl font-extrabold uppercase">Color Card</p>
                    <p class="text-white/90 text-sm">Add a new color card name.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Base Type -->
            <div role="button" @click="openModal('baseType')" class="cursor-pointer">
              <div class="dashboard-card bg-[#16a34a] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-5 space-x-4">
                  <Layers class="w-14 h-14 text-white shrink-0" />
                  <div>
                    <p class="text-white text-xl font-extrabold uppercase">Base Type</p>
                    <p class="text-white/90 text-sm">Add a new base type name.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Row 2: large cards -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Colorance Stock: opens CRUD modal -->
            <div role="button" @click="openColorance()" class="cursor-pointer lg:col-span-1">
              <div class="dashboard-card bg-[#f59e0b] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-6 space-x-5">
                  <Package class="w-16 h-16 text-white shrink-0" />
                  <div>
                    <p class="text-white text-2xl font-extrabold uppercase">Colorance Stock</p>
                    <p class="text-white/90 text-base">Manage tinter/colorant inventory.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Machine Refill: opens popup -->
            <div role="button" @click="openMixing()" class="cursor-pointer lg:col-span-1">
              <div class="dashboard-card bg-[#8b5cf6] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-6 space-x-5">
                  <Droplet class="w-16 h-16 text-white shrink-0" />
                  <div>
                    <p class="text-white text-2xl font-extrabold uppercase">Machine Refill</p>
                    <p class="text-white/90 text-base">Record refill; stock auto-adjusts.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Row 3: Make Order -->
          <div class="grid grid-cols-1 gap-6">
            <Link href="/paints/orders">
              <div class="dashboard-card bg-[#0ea5e9] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-6 space-x-5">
                  <ShoppingCart class="w-16 h-16 text-white shrink-0" />
                  <div>
                    <p class="text-white text-2xl font-extrabold tracking-wide uppercase">Make Order</p>
                    <p class="text-white/90 text-base">Create a customer order.</p>
                  </div>
                </div>
              </div>
            </Link>
          </div>
        </div>

        <div v-else class="text-center text-gray-600 py-16">
          You don’t have permission to view Color Bank.
        </div>
      </div>
    </main>

    <Footer />
  </div>

  <!-- Small “Add Name” modal (centered) -->
  <transition name="fade">
    <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeModal"></div>

      <div
        class="relative z-10 w-11/12 sm:w-[430px] rounded-2xl border-4 border-blue-600
               bg-black text-white shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <h3 class="text-center text-xl font-extrabold mb-5">{{ modalTitle }}</h3>

          <label class="block text-sm mb-1">Name</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full rounded-md border-2 border-blue-500 focus:border-blue-600 focus:ring-0 text-black p-3"
            placeholder="Enter name"
            @keyup.enter="submit"
            autofocus
          />
          <p v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</p>

          <div class="mt-6 flex justify-center space-x-3">
            <button
              @click="submit"
              :disabled="form.processing || !form.name"
              class="px-5 py-2 rounded-md bg-blue-600 hover:bg-blue-700 disabled:opacity-60"
            >
              Save
            </button>
            <button @click="closeModal" class="px-5 py-2 rounded-md bg-gray-300 text-black hover:bg-gray-200">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <!-- Colorance Stock CRUD modal (centered) -->
  <transition name="fade">
    <div v-if="isColoranceOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeColorance"></div>

      <div
        class="relative z-10 w-11/12 md:w-[1100px] max-h-[85vh] overflow-y-auto rounded-2xl
               border-4 border-amber-500 bg-white text-gray-800"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold">Colorance Stock</h3>
            <div class="flex items-center gap-3">
              <input
                v-model="cSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search colorance…"
              />
              <button @click="closeColorance" class="text-sm px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
            </div>
          </div>

          <!-- form -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-2">
              <label class="text-sm font-medium">Name</label>
              <input v-model="cForm.name" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="e.g. Red Oxide" />
              <p v-if="cForm.errors.name" class="text-red-500 text-sm mt-1">{{ cForm.errors.name }}</p>
            </div>
            <div>
              <label class="text-sm font-medium">Can Size</label>
              <input v-model="cForm.can_size" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="1L / 500ml" />
              <p v-if="cForm.errors.can_size" class="text-red-500 text-sm mt-1">{{ cForm.errors.can_size }}</p>
            </div>
            <div>
              <label class="text-sm font-medium">Units</label>
              <input v-model.number="cForm.unit" type="number" min="0" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="0" />
              <p v-if="cForm.errors.unit" class="text-red-500 text-sm mt-1">{{ cForm.errors.unit }}</p>
            </div>

            <div class="md:col-span-4 flex gap-3">
              <button v-if="!editingId" @click="createColorance" :disabled="cForm.processing" class="px-5 py-2 rounded bg-amber-600 text-white hover:bg-amber-700 disabled:opacity-60">
                Add
              </button>
              <button v-else @click="updateColorance" :disabled="cForm.processing" class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-60">
                Update
              </button>
              <button v-if="editingId" @click="resetEdit" class="px-5 py-2 rounded bg-gray-200 hover:bg-gray-100">
                Cancel Edit
              </button>
            </div>
          </div>

          <!-- list (RESTYLED & LARGER) -->
          <div class="mt-6 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                  <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Name</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Can Size</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Units</th>
                  <th class="px-6 py-4 text-right text-base font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(row, i) in filteredColorance" :key="row.id">
                  <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                  <td class="px-6 py-4 text-base font-medium">{{ row.name }}</td>
                  <td class="px-6 py-4 text-base">{{ row.can_size }}</td>
                  <td class="px-6 py-4 text-base">{{ row.unit }}</td>
                  <td class="px-6 py-4">
                    <div class="flex justify-end gap-2">
                      <button @click="startEdit(row)" class="px-4 py-2 rounded-md text-white bg-emerald-500 hover:bg-emerald-600 text-sm">Edit</button>
                      <button @click="removeColorance(row)" class="px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 text-sm">Delete</button>
                    </div>
                  </td>
                </tr>
                <tr v-if="!filteredColorance.length">
                  <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-base">No colorance stock found.</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </transition>

  <!-- Machine Refill popup (centered) -->
  <transition name="fade">
    <div v-if="isMixOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeMixing"></div>

      <div
        class="relative z-10 w-11/12 lg:w-[1200px] max-h-[88vh] overflow-y-auto rounded-2xl
               border-4 border-violet-500 bg-white text-gray-800"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold">Machine Refill</h3>
            <div class="flex items-center gap-3">
              <input
                v-model="sSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search colorance to refill…"
              />
              <button @click="closeMixing" class="text-sm px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
            </div>
          </div>

          <div class="mb-3 text-sm text-gray-600">
            Total to refill: <span class="font-semibold">{{ totalUnits }}</span>
          </div>

          <!-- refill table (RESTYLED) -->
          <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                  <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Name</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Can Size</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Available</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Refill Units</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(row, i) in filteredStocks" :key="row.id">
                  <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                  <td class="px-6 py-4 text-base font-medium">{{ row.name }}</td>
                  <td class="px-6 py-4 text-base">{{ row.can_size }}</td>
                  <td class="px-6 py-4 text-base">{{ row.unit }}</td>
                  <td class="px-6 py-4">
                    <input
                      v-model.number="mUnits[row.id]"
                      type="number"
                      min="0"
                      :max="row.unit"
                      class="w-32 rounded-md border border-gray-300 p-3"
                      placeholder="0"
                    />
                    <p v-if="mForm.errors[`items.${row.id}`]" class="text-red-500 text-xs mt-1">
                      {{ mForm.errors[`items.${row.id}`] }}
                    </p>
                  </td>
                </tr>
                <tr v-if="!filteredStocks.length">
                  <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-base">No colorance stock found.</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mt-5 flex items-center justify-between">
            <div class="text-sm text-gray-600">Leave rows at 0 to skip them.</div>
            <div class="space-x-3">
              <button @click="clearMix" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-100" type="button">Clear</button>
              <button
                @click="applyMix"
                :disabled="mForm.processing || totalUnits === 0"
                class="px-5 py-2 rounded bg-violet-600 text-white hover:bg-violet-700 disabled:opacity-60"
              >
                Apply Refill
              </button>
            </div>
          </div>

          <!-- recent history + search (RESTYLED) -->
          <div class="mt-8">
            <div class="flex items-center justify-between mb-3">
              <h4 class="font-bold">Recent Refill History</h4>
              <input
                v-model="hSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search history…"
              />
            </div>

            <div class="overflow-x-auto rounded-lg shadow">
              <table class="min-w-full">
                <thead>
                  <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                    <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                    <th class="px-6 py-4 text-left text-base font-semibold">Colorance</th>
                    <th class="px-6 py-4 text-left text-base font-semibold">Units</th>
                    <th class="px-6 py-4 text-left text-base font-semibold">When</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-for="(h,i) in filteredHistory" :key="h.id">
                    <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                    <td class="px-6 py-4 text-base">
                      {{ h.colorance?.name }}
                      <span class="text-sm text-gray-500">({{ h.colorance?.can_size }})</span>
                    </td>
                    <td class="px-6 py-4 text-base">{{ h.units }}</td>
                    <td class="px-6 py-4 text-base">{{ new Date(h.created_at).toLocaleString() }}</td>
                  </tr>
                  <tr v-if="!filteredHistory.length">
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-base">No results.</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>

        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/custom/Header.vue'
import Footer from '@/Components/custom/Footer.vue'
import Banner from '@/Components/Banner.vue'
import { HasRole } from '@/Utils/Permissions'
import { Paintbrush, Palette, Layers, Package, Droplet, ShoppingCart } from 'lucide-vue-next'

const props = defineProps({
  coloranceStocks: { type: Array, default: () => [] },
  machineHistory:  { type: Array, default: () => [] },
  orders:          { type: Array, default: () => [] }, // ok if unused here
})

/* ------------- Small “Add Name” modal ------------- */
const isOpen = ref(false)
const modalTitle = ref('')
const modalRouteName = ref('')
const form = useForm({ name: '' })

const MAP = {
  paint:     { title: 'Add Paint Type',   route: 'paints.types.store' },
  colorCard: { title: 'Add Color Card',   route: 'paints.color-cards.store' },
  baseType:  { title: 'Add Base Type',    route: 'paints.base-types.store' },
}
function openModal(type){ const m=MAP[type]; modalTitle.value=m.title; modalRouteName.value=m.route; form.reset('name'); form.clearErrors(); isOpen.value=true }
function closeModal(){ isOpen.value=false; form.reset('name'); form.clearErrors() }
function submit(){ if(!modalRouteName.value) return; form.post(route(modalRouteName.value), { preserveScroll:true, onSuccess:closeModal }) }

/* ------------- Colorance stock modal ------------- */
const isColoranceOpen = ref(false)
const cForm = useForm({ name:'', can_size:'', unit:0 })
const editingId = ref(null)

const cSearch = ref('')
const filteredColorance = computed(() => {
  const q = cSearch.value.trim().toLowerCase()
  if (!q) return props.coloranceStocks
  return props.coloranceStocks.filter(s =>
    (s.name||'').toLowerCase().includes(q) ||
    (s.can_size||'').toLowerCase().includes(q) ||
    String(s.unit||'').includes(q)
  )
})

function openColorance(){ resetEdit(); isColoranceOpen.value = true }
function closeColorance(){ isColoranceOpen.value = false; resetEdit() }
function resetEdit(){ editingId.value=null; cForm.reset('name','can_size','unit'); cForm.clearErrors() }
function startEdit(row){ editingId.value=row.id; cForm.name=row.name; cForm.can_size=row.can_size; cForm.unit=row.unit }
function createColorance(){ cForm.post(route('paints.colorance-stocks.store'), { preserveScroll:true, onSuccess:()=>{ router.reload({only:['coloranceStocks']}); resetEdit(); isColoranceOpen.value=true; }}) }
function updateColorance(){ if(!editingId.value) return; cForm.put(route('paints.colorance-stocks.update', editingId.value), { preserveScroll:true, onSuccess:()=>{ router.reload({only:['coloranceStocks']}); resetEdit(); isColoranceOpen.value=true; }}) }
function removeColorance(row){ if(!confirm(`Delete "${row.name}" (${row.can_size})?`)) return; router.delete(route('paints.colorance-stocks.destroy', row.id), { preserveScroll:true, onSuccess:()=>{ router.reload({only:['coloranceStocks']}); isColoranceOpen.value=true; }}) }

/* ------------- Mixing (Machine Refill) popup ------------- */
const isMixOpen = ref(false)
const mUnits = ref({})
function ensureUnitsKeys(){
  for (const s of props.coloranceStocks) {
    if (mUnits.value[s.id] === undefined) mUnits.value[s.id] = 0
  }
}
ensureUnitsKeys()
watch(() => props.coloranceStocks, ensureUnitsKeys, { deep: true, immediate: true })

const sSearch = ref('')
const filteredStocks = computed(() => {
  const q = sSearch.value.trim().toLowerCase()
  if (!q) return props.coloranceStocks
  return props.coloranceStocks.filter(s =>
    (s.name||'').toLowerCase().includes(q) ||
    (s.can_size||'').toLowerCase().includes(q)
  )
})

const mForm = useForm({ items: [] })
const totalUnits = computed(() =>
  Object.values(mUnits.value).reduce((a,b)=> a + (Number(b)||0), 0)
)

function openMixing(){
  for (const id of Object.keys(mUnits.value)) mUnits.value[id] = 0
  mForm.clearErrors()
  isMixOpen.value = true
}
function closeMixing(){
  isMixOpen.value = false
  for (const id of Object.keys(mUnits.value)) mUnits.value[id] = 0
}
function clearMix(){
  for (const id of Object.keys(mUnits.value)) mUnits.value[id] = 0
}

function applyMix(){
  const idx = new Map(props.coloranceStocks.map(s => [s.id, s]))
  const items = Object.entries(mUnits.value)
    .map(([id, units]) => ({ id: Number(id), units: Number(units)||0 }))
    .filter(it => it.units > 0)
    .map(it => {
      const max = idx.get(it.id)?.unit ?? 0
      return { id: it.id, units: Math.min(it.units, max) }
    })
    .filter(it => it.units > 0)

  if (!items.length) return

  mForm.items = items
  mForm.post(route('paints.mixing.store'), {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['coloranceStocks','machineHistory'] })
      clearMix()
      isMixOpen.value = true
    }
  })
}

/* ------------- History search ------------- */
const hSearch = ref('')
const filteredHistory = computed(() => {
  const q = hSearch.value.trim().toLowerCase()
  if (!q) return props.machineHistory
  return props.machineHistory.filter(h => {
    const name = (h.colorance?.name ?? '').toLowerCase()
    const can  = (h.colorance?.can_size ?? '').toLowerCase()
    const units = String(h.units ?? '')
    const when  = new Date(h.created_at).toLocaleString().toLowerCase()
    return name.includes(q) || can.includes(q) || units.includes(q) || when.includes(q)
  })
})
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity .15s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
