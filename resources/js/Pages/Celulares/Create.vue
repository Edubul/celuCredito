<template>
  <div>
    <Head :title="`${form.first_name} ${form.last_name}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/marcass">Marcas</Link>
      <span class="text-indigo-400 font-medium">/</span>
      Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.modelo" :error="form.errors.modelo" class="pb-8 pr-6 w-full lg:w-1/2" label="Modelo" />
          <select-input v-model="form.marca_id" :error="form.errors.marca_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Marca">
            <option :value="null" />
            <option v-for="(marca, index) in marcas" :key="marca.id" :value="index + 1">{{ marca.name }}</option>
          </select-input>
          <text-input v-model="form.stock" :error="form.errors.stock" class="pb-8 pr-6 w-full lg:w-1/2" label="Stock" />
          <text-input v-model="form.precio" :error="form.errors.precio" class="pb-8 pr-6 w-full lg:w-1/2" label="Precio" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Crear celular</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    marcas: Object,
    // organizations: Array,
  },
  remember: 'form',
  setup() {
    const form = useForm({
      modelo: null,
      marca_id: null,
      stock: null,
      precio: null,
    })

    function store() {
      form.post('/celulares')
    }

    return {
      form,
      store,
    }
  },
  //   methods: {
  //     update() {
  //       this.form.put(`/marcass/${this.marcas.id}`)
  //     },
  //     destroy() {
  //       if (confirm('Are you sure you want to delete this marcas?')) {
  //         this.$inertia.delete(`/marcass/${this.marcas.id}`)
  //       }
  //     },
  //     restore() {
  //       if (confirm('Are you sure you want to restore this marcas?')) {
  //         this.$inertia.put(`/marcass/${this.marcas.id}/restore`)
  //       }
  //     },
  //   },
}
</script>
