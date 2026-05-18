import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css';

const pages = import.meta.glob<{ default: DefineComponent }>('./Pages/**/*.vue')

createInertiaApp({
    resolve: async (name) => {
        const importPage = pages[`./Pages/${name}.vue`]
        if (!importPage) {
            throw new Error(`Unknown page: ${name}`)
        }
        const module = await importPage()
        return module.default
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
