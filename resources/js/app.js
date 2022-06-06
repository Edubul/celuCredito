import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import Datapicker from '@vuepic/vue-datepicker'

InertiaProgress.init()

createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  title: (title) => (title ? `${title} - Celu Creditos` : 'Celu Creditos'),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Datapicker)
      .mount(el)
  },
})
