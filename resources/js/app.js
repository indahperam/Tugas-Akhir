import "./bootstrap";
import "../css/app.css";
import "../css/transisi.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
// import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";
import { createStore } from "vuex";
import modalMd from "@/Components/modalMd.vue";
import inputText from "./Components/inputText.vue";
import inputHargaVue from "./Components/inputHarga.vue";
import inputSelectVue from "./Components/inputSelect.vue";
import inputNumberVue from "./Components/inputNumber.vue";
import inputKeypadVue from "./Components/inputKeypad.vue";
import datatableVue from "./Components/datatableVue.vue";

const store = createStore({
    state() {
        return {
            notifikasi_master: [],
            user_data: {
                nama: null,
                foto: null,
            },
        };
    },
    mutations: {
        notifikasi(state, n) {
            state.notifikasi_master.unshift(n);
            setTimeout(() => {
                state.notifikasi_master.pop();
            }, 5000);
        },
    },
});
const mixin = {
    methods: {
        notifikasi(status, data) {
            this.$store.commit("notifikasi", { tipe: status, pesan: data });
        },
        modal_close(data) {
            document.getElementById(data).click();
        },
        rupiah(data) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                maximumFractionDigits: 0,
            }).format(data);
        },
    },
};

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(store)
            .use(ZiggyVue, Ziggy)
            .component("modal-md", modalMd)
            .component("input-text", inputText)
            .component("input-harga", inputHargaVue)
            .component("input-select", inputSelectVue)
            .component("input-number", inputNumberVue)
            .component("input-keypad", inputKeypadVue)
            .component("datatable", datatableVue)
            .component("Head", Head)
            .mixin(mixin)
            .component("Link", Link)
            .mount(el);
    },
});

// InertiaProgress.init({ color: '#4B5563' });
