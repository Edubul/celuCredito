<template>
  <div>
    <Head title="Crear Gasto" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/gastos">Gasto</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.user_id" :disabled="disabled" :error="form.errors.user_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Empleado">
            <option v-for="(gasto, index) in gastos.user" :key="index" :value="index + 1">{{ gasto.first_name }} {{ gasto.last_name }}</option>
          </select-input>

          <text-input v-model="form.cantidad" :error="form.errors.cantidad" class="pb-8 pr-6 w-full lg:w-1/2" label="Cantidad del gasto" />
          <text-area-input v-model="form.motivo" :error="form.errors.motivo" class="pb-8 pr-6 w-full lg:w-1/2" label="Motivo del gasto" />
          <div class="pb-8 pr-6 w-full lg:w-1/2">
            <label class="block text-gray-700">Fecha:</label>
            <input v-model="form.fecha" type="date" name="fecha" class="form-input pr-6 w-full" />
          </div>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Crear Gasto</loading-button>
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
import TextAreaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    TextAreaInput,
    SelectInput,
  },
  layout: Layout,
  remember: 'form',
  props: {
    gastos: Object,
  },
  setup() {
    const form = useForm({
      user_id: null,
      motivo: null,
      cantidad: null,
      fecha: null,
    })

    function store() {
      form.post('/gastos')
    }

    return {
      form,
      store,
    }
  },
}
</script>
