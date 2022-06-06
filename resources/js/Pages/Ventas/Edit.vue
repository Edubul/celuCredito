<template>
  <div>
    <Head :title="`Venta - ${form.nombre_cliente}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Ventas</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.id }} ({{ form.nombre_cliente }})
      </h1>
      <img v-if="venta.photo" class="block ml-4 w-8 h-8 rounded-full" :src="venta.photo" />
    </div>
    <trashed-message v-if="venta.deleted_at" class="mb-6" @restore="restore"> This user has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.marca" :error="form.errors.marca" class="pb-8 pr-6 w-full lg:w-1/2" label="Marca">
            <option v-for="(marca, index) in venta.marcas" :key="index" :value="index" @click=";[(marcaSelect = index), (disabled = false)]">
              {{ marca }}
            </option>
          </select-input>
          <select-input v-model="form.modelo" :disabled="disabled" :error="form.errors.modelo" class="pb-8 pr-6 w-full lg:w-1/2" label="Modelo">
            <option v-for="(modelo, index) in venta.modelos" :key="index" :value="index">{{ modelo }}</option>
          </select-input>
          <text-input v-model="form.nombre_cliente" :error="form.errors.nombre_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Nombre del cliente" />
          <text-input v-model="form.numero_celular_cliente" :error="form.errors.numero_celular_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Número de telefono" />
          <text-input v-model="form.imei" :error="form.errors.imei" class="pb-8 pr-6 w-full lg:w-1/2" label="IMEI Celular" />
          <text-input v-model="form.cc_cliente" :error="form.errors.cc_cliente" class="pb-8 pr-6 w-full lg:w-1/2" label="Cédula Ciudadana" />
          <label for="fecha" class="form-label">Fecha</label>
          <input v-model="form.fecha" type="date" name="fecha" class="form-input w-full" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!venta.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Venta</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Actualizar Venta</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import { ref, watch } from 'vue'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    // FileInput,
    SelectInput,
    Head,
    Link,
    LoadingButton,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    venta: Object,
  },
  remember: 'form',
  setup(props) {
    const marcaSelect = ref(0)
    const form = useForm({
      _method: 'put',
      id: props.venta.id,
      marca: props.venta.marcas,
      id_celular: props.venta.id_celular,
      nombre_cliente: props.venta.nombre_cliente,
      numero_celular_cliente: props.venta.numero_celular_cliente,
      imei: props.venta.imei,
      cc_cliente: props.venta.cc_cliente,
      fecha: props.venta.fecha,
      modelo: props.venta.modelos,
    })

    function update() {
      form.post(`/ventas/${props.venta.id}`)
    }

    function destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        Inertia.delete(`/ventas/${props.venta.id}`)
      }
    }
    watch(marcaSelect, (newValue) => {
      Inertia.get(`/ventas/${form.id}/edit`, { modelos: newValue }, { preserveState: true }, 150)
    })

    return {
      form,
      marcaSelect,
      update,
      destroy,
    }
  },
}
</script>
