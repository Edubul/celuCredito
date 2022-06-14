<template>
  <div>
    <Head title="Gastos" />
    <h1 class="mb-8 text-3xl font-bold">Gastos de empleados</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Buscar por:</label>
        <select v-model="form.opcion" class="form-select mt-1 w-full">
          <option value="empleado">Empleado</option>

        </select>
      </search-filter>
      <Link class="btn-indigo" href="/gastos/create">
        <span>Crear</span>
        <span class="hidden md:inline">&nbsp;Gasto</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Empleado</th>
            <th class="pb-4 pt-6 px-6">Motivo</th>
            <th class="pb-4 pt-6 px-6">Cantidad</th>
            <th class="pb-4 pt-6 px-6">Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="gasto in gastos.data" :key="gasto.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/gastos/${gasto.id}/edit`">
                {{ gasto.user.first_name }} {{ gasto.user.last_name }}
                <!-- <icon v-if="organization.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" /> -->
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1"> {{ gasto.motivo }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1"> $ {{ price.format(gasto.cantidad) }} </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1">
                {{ gasto.fecha }}
              </Link>
            </td>

            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="gastos.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No hay gastos encontrados.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="gastos.links" />
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
    filters: Object,
    gastos: Object,
  },
  data() {
    let price = Intl.NumberFormat('en-US')

    return {
      price,
      form: {
        search: this.filters.search,
        role: this.filters.role,
        opcion: this.filters.opcion,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/gastos', pickBy(this.form), { preserveState: true })
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
