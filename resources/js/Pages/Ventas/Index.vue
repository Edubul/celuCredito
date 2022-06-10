<template>
  <div>
    <Head title="Ventas" />
    <h1 class="mb-8 text-3xl font-bold">Ventas</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/ventas/create">
        <span>Crear</span>
        <span class="hidden md:inline"> Venta</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Modelo</th>
            <th class="pb-4 pt-6 px-6">Marca</th>
            <th class="pb-4 pt-6 px-6">IMEI</th>
            <th class="pb-4 pt-6 px-6">Nombre del cliente</th>
            <th class="pb-4 pt-6 px-6">Numero celular</th>
            <th class="pb-4 pt-6 px-6">CC</th>
            <th class="pb-4 pt-6 px-6">Precio</th>
            <th class="pb-4 pt-6 px-6">Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="venta in ventas.data" :key="venta.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/ventas/${venta.id}/edit`">
                {{ venta.modelo }}
                <!-- <icon v-if="organization.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" /> -->
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.name }}</Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.imei }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.nombre_cliente }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.numero_celular_cliente }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.cc_cliente }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ price.format(venta.precio) }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1"> {{ venta.fecha }} </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/ventas/${venta.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="ventas.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No hay ventas encontradas.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="ventas.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    // filters: Object,
    ventas: Object,
  },
  data() {
      const price = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
    })
    return {
      price,
      form: {
        // search: this.filters.search,
        // trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/organizations', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
