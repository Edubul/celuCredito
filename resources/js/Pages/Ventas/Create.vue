<template>
  <div>
    <Head title="Crear Venta" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/ventas">Ventas</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.marca" :error="form.errors.marca" class="pb-8 pr-6 w-full lg:w-1/2" label="Marca">
            <option :value="null" @click="disabled = true" />
            <option v-for="(marca, index) in marcas" :key="index" :value="index" @click=";[(marcaSelect = index), (disabled = false)]">
              {{ marca }}
            </option>
          </select-input>
          <select-input v-model="form.modelo" :disabled="disabled" :error="form.errors.modelo" class="pb-8 pr-6 w-full lg:w-1/2" label="Modelo">
            <option v-for="(modelo, index) in modelos" :key="index" :value="index">{{ modelo }}</option>
          </select-input>
          <text-input v-model="form.nombre_cliente" :error="form.errors.nombre_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Nombre del cliente" />
          <text-input v-model="form.numero_celular_cliente" :error="form.errors.numero_celular_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Número de telefono" />
          <text-input v-model="form.imei" :error="form.errors.imei" class="pb-8 pr-6 w-full lg:w-1/2" label="IMEI Celular" />
          <text-input v-model="form.cc_cliente" :error="form.errors.cc_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Cédula Ciudadana" />
          <label for="fecha" class="form-label">Fecha</label>
          <input v-model="form.fecha" type="date" name="fecha" class="form-input w-full" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Crear Venta</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import { ref, watch } from 'vue'
import Layout from '@/Shared/Layout'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    SelectInput,
  },
  layout: Layout,
  remember: 'form',
  props: {
    marcas: Array,
    modelos: Object,
    users: Object,
  },
  setup() {
    const disabled = ref(true)
    const total = ref(0)
    const marcaSelect = ref(0)

    const form = useForm({
      marca: null,
      modelo: null,
      id_celular: null,
      nombre_cliente: null,
      numero_celular_cliente: null,
      imei: null,
      cc_cliente: null,
      fecha: null,
    })

    watch(marcaSelect, (newValue) => {
      Inertia.get('/ventas/create', { modelos: newValue }, { preserveState: true }, 150)
    })

    function store() {
      form.post('/ventas')
    }

    return {
      form,
      disabled,
      store,
      total,
      marcaSelect,
    }
  },
}
</script>
