<template>
  <div>
    <Head :title="`Editar ${celular.modelo}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/celulares">Marcas</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ celular.modelo }} (ID: {{ celular.id }})
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.modelo" :error="form.errors.modelo" class="pb-8 pr-6 w-full lg:w-1/2" label="Modelo" />
          <select-input v-model="form.marca_id" :error="form.errors.marca_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Marca">
            <option :value="null" />
            <option v-for="(marca, index) in marcas" :key="marca.id" :value="index + 1">{{ marca.name }}</option>
          </select-input>
          <text-input v-model="form.stock" :error="form.errors.stock" class="pb-8 pr-6 w-full lg:w-1/2" label="Stock" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!celular.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Borrar Celular</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Actualizar Celular</loading-button>
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
    celular: Object,
  },
  remember: 'form',
  setup(props) {
    const form = useForm({
      _method: 'PUT',
      id: props.celular.id,
      modelo: props.celular.modelo,
      marca_id: props.celular.marca_id,
      stock: props.celular.stock,
      precio: props.celular.precio,
    })

    function update() {
      form.post(`/celulares/${props.celular.id}`)
    }

    function destroy() {
      if (confirm('¿Estás seguro de que quieres borrar este celular?')) {
        Inertia.delete(`/celulares/${props.celular.id}`)
      }
    }

    return {
      form,
      update,
      destroy,
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
