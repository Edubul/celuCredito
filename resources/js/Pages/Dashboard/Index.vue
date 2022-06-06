<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <div class="mt-4">
      <div class="flex flex-wrap -mx-6">
        <div class="px-6 w-full sm:w-1/2 xl:w-1/3">
          <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
            <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-full"></div>

            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">{{ price.format(totalGastosHoy) }}</h4>
              <div class="text-gray-500">Gastos</div>
            </div>
          </div>
        </div>

        <div class="mt-6 px-6 w-full sm:mt-0 sm:w-1/2 xl:w-1/3">
          <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
            <div class="p-3 bg-orange-600 bg-opacity-75 rounded-full"></div>

            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">{{ price.format(totalVentasHoy) }}</h4>
              <div class="text-gray-500">Ventas</div>
            </div>
          </div>
        </div>

        <div class="mt-6 px-6 w-full sm:w-1/2 xl:mt-0 xl:w-1/3">
          <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
            <div class="p-3 bg-green-600 bg-opacity-75 rounded-full"></div>

            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">{{ totalCelulares }}</h4>
              <div class="text-gray-500">Celulares</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <div class="flex flex-wrap -mx-6">
        <div class="mt-6 px-6 w-full sm:mt-0 sm:w-1/2 xl:w-1/3">
          <Link class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm" :href="'gastos/create'">
            <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-full"></div>

            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">Crear Gasto</h4>
              <div class="text-gray-400 text-sm">Crea un nuevo gasto</div>
            </div>
          </Link>
        </div>
        <div class="px-6 w-full sm:w-1/2 xl:w-1/3">
          <Link class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm" :href="'ventas/create'">
            <div class="p-3 bg-orange-600 bg-opacity-75 rounded-full"></div>

            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">Crear venta</h4>
              <div class="text-gray-400 text-sm">Crea una nueva venta</div>
            </div>
          </Link>
        </div>

        <div class="pointer mt-6 px-6 w-full sm:w-1/2 xl:mt-0 xl:w-1/3">
          <Link class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm" @click="downloadPDF">
            <div class="p-3 bg-green-600 bg-opacity-75 rounded-full"></div>
            <div class="mx-5">
              <h4 class="text-gray-700 text-2xl font-semibold">Crear reporte</h4>
              <div class="text-gray-400 text-sm">Generar reporte</div>
            </div>
          </Link>
        </div>
      </div>
    </div>

    <!-- card -->
    <div class="flex items-center justify-between mb-4 mt-4">
      <Datepicker v-model="date" :enableTimePicker="false" :format="formatter" placeholder="Start Typing ..." textInput />
    </div>
    <div class="w-auto">
      <h1 class="p-4 text-2xl font-bold">Ventas</h1>
      <div class="bg-white rounded-md shadow overflow-x-auto">
        <table id="pdf-content" class="w-full whitespace-nowrap">
          <thead>
            <tr class="text-left font-bold">
              <th class="pb-4 pt-6 px-6">Modelo</th>
              <th class="pb-4 pt-6 px-6">Marca</th>
              <th class="pb-4 pt-6 px-6">Cantidad</th>
              <th class="pb-4 pt-6 px-6">Total</th>
              <th class="pb-4 pt-6 px-6">Fecha</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="resumen in resumenToday.data" :key="resumen.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="px-6 py-4 border-t">
                {{ resumen.modelo }}
              </td>
              <td class="px-6 py-4 border-t">
                {{ resumen.name }}
              </td>
              <td class="px-6 py-4 border-t">
                {{ resumen.totalVendidos }}
              </td>
              <td class="px-6 py-4 border-t">{{ price.format(resumen.precioTotal) }}</td>
              <td class="px-6 py-4 border-t">{{ resumen.fecha }}</td>
            </tr>
            <tr v-if="resumenToday.data.length === 0">
              <td class="px-6 py-4 border-t" colspan="4">No hay ventas encontradas..</td>
            </tr>
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="px-6 py-4 text-xl font-bold border-t">
                Total Ventas:
                {{ price.format(totalVentasHoy) }}
              </td>
              <td class="px-6 py-4 border-t"></td>
              <td class="px-6 py-4 border-t"></td>
              <td class="px-6 py-4 border-t"></td>
              <td class="px-6 py-4 border-t"></td>
            </tr>
            <!-- <pdf src=""></pdf> -->
          </tbody>
        </table>
      </div>

      <h1 class="p-4 text-2xl font-bold">Gastos</h1>
      <div class="bg-white rounded-md shadow overflow-x-auto">
        <table id="pdf-content2" class="w-full whitespace-nowrap">
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
                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/gastos/${gasto.id}/edit`"> {{ gasto.user.first_name }} {{ gasto.user.last_name }} </Link>
              </td>
              <td class="border-t">
                <Link class="flex items-center px-6 py-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1"> {{ gasto.motivo }} </Link>
              </td>
              <td class="border-t">
                <Link class="flex items-center px-6 py-4" :href="`/gastos/${gasto.id}/edit`" tabindex="-1"> {{ price.format(gasto.cantidad) }} </Link>
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
              <td class="px-6 py-4 border-t" colspan="4">No se encontraron gastos...</td>
            </tr>
            <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
              <td class="px-6 py-4 text-xl font-bold border-t">
                Total Gastos:
                {{ price.format(totalGastosHoy) }}
              </td>
              <td class="px-6 py-4 border-t"></td>
              <td class="px-6 py-4 border-t"></td>
              <td class="px-6 py-4 border-t"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import { watch, ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { Inertia } from '@inertiajs/inertia'
import { jsPDF } from 'jspdf'
import autoTable from 'jspdf-autotable'

export default {
  components: {
    Head,
    Link,
    Datepicker,
  },
  layout: Layout,
  props: {
    totalGastos: Object,
    totalVentas: Object,
    totalCelulares: Object,
    totalGastosHoy: Object,
    totalVentasHoy: Object,
    resumenToday: Object,
    gastos: Object,
  },

  setup() {
    const date = ref()
    const highlighted = ref([new Date()])
    const numPages = ref('0')
    const price = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
    })

    function downloadPDF() {
      const doc = new jsPDF('p', 'pt')
      autoTable(doc, { html: '#pdf-content' })
      autoTable(doc, { html: '#pdf-content2' })
      doc.save('table.pdf')
    }

    watch(date, (newDate, oldDate) => {
      console.log(newDate, oldDate)
      Inertia.get(
        '/',
        { date: newDate },
        {
          preserveScroll: true,
        },
      )
    })
    function formatter(date) {
      console.log(date)
    }

    return {
      date,
      numPages,
      highlighted,
      downloadPDF,
      formatter,
      price,
    }
  },
}
</script>
