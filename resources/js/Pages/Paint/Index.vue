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
            <div role="button" @click="openPaintTypes()" class="cursor-pointer">
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
            <div role="button" @click="openColorCards()" class="cursor-pointer">
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
            <div role="button" @click="openBaseTypes()" class="cursor-pointer">
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
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Base Stock Management: opens management modal -->
            <div v-if="HasRole(['Admin','Manager'])" role="button" @click="openBaseStockManagement()" class="cursor-pointer lg:col-span-1">
              <div class="dashboard-card bg-[#059669] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-6 space-x-5">
                  <Package class="w-16 h-16 text-white shrink-0" />
                  <div>
                    <p class="text-white text-2xl font-extrabold uppercase">Base Stock</p>
                    <p class="text-white/90 text-base">Manage paint base inventory.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Colorance Stock: opens CRUD modal -->
            <div role="button" @click="openColorance()" class="cursor-pointer lg:col-span-1">
              <div class="dashboard-card bg-[#f59e0b] hover:-translate-y-1 transition-transform duration-200 rounded-2xl shadow-lg">
                <div class="flex items-start p-6 space-x-5">
                  <Package class="w-16 h-16 text-white shrink-0" />
                  <div>
                    <p class="text-white text-2xl font-extrabold uppercase">Colorant Stock</p>
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

  <!-- Paint Types CRUD modal (centered) -->
  <transition name="fade">
    <div v-if="isPaintTypesOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closePaintTypes"></div>

      <div
        class="relative z-10 w-11/12 md:w-[1100px] max-h-[85vh] overflow-y-auto rounded-2xl
               border-4 border-rose-500 bg-white text-gray-800"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold">Paint Types</h3>
            <div class="flex items-center gap-3">
              <input
                v-model="ptSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search paint types…"
              />
              <button @click="closePaintTypes" class="text-sm px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
            </div>
          </div>

          <!-- form -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div class="md:col-span-2">
              <label class="text-sm font-medium">Name</label>
              <input v-model="ptForm.name" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="e.g. Emulsion Paint" />
              <p v-if="ptForm.errors.name" class="text-red-500 text-sm mt-1">{{ ptForm.errors.name }}</p>
            </div>

            <div class="md:col-span-1 flex gap-3">
              <button v-if="!ptEditingId" @click="createPaintType" :disabled="ptForm.processing" class="px-5 py-2 rounded bg-rose-600 text-white hover:bg-rose-700 disabled:opacity-60">
                Add
              </button>
              <button v-else @click="updatePaintType" :disabled="ptForm.processing" class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-60">
                Update
              </button>
              <button v-if="ptEditingId" @click="resetPtEdit" class="px-5 py-2 rounded bg-gray-200 hover:bg-gray-100">
                Cancel Edit
              </button>
            </div>
          </div>

          <!-- list -->
          <div class="mt-6 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                  <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Name</th>
                  <th class="px-6 py-4 text-right text-base font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(row, i) in filteredPaintTypes" :key="row.id">
                  <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                  <td class="px-6 py-4 text-base font-medium">{{ row.name }}</td>
                  <td class="px-6 py-4">
                    <div class="flex justify-end gap-2">
                      <button @click="startPtEdit(row)" class="px-4 py-2 rounded-md text-white bg-emerald-500 hover:bg-emerald-600 text-sm">Edit</button>
                      <button @click="removePaintType(row)" class="px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 text-sm">Delete</button>
                    </div>
                  </td>
                </tr>
                <tr v-if="!filteredPaintTypes.length">
                  <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-base">No paint types found.</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </transition>

  <!-- Color Cards CRUD modal (centered) -->
  <transition name="fade">
    <div v-if="isColorCardsOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeColorCards"></div>

      <div
        class="relative z-10 w-11/12 md:w-[1100px] max-h-[85vh] overflow-y-auto rounded-2xl
               border-4 border-blue-500 bg-white text-gray-800"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold">Color Cards</h3>
            <div class="flex items-center gap-3">
              <input
                v-model="ccSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search color cards…"
              />
              <button @click="closeColorCards" class="text-sm px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
            </div>
          </div>

          <!-- form -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div class="md:col-span-2">
              <label class="text-sm font-medium">Name</label>
              <input v-model="ccForm.name" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="e.g. RAL 9001" />
              <p v-if="ccForm.errors.name" class="text-red-500 text-sm mt-1">{{ ccForm.errors.name }}</p>
            </div>

            <div class="md:col-span-1 flex gap-3">
              <button v-if="!ccEditingId" @click="createColorCard" :disabled="ccForm.processing" class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-60">
                Add
              </button>
              <button v-else @click="updateColorCard" :disabled="ccForm.processing" class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-60">
                Update
              </button>
              <button v-if="ccEditingId" @click="resetCcEdit" class="px-5 py-2 rounded bg-gray-200 hover:bg-gray-100">
                Cancel Edit
              </button>
            </div>
          </div>

          <!-- list -->
          <div class="mt-6 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                  <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Name</th>
                  <th class="px-6 py-4 text-right text-base font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(row, i) in filteredColorCards" :key="row.id">
                  <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                  <td class="px-6 py-4 text-base font-medium">{{ row.name }}</td>
                  <td class="px-6 py-4">
                    <div class="flex justify-end gap-2">
                      <button @click="startCcEdit(row)" class="px-4 py-2 rounded-md text-white bg-emerald-500 hover:bg-emerald-600 text-sm">Edit</button>
                      <button @click="removeColorCard(row)" class="px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 text-sm">Delete</button>
                    </div>
                  </td>
                </tr>
                <tr v-if="!filteredColorCards.length">
                  <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-base">No color cards found.</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </transition>

  <!-- Base Types CRUD modal (centered) -->
  <transition name="fade">
    <div v-if="isBaseTypesOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeBaseTypes"></div>

      <div
        class="relative z-10 w-11/12 md:w-[1100px] max-h-[85vh] overflow-y-auto rounded-2xl
               border-4 border-green-500 bg-white text-gray-800"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold">Base Types</h3>
            <div class="flex items-center gap-3">
              <input
                v-model="btSearch"
                type="text"
                class="w-72 rounded-md border border-gray-300 p-3"
                placeholder="Search base types…"
              />
              <button @click="closeBaseTypes" class="text-sm px-3 py-2 rounded bg-gray-100 hover:bg-gray-200">Close</button>
            </div>
          </div>

          <!-- form -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div class="md:col-span-2">
              <label class="text-sm font-medium">Name</label>
              <input v-model="btForm.name" type="text" class="w-full mt-1 rounded-md border border-gray-300 p-3" placeholder="e.g. Water Base" />
              <p v-if="btForm.errors.name" class="text-red-500 text-sm mt-1">{{ btForm.errors.name }}</p>
            </div>

            <div class="md:col-span-1 flex gap-3">
              <button v-if="!btEditingId" @click="createBaseType" :disabled="btForm.processing" class="px-5 py-2 rounded bg-green-600 text-white hover:bg-green-700 disabled:opacity-60">
                Add
              </button>
              <button v-else @click="updateBaseType" :disabled="btForm.processing" class="px-5 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-60">
                Update
              </button>
              <button v-if="btEditingId" @click="resetBtEdit" class="px-5 py-2 rounded bg-gray-200 hover:bg-gray-100">
                Cancel Edit
              </button>
            </div>
          </div>

          <!-- list -->
          <div class="mt-6 overflow-x-auto rounded-lg shadow">
            <table class="min-w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-500 to-blue-600 text-white uppercase tracking-wide">
                  <th class="px-6 py-4 text-left text-base font-semibold">#</th>
                  <th class="px-6 py-4 text-left text-base font-semibold">Name</th>
                  <th class="px-6 py-4 text-right text-base font-semibold">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="(row, i) in filteredBaseTypes" :key="row.id">
                  <td class="px-6 py-4 text-base">{{ i + 1 }}</td>
                  <td class="px-6 py-4 text-base font-medium">{{ row.name }}</td>
                  <td class="px-6 py-4">
                    <div class="flex justify-end gap-2">
                      <button @click="startBtEdit(row)" class="px-4 py-2 rounded-md text-white bg-emerald-500 hover:bg-emerald-600 text-sm">Edit</button>
                      <button @click="removeBaseType(row)" class="px-4 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 text-sm">Delete</button>
                    </div>
                  </td>
                </tr>
                <tr v-if="!filteredBaseTypes.length">
                  <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-base">No base types found.</td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </transition>

  <!-- Base Stock Management Modal -->
  <transition name="fade">
    <div v-if="baseStock.modalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black/50 z-0" @click="closeBaseStockModal"></div>

      <div
        class="relative z-10 w-11/12 xl:w-[1000px] max-h-[90vh] overflow-y-auto rounded-2xl
               border-4 border-emerald-600 bg-white text-gray-800 shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        role="dialog" aria-modal="true"
      >
        <div class="p-8">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-extrabold text-emerald-700">
              📦 Base Stock Management
            </h3>
            <button @click="closeBaseStockModal" class="text-sm px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
              Close
            </button>
          </div>

          <!-- Custom Notification -->
          <transition name="fade">
            <div v-if="baseStock.notification.show" class="mb-6">
              <div 
                :class="{
                  'bg-green-50 border border-green-200 text-green-800': baseStock.notification.type === 'success',
                  'bg-red-50 border border-red-200 text-red-800': baseStock.notification.type === 'error'
                }"
                class="rounded-lg p-4 flex items-center justify-between"
              >
                <div class="flex items-center">
                  <div 
                    :class="{
                      'text-green-500': baseStock.notification.type === 'success',
                      'text-red-500': baseStock.notification.type === 'error'
                    }"
                    class="mr-3"
                  >
                    <svg v-if="baseStock.notification.type === 'success'" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                  <span class="font-medium">{{ baseStock.notification.message }}</span>
                </div>
                <button 
                  @click="hideNotification"
                  :class="{
                    'text-green-500 hover:text-green-700': baseStock.notification.type === 'success',
                    'text-red-500 hover:text-red-700': baseStock.notification.type === 'error'
                  }"
                  class="ml-4"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                  </svg>
                </button>
              </div>
            </div>
          </transition>

          <!-- Tab Navigation -->
          <div class="mb-6">
            <div class="border-b border-gray-200">
              <nav class="-mb-px flex space-x-8">
                <button
                  @click="baseStock.activeTab = 'management'"
                  :class="{
                    'border-emerald-500 text-emerald-600': baseStock.activeTab === 'management',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': baseStock.activeTab !== 'management'
                  }"
                  class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                >
                  📦 Stock Management
                </button>
                <button
                  @click="baseStock.activeTab = 'history'"
                  :class="{
                    'border-emerald-500 text-emerald-600': baseStock.activeTab === 'history',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': baseStock.activeTab !== 'history'
                  }"
                  class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                >
                  📋 Transaction History
                </button>
              </nav>
            </div>
          </div>

          <!-- Management Tab -->
          <div v-show="baseStock.activeTab === 'management'">
            <!-- Add/Edit Form -->
          <div class="bg-gray-50 rounded-xl p-6 mb-6">
            <h4 class="text-lg font-bold mb-4 text-gray-700">
              {{ baseStock.editingId ? 'Edit Base Stock' : 'Add Base Stock' }}
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paint Product *</label>
                <select 
                  v-model.number="baseStock.form.paint_product_id" 
                  class="w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  :disabled="baseStock.processing"
                >
                  <option value="">Select paint product</option>
                  <option v-for="product in baseStock.paintProducts" :key="product.id" :value="product.id">
                    {{ product.name }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Base Type *</label>
                <select 
                  v-model.number="baseStock.form.base_type_id" 
                  class="w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  :disabled="baseStock.processing"
                >
                  <option value="">Select base type</option>
                  <option v-for="baseType in baseStock.baseTypes" :key="baseType.id" :value="baseType.id">
                    {{ baseType.name }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Can Size *</label>
                <select 
                  v-model="baseStock.form.can_size" 
                  class="w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  :disabled="baseStock.processing"
                >
                  <option value="">Select can size</option>
                  <option v-for="size in baseStock.canSizes" :key="size" :value="size">
                    {{ size }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input 
                  type="number" 
                  min="0" 
                  v-model.number="baseStock.form.quantity"
                  class="w-full rounded-md border border-gray-300 p-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  placeholder="Enter quantity"
                  :disabled="baseStock.processing"
                />
              </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6">
              <button 
                v-if="baseStock.editingId"
                @click="cancelEdit"
                class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors"
                :disabled="baseStock.processing"
              >
                Cancel
              </button>
              <button 
                @click="saveBaseStock"
                class="px-6 py-2 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 disabled:opacity-60 transition-colors"
                :disabled="baseStock.processing || !isFormValid"
              >
                <span v-if="baseStock.processing">{{ baseStock.editingId ? 'Updating...' : 'Saving...' }}</span>
                <span v-else>{{ baseStock.editingId ? 'Update' : 'Save' }}</span>
              </button>
            </div>
          </div>

          <!-- Base Stock List -->
          <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-4 border-b border-gray-200">
              <h4 class="text-lg font-bold text-gray-700">Current Base Stock</h4>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paint Product</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Base Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Can Size</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr v-if="baseStock.loading" class="text-center">
                    <td colspan="5" class="px-4 py-8 text-gray-500">Loading...</td>
                  </tr>
                  <tr v-else-if="baseStock.items.length === 0" class="text-center">
                    <td colspan="5" class="px-4 py-8 text-gray-500">No base stock items found</td>
                  </tr>
                  <tr v-else v-for="item in baseStock.items" :key="item.id" class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ item.paint_product?.name || 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm">{{ item.base_type?.name || 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm">
                      <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-md text-xs font-medium">
                        {{ item.can_size }}
                      </span>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium">{{ item.quantity }}</td>
                    <td class="px-4 py-3 text-sm">
                      <div class="flex gap-2">
                        <button 
                          @click="editBaseStock(item)"
                          class="px-3 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md text-xs transition-colors"
                        >
                          Edit
                        </button>
                        <button 
                          @click="deleteBaseStock(item.id)"
                          class="px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md text-xs transition-colors"
                          :disabled="baseStock.processing"
                        >
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          </div>

          <!-- History Tab -->
          <div v-show="baseStock.activeTab === 'history'">
            <div class="bg-white rounded-xl border">
              <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between mb-4">
                  <div>
                    <h4 class="text-lg font-bold text-gray-700">Base Stock Transaction History</h4>
                    <p class="text-sm text-gray-500 mt-1">Track all stock changes and order completions</p>
                  </div>
                  <button
                    @click="downloadTransactionHistoryPDF"
                    :disabled="baseStock.transactionHistory.downloading || !baseStock.transactionHistory.items.length"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2"
                  >
                    <svg v-if="baseStock.transactionHistory.downloading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg v-else class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ baseStock.transactionHistory.downloading ? 'Generating...' : 'Download PDF' }}</span>
                  </button>
                </div>
                
                <!-- Date Range Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input
                      v-model="baseStock.transactionHistory.filters.dateFrom"
                      type="date"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                      @change="loadTransactionHistory(1)"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input
                      v-model="baseStock.transactionHistory.filters.dateTo"
                      type="date"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                      @change="loadTransactionHistory(1)"
                    >
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Stock Item</label>
                    <select
                      v-model="baseStock.transactionHistory.filters.baseStockId"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                      @change="loadTransactionHistory(1)"
                    >
                      <option value="">All Items</option>
                      <option v-for="item in baseStock.items" :key="item.id" :value="item.id">
                        {{ item.paint_product?.name }} - {{ item.base_type?.name }} ({{ item.can_size }})
                      </option>
                    </select>
                  </div>
                  <div class="flex items-end">
                    <button
                      @click="clearHistoryFilters"
                      class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors"
                    >
                      Clear Filters
                    </button>
                  </div>
                </div>
              </div>
              
              <!-- Transaction History Table -->
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date & Time</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Product Details</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Transaction</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Performed By</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="baseStock.transactionHistory.loading">
                      <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        <div class="flex items-center justify-center">
                          <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-500"></div>
                          <span class="ml-2">Loading transactions...</span>
                        </div>
                      </td>
                    </tr>
                    <tr v-else-if="!baseStock.transactionHistory.items.length">
                      <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        No transaction history found
                      </td>
                    </tr>
                    <tr v-else v-for="transaction in baseStock.transactionHistory.items" :key="transaction.id" class="hover:bg-gray-50">
                      <td class="px-4 py-3 text-sm text-gray-900">
                        {{ new Date(transaction.created_at).toLocaleString() }}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <div>
                          <div class="font-medium text-gray-900">{{ transaction.base_stock?.paint_product?.name }}</div>
                          <div class="text-gray-500">{{ transaction.base_stock?.base_type?.name }} - {{ transaction.base_stock?.can_size }}</div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <div class="flex items-center">
                          <span 
                            :class="{
                              'text-red-600': transaction.transaction_type === 'reduction',
                              'text-green-600': transaction.transaction_type === 'addition',
                              'text-blue-600': transaction.transaction_type === 'adjustment'
                            }"
                            class="font-bold text-lg mr-2"
                          >
                            {{ transaction.transaction_type === 'reduction' ? '↓' : transaction.transaction_type === 'addition' ? '↑' : '~' }}
                          </span>
                          <span class="capitalize">{{ transaction.transaction_type }}</span>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <div>
                          <div class="text-gray-900">{{ transaction.quantity_before }} → {{ transaction.quantity_after }}</div>
                          <div 
                            :class="{
                              'text-red-600': transaction.transaction_type === 'reduction',
                              'text-green-600': transaction.transaction_type === 'addition',
                              'text-blue-600': transaction.transaction_type === 'adjustment'
                            }"
                            class="text-xs font-medium"
                          >
                            {{ transaction.transaction_type === 'reduction' ? '-' : '+' }}{{ Math.abs(transaction.quantity_changed) }}
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <div v-if="transaction.paint_order_id">
                          <div class="text-blue-600 font-medium">#{{ transaction.paint_order_id }}</div>
                          <div class="text-gray-500 text-xs">{{ transaction.paint_order?.product_name }}</div>
                        </div>
                        <span v-else class="text-gray-400">Manual</span>
                      </td>
                      <td class="px-4 py-3 text-sm text-gray-900">
                        {{ transaction.performed_by || 'System' }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <!-- Pagination -->
              <div v-if="baseStock.transactionHistory.pagination.total > baseStock.transactionHistory.pagination.per_page" 
                   class="px-6 py-3 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                  Showing {{ (baseStock.transactionHistory.pagination.current_page - 1) * baseStock.transactionHistory.pagination.per_page + 1 }} 
                  to {{ Math.min(baseStock.transactionHistory.pagination.current_page * baseStock.transactionHistory.pagination.per_page, baseStock.transactionHistory.pagination.total) }} 
                  of {{ baseStock.transactionHistory.pagination.total }} transactions
                </div>
                <div class="flex space-x-2">
                  <button 
                    @click="loadTransactionHistory(baseStock.transactionHistory.pagination.current_page - 1)"
                    :disabled="baseStock.transactionHistory.pagination.current_page <= 1"
                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    Previous
                  </button>
                  <button 
                    @click="loadTransactionHistory(baseStock.transactionHistory.pagination.current_page + 1)"
                    :disabled="baseStock.transactionHistory.pagination.current_page >= baseStock.transactionHistory.pagination.last_page"
                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    Next
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <!-- ===================================================== -->
  <!-- Enhanced Alert Modal (replaces window.alert visually) -->
  <!-- ===================================================== -->
  <transition name="fade">
    <div v-if="centerAlert.open" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/50" @click="closeCenterAlert"></div>
      <div
        class="relative z-10 w-full max-w-md rounded-2xl bg-white border-4 shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        :class="centerAlert.type === 'success' ? 'border-emerald-500' : centerAlert.type === 'error' ? 'border-red-500' : centerAlert.type === 'warning' ? 'border-amber-500' : 'border-blue-500'"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-start gap-4">
            <!-- Icon based on alert type -->
            <div class="flex-shrink-0">
              <svg v-if="centerAlert.type === 'success'" class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <svg v-else-if="centerAlert.type === 'error'" class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <svg v-else-if="centerAlert.type === 'warning'" class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
              <svg v-else class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            
            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-bold text-gray-900 mb-2"
                  :class="centerAlert.type === 'success' ? 'text-emerald-700' : centerAlert.type === 'error' ? 'text-red-700' : centerAlert.type === 'warning' ? 'text-amber-700' : 'text-blue-700'">
                {{ centerAlert.title }}
              </h3>
              <div class="text-sm text-gray-700 leading-relaxed" v-html="centerAlert.safeHtml"></div>
            </div>
          </div>
          
          <div class="mt-6 flex justify-end gap-3">
            <button
              @click="closeCenterAlert"
              class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
              :class="centerAlert.type === 'success' 
                ? 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500' 
                : centerAlert.type === 'error' 
                ? 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500' 
                : centerAlert.type === 'warning'
                ? 'bg-amber-600 hover:bg-amber-700 text-white focus:ring-amber-500'
                : 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500'"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <!-- ===================================================== -->
  <!-- Custom Confirm Dialog (replaces window.confirm)     -->
  <!-- ===================================================== -->
  <transition name="fade">
    <div v-if="confirmDialog.open" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/50" @click="cancelConfirm"></div>
      <div
        class="relative z-10 w-full max-w-md rounded-2xl bg-white border-4 border-amber-500 shadow-[0_25px_50px_rgba(0,0,0,.5)]"
        role="dialog" aria-modal="true"
      >
        <div class="p-6">
          <div class="flex items-start gap-4">
            <!-- Warning Icon -->
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            
            <div class="flex-1 min-w-0">
              <h3 class="text-lg font-bold text-amber-700 mb-2">
                Confirm Action
              </h3>
              <div class="text-sm text-gray-700 leading-relaxed" v-html="confirmDialog.safeHtml"></div>
            </div>
          </div>
          
          <div class="mt-6 flex justify-end gap-3">
            <button
              @click="cancelConfirm"
              class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-400"
            >
              Cancel
            </button>
            <button
              @click="acceptConfirm"
              class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 bg-red-600 hover:bg-red-700 text-white focus:ring-red-500"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount, reactive } from 'vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/custom/Header.vue'
import Footer from '@/Components/custom/Footer.vue'
import Banner from '@/Components/Banner.vue'
import { HasRole } from '@/Utils/Permissions'
import { Paintbrush, Palette, Layers, Package, Droplet, ShoppingCart } from 'lucide-vue-next'
import axios from 'axios'

// Completely suppress console errors for expected validation responses
const originalConsoleError = console.error
const originalConsoleWarn = console.warn
const originalConsoleLog = console.log

// Override console methods to filter out all axios/HTTP related errors
console.error = function(...args) {
  const message = String(args[0] || '')
  const fullMessage = args.join(' ').toLowerCase()
  
  // Filter out any HTTP errors, axios errors, or base-stocks related errors
  if (
    message.includes('422') || 
    message.includes('Request failed') || 
    message.includes('base-stocks') ||
    message.includes('HTTP') ||
    message.includes('http') ||
    fullMessage.includes('unprocessable') ||
    fullMessage.includes('content') ||
    args.some(arg => arg && typeof arg === 'object' && arg.status === 422)
  ) {
    return // Completely suppress these errors
  }
  originalConsoleError.apply(console, args)
}

console.warn = function(...args) {
  const message = String(args[0] || '')
  if (message.includes('base-stocks') || message.includes('422') || message.includes('HTTP')) {
    return
  }
  originalConsoleWarn.apply(console, args)
}

// Create custom axios instance for base stock operations
const baseStockApi = axios.create({
  validateStatus: function (status) {
    // Accept all status codes to prevent axios from throwing
    return true
  }
})

const props = defineProps({
  coloranceStocks: { type: Array, default: () => [] },
  machineHistory:  { type: Array, default: () => [] },
  orders:          { type: Array, default: () => [] }, // ok if unused here
  paintTypes:      { type: Array, default: () => [] },
  colorCards:      { type: Array, default: () => [] },
  baseTypes:       { type: Array, default: () => [] },
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
function removeColorance(row){ showConfirm(`Delete "${row.name}" (${row.can_size})?`).then(confirmed => { if(confirmed) router.delete(route('paints.colorance-stocks.destroy', row.id), { preserveScroll:true, onSuccess:()=>{ router.reload({only:['coloranceStocks']}); isColoranceOpen.value=true; }}) }) }

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

/* ------------- Paint Types CRUD modal ------------- */
const isPaintTypesOpen = ref(false)
const ptForm = useForm({ name: '' })
const ptEditingId = ref(null)

const ptSearch = ref('')
const filteredPaintTypes = computed(() => {
  const q = ptSearch.value.trim().toLowerCase()
  if (!q) return props.paintTypes
  return props.paintTypes.filter(s =>
    (s.name||'').toLowerCase().includes(q)
  )
})

function openPaintTypes() { resetPtEdit(); isPaintTypesOpen.value = true }
function closePaintTypes() { isPaintTypesOpen.value = false; resetPtEdit() }
function resetPtEdit() { ptEditingId.value = null; ptForm.reset('name'); ptForm.clearErrors() }
function startPtEdit(row) { ptEditingId.value = row.id; ptForm.name = row.name }
function createPaintType() { 
  ptForm.post(route('paints.types.store'), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['paintTypes']}); 
      resetPtEdit(); 
      isPaintTypesOpen.value = true; 
    }
  }) 
}
function updatePaintType() { 
  if (!ptEditingId.value) return; 
  ptForm.put(route('paints.types.update', ptEditingId.value), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['paintTypes']}); 
      resetPtEdit(); 
      isPaintTypesOpen.value = true; 
    }
  }) 
}
function removePaintType(row) { 
  showConfirm(`Delete "${row.name}"?`).then(confirmed => {
    if (confirmed) {
      router.delete(route('paints.types.destroy', row.id), { 
        preserveScroll: true, 
        onSuccess: () => { 
          router.reload({only: ['paintTypes']}); 
          isPaintTypesOpen.value = true; 
        }
      })
    }
  })
}

/* ------------- Color Cards CRUD modal ------------- */
const isColorCardsOpen = ref(false)
const ccForm = useForm({ name: '' })
const ccEditingId = ref(null)

const ccSearch = ref('')
const filteredColorCards = computed(() => {
  const q = ccSearch.value.trim().toLowerCase()
  if (!q) return props.colorCards
  return props.colorCards.filter(s =>
    (s.name||'').toLowerCase().includes(q)
  )
})

function openColorCards() { resetCcEdit(); isColorCardsOpen.value = true }
function closeColorCards() { isColorCardsOpen.value = false; resetCcEdit() }
function resetCcEdit() { ccEditingId.value = null; ccForm.reset('name'); ccForm.clearErrors() }
function startCcEdit(row) { ccEditingId.value = row.id; ccForm.name = row.name }
function createColorCard() { 
  ccForm.post(route('paints.color-cards.store'), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['colorCards']}); 
      resetCcEdit(); 
      isColorCardsOpen.value = true; 
    }
  }) 
}
function updateColorCard() { 
  if (!ccEditingId.value) return; 
  ccForm.put(route('paints.color-cards.update', ccEditingId.value), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['colorCards']}); 
      resetCcEdit(); 
      isColorCardsOpen.value = true; 
    }
  }) 
}
function removeColorCard(row) { 
  showConfirm(`Delete "${row.name}"?`).then(confirmed => {
    if (confirmed) {
      router.delete(route('paints.color-cards.destroy', row.id), { 
        preserveScroll: true, 
        onSuccess: () => { 
          router.reload({only: ['colorCards']}); 
          isColorCardsOpen.value = true; 
        }
      })
    }
  })
}

/* ------------- Base Types CRUD modal ------------- */
const isBaseTypesOpen = ref(false)
const btForm = useForm({ name: '' })
const btEditingId = ref(null)

const btSearch = ref('')
const filteredBaseTypes = computed(() => {
  const q = btSearch.value.trim().toLowerCase()
  if (!q) return props.baseTypes
  return props.baseTypes.filter(s =>
    (s.name||'').toLowerCase().includes(q)
  )
})

function openBaseTypes() { resetBtEdit(); isBaseTypesOpen.value = true }
function closeBaseTypes() { isBaseTypesOpen.value = false; resetBtEdit() }
function resetBtEdit() { btEditingId.value = null; btForm.reset('name'); btForm.clearErrors() }
function startBtEdit(row) { btEditingId.value = row.id; btForm.name = row.name }
function createBaseType() { 
  btForm.post(route('paints.base-types.store'), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['baseTypes']}); 
      resetBtEdit(); 
      isBaseTypesOpen.value = true; 
    }
  }) 
}
function updateBaseType() { 
  if (!btEditingId.value) return; 
  btForm.put(route('paints.base-types.update', btEditingId.value), { 
    preserveScroll: true, 
    onSuccess: () => { 
      router.reload({only: ['baseTypes']}); 
      resetBtEdit(); 
      isBaseTypesOpen.value = true; 
    }
  }) 
}
function removeBaseType(row) { 
  showConfirm(`Delete "${row.name}"?`).then(confirmed => {
    if (confirmed) {
      router.delete(route('paints.base-types.destroy', row.id), { 
        preserveScroll: true, 
        onSuccess: () => { 
          router.reload({only: ['baseTypes']}); 
          isBaseTypesOpen.value = true; 
        }
      })
    }
  })
}

/* --------------------------- */
/* Enhanced alert replacement  */
/* --------------------------- */
const centerAlert = reactive({
  open: false,
  message: '',
  safeHtml: '',
  type: 'info', // 'success', 'error', 'warning', 'info'
  title: 'Alert',
})

/* --------------------------- */
/* Custom confirm dialog       */
/* --------------------------- */
const confirmDialog = reactive({
  open: false,
  message: '',
  safeHtml: '',
  resolve: null,
})

let _origAlert = null
let _origConfirm = null

function toSafeHtml(text) {
  const esc = String(text ?? '').replace(/[&<>"']/g, c => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[c]))
  return esc.replace(/\n/g, '<br>')
}

function closeCenterAlert() {
  centerAlert.open = false
}

function cancelConfirm() {
  confirmDialog.open = false
  if (confirmDialog.resolve) {
    confirmDialog.resolve(false)
    confirmDialog.resolve = null
  }
}

function acceptConfirm() {
  confirmDialog.open = false
  if (confirmDialog.resolve) {
    confirmDialog.resolve(true)
    confirmDialog.resolve = null
  }
}

// Enhanced alert function that can determine type from message content
function showAlert(message, type = null) {
  const msg = String(message ?? '')
  centerAlert.message = msg
  centerAlert.safeHtml = toSafeHtml(msg)
  
  // Auto-detect type if not provided
  if (!type) {
    if (msg.includes('✅') || msg.toLowerCase().includes('success')) {
      centerAlert.type = 'success'
      centerAlert.title = 'Success'
    } else if (msg.includes('❌') || msg.toLowerCase().includes('error') || msg.toLowerCase().includes('failed')) {
      centerAlert.type = 'error'
      centerAlert.title = 'Error'
    } else if (msg.includes('⚠️') || msg.toLowerCase().includes('warning') || msg.toLowerCase().includes('insufficient')) {
      centerAlert.type = 'warning'
      centerAlert.title = 'Warning'
    } else {
      centerAlert.type = 'info'
      centerAlert.title = 'Information'
    }
  } else {
    centerAlert.type = type
    centerAlert.title = type.charAt(0).toUpperCase() + type.slice(1)
  }
  
  centerAlert.open = true
}

// Custom confirm function that returns a Promise
function showConfirm(message) {
  return new Promise((resolve) => {
    const msg = String(message ?? '')
    confirmDialog.message = msg
    confirmDialog.safeHtml = toSafeHtml(msg)
    confirmDialog.resolve = resolve
    confirmDialog.open = true
  })
}

function keyHandler(e){
  if (centerAlert.open) {
    if (e.key === 'Escape' || e.key === 'Enter' || e.key === ' ') {
      e.preventDefault()
      closeCenterAlert()
    }
  } else if (confirmDialog.open) {
    if (e.key === 'Escape') {
      e.preventDefault()
      cancelConfirm()
    } else if (e.key === 'Enter') {
      e.preventDefault()
      acceptConfirm()
    }
  }
}

/* ------------- Base Stock Management ------------- */
const baseStock = ref({
  modalOpen: false,
  loading: false,
  processing: false,
  editingId: null,
  activeTab: 'management', // 'management' or 'history'
  items: [],
  paintProducts: [],
  baseTypes: [],
  canSizes: ['1L', '4L', '10L'],
  notification: {
    show: false,
    type: 'success', // 'success', 'error'
    message: ''
  },
  form: {
    paint_product_id: '',
    base_type_id: '',
    can_size: '',
    quantity: 0
  },
  transactionHistory: {
    loading: false,
    items: [],
    pagination: {
      current_page: 1,
      last_page: 1,
      per_page: 20,
      total: 0
    },
    filters: {
      dateFrom: '',
      dateTo: '',
      baseStockId: ''
    },
    downloading: false
  }
})

const isFormValid = computed(() => {
  return baseStock.value.form.paint_product_id && 
         baseStock.value.form.base_type_id && 
         baseStock.value.form.can_size && 
         baseStock.value.form.quantity > 0
})

async function openBaseStockManagement() {
  baseStock.value.modalOpen = true
  baseStock.value.activeTab = 'management'
  
  // Set initial data from props
  baseStock.value.paintProducts = props.paintTypes || []
  baseStock.value.baseTypes = props.baseTypes || []
  
  await loadBaseStockData()
  await loadDropdownData()
  await loadTransactionHistory()
}

function closeBaseStockModal() {
  baseStock.value.modalOpen = false
  resetBaseStockForm()
  hideNotification()
}

function showNotification(type, message) {
  baseStock.value.notification = {
    show: true,
    type: type,
    message: message
  }
  
  // Auto hide success notifications after 3 seconds
  if (type === 'success') {
    setTimeout(() => {
      hideNotification()
    }, 3000)
  }
}

function hideNotification() {
  baseStock.value.notification.show = false
}

function resetBaseStockForm() {
  baseStock.value.editingId = null
  baseStock.value.form = {
    paint_product_id: '',
    base_type_id: '',
    can_size: '',
    quantity: 0
  }
  hideNotification()
}

async function loadBaseStockData() {
  try {
    baseStock.value.loading = true
    const response = await baseStockApi.get('/base-stocks')
    
    // Handle different response formats
    if (response.data && response.data.data && Array.isArray(response.data.data)) {
      baseStock.value.items = response.data.data
    } else if (response.data && Array.isArray(response.data)) {
      baseStock.value.items = response.data
    } else {
      baseStock.value.items = []
    }
  } catch (error) {
    baseStock.value.items = []
    
    // Only log unexpected errors (not 404 which is normal for empty data)
    if (error.response?.status !== 404) {
      console.error('Error loading base stock data:', error)
      showNotification('error', 'Unable to load base stock data. Please refresh the page.')
    }
  } finally {
    baseStock.value.loading = false
  }
}

async function loadDropdownData() {
  try {
    const response = await baseStockApi.get('/base-stocks/dropdown-data')
    baseStock.value.paintProducts = response.data.paintProducts || []
    baseStock.value.baseTypes = response.data.baseTypes || []
  } catch (error) {
    // Only log unexpected errors, silently fallback for expected issues
    if (error.response?.status >= 500) {
      console.error('Server error loading dropdown data:', error)
    }
    
    // Fallback to props data if API fails
    baseStock.value.paintProducts = props.paintTypes || []
    baseStock.value.baseTypes = props.baseTypes || []
  }
}

async function saveBaseStock() {
  if (!isFormValid.value) {
    showNotification('error', 'Please fill in all required fields')
    return
  }
  
  try {
    baseStock.value.processing = true
    hideNotification()
    
    let response
    if (baseStock.value.editingId) {
      // Update existing
      response = await baseStockApi.put(`/base-stocks/${baseStock.value.editingId}`, baseStock.value.form)
    } else {
      // Create new
      response = await baseStockApi.post('/base-stocks', baseStock.value.form)
    }
    
    // Check response status since validateStatus accepts all codes
    if (response.status >= 200 && response.status < 300) {
      // Success
      if (baseStock.value.editingId) {
        showNotification('success', 'Base stock updated successfully!')
      } else {
        showNotification('success', 'Base stock added successfully!')
      }
      await loadBaseStockData()
      
      // Refresh transaction history if it's been loaded
      if (baseStock.value.transactionHistory.items.length > 0) {
        await loadTransactionHistory()
      }
      
      resetBaseStockForm()
    } else if (response.status === 422) {
      // Validation error
      let errorMessage = 'Please check your input and try again.'
      
      if (response.data?.errors) {
        const errors = Object.values(response.data.errors).flat()
        errorMessage = errors.join(', ')
      } else if (response.data?.message) {
        errorMessage = response.data.message
      }
      
      showNotification('error', errorMessage)
    } else {
      // Other error
      showNotification('error', 'Operation failed. Please try again.')
    }
    
  } catch (error) {
    // This should rarely happen with validateStatus: true
    showNotification('error', 'Network error. Please check your connection.')
  } finally {
    baseStock.value.processing = false
  }
}

function editBaseStock(item) {
  baseStock.value.editingId = item.id
  baseStock.value.form = {
    paint_product_id: item.paint_product_id,
    base_type_id: item.base_type_id,
    can_size: item.can_size,
    quantity: item.quantity
  }
}

function cancelEdit() {
  resetBaseStockForm()
}

async function deleteBaseStock(id) {
  const confirmed = await showConfirm('Are you sure you want to delete this base stock item?')
  if (!confirmed) return
  
  try {
    baseStock.value.processing = true
    hideNotification()
    
    const response = await baseStockApi.delete(`/base-stocks/${id}`)
    
    // Check response status since validateStatus accepts all codes
    if (response.status >= 200 && response.status < 300) {
      await loadBaseStockData()
      showNotification('success', 'Base stock item deleted successfully!')
    } else {
      let errorMessage = 'Failed to delete base stock item. '
      
      if (response.status === 404) {
        errorMessage = 'Item not found. It may have already been deleted.'
      } else if (response.data?.message) {
        errorMessage = response.data.message
      } else {
        errorMessage = 'Please try again.'
      }
      
      showNotification('error', errorMessage)
    }
  } catch (error) {
    // Network error
    showNotification('error', 'Network error. Please check your connection.')
  } finally {
    baseStock.value.processing = false
  }
}

async function loadTransactionHistory(page = 1) {
  try {
    baseStock.value.transactionHistory.loading = true
    
    // Build query parameters
    const params = new URLSearchParams({
      page: page,
      per_page: 20
    })
    
    if (baseStock.value.transactionHistory.filters.dateFrom) {
      params.append('date_from', baseStock.value.transactionHistory.filters.dateFrom)
    }
    
    if (baseStock.value.transactionHistory.filters.dateTo) {
      params.append('date_to', baseStock.value.transactionHistory.filters.dateTo)
    }
    
    if (baseStock.value.transactionHistory.filters.baseStockId) {
      params.append('base_stock_id', baseStock.value.transactionHistory.filters.baseStockId)
    }
    
    const response = await baseStockApi.get(`/base-stocks/transactions?${params.toString()}`)
    
    if (response.status >= 200 && response.status < 300) {
      baseStock.value.transactionHistory.items = response.data.data || []
      baseStock.value.transactionHistory.pagination = response.data.pagination || {
        current_page: 1,
        last_page: 1,
        per_page: 20,
        total: 0
      }
    }
  } catch (error) {
    console.error('Error loading transaction history:', error)
    baseStock.value.transactionHistory.items = []
  } finally {
    baseStock.value.transactionHistory.loading = false
  }
}

function clearHistoryFilters() {
  baseStock.value.transactionHistory.filters.dateFrom = ''
  baseStock.value.transactionHistory.filters.dateTo = ''
  baseStock.value.transactionHistory.filters.baseStockId = ''
  loadTransactionHistory(1)
}

async function downloadTransactionHistoryPDF() {
  try {
    baseStock.value.transactionHistory.downloading = true
    
    // Build query parameters for download
    const params = new URLSearchParams()
    
    if (baseStock.value.transactionHistory.filters.dateFrom) {
      params.append('date_from', baseStock.value.transactionHistory.filters.dateFrom)
    }
    
    if (baseStock.value.transactionHistory.filters.dateTo) {
      params.append('date_to', baseStock.value.transactionHistory.filters.dateTo)
    }
    
    if (baseStock.value.transactionHistory.filters.baseStockId) {
      params.append('base_stock_id', baseStock.value.transactionHistory.filters.baseStockId)
    }
    
    // Open download URL in a new window/tab
    const downloadUrl = `/base-stocks/transactions/download-pdf?${params.toString()}`
    window.open(downloadUrl, '_blank')
    
    showNotification('success', 'Transaction history report opened in new tab!')
  } catch (error) {
    console.error('Error downloading PDF:', error)
    showNotification('error', 'Error opening report. Please try again.')
  } finally {
    baseStock.value.transactionHistory.downloading = false
  }
}

// Watch for tab changes to load data when needed
watch(() => baseStock.value.activeTab, (newTab) => {
  if (newTab === 'history' && baseStock.value.transactionHistory.items.length === 0) {
    loadTransactionHistory()
  }
})

// Setup enhanced alert system
onMounted(() => {
  // Save originals, then override window.alert and window.confirm
  _origAlert = window.alert
  _origConfirm = window.confirm
  window.alert = showAlert
  window.confirm = showConfirm
  window.addEventListener('keydown', keyHandler)
})

onBeforeUnmount(() => {
  if (_origAlert) window.alert = _origAlert
  if (_origConfirm) window.confirm = _origConfirm
  window.removeEventListener('keydown', keyHandler)
})
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { 
  transition: all .25s ease; 
}
.fade-enter-from, .fade-leave-to { 
  opacity: 0; 
  transform: scale(0.95);
}
</style>
