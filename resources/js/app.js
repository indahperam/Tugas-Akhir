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
import inputTextAreaVue from "./Components/inputTextArea.vue";
import inputDateVue from "./Components/inputDate.vue";
import inputPickVue from "./Components/inputPick.vue";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

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
        terbilang(a) {
            var bilangan = [
                "",
                "Satu",
                "Dua",
                "Tiga",
                "Empat",
                "Lima",
                "Enam",
                "Tujuh",
                "Delapan",
                "Sembilan",
                "Sepuluh",
                "Sebelas",
            ];

            if (a >= 0) {
                // 1 - 11
                if (a < 12) {
                    var kalimat = bilangan[a];
                }
                // 12 - 19
                else if (a < 20) {
                    var kalimat = bilangan[a - 10] + " Belas";
                }
                // 20 - 99
                else if (a < 100) {
                    var utama = a / 10;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 10;
                    var kalimat =
                        bilangan[depan] + " Puluh " + bilangan[belakang];
                }
                // 100 - 199
                else if (a < 200) {
                    var kalimat = "Seratus " + this.terbilang(a - 100);
                }
                // 200 - 999
                else if (a < 1000) {
                    var utama = a / 100;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 100;
                    var kalimat =
                        bilangan[depan] + " Ratus " + this.terbilang(belakang);
                }
                // 1,000 - 1,999
                else if (a < 2000) {
                    var kalimat = "Seribu " + this.terbilang(a - 1000);
                }
                // 2,000 - 9,999
                else if (a < 10000) {
                    var utama = a / 1000;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 1000;
                    var kalimat =
                        bilangan[depan] + " Ribu " + this.terbilang(belakang);
                }
                // 10,000 - 99,999
                else if (a < 100000) {
                    var utama = a / 100;
                    var depan = parseInt(String(utama).substr(0, 2));
                    var belakang = a % 1000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Ribu " +
                        this.terbilang(belakang);
                }
                // 100,000 - 999,999
                else if (a < 1000000) {
                    var utama = a / 1000;
                    var depan = parseInt(String(utama).substr(0, 3));
                    var belakang = a % 1000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Ribu " +
                        this.terbilang(belakang);
                }
                // 1,000,000 - 	99,999,999
                else if (a < 100000000) {
                    var utama = a / 1000000;
                    var depan = parseInt(String(utama).substr(0, 4));
                    var belakang = a % 1000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Juta " +
                        this.terbilang(belakang);
                } else if (a < 1000000000) {
                    var utama = a / 1000000;
                    var depan = parseInt(String(utama).substr(0, 4));
                    var belakang = a % 1000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Juta " +
                        this.terbilang(belakang);
                } else if (a < 10000000000) {
                    var utama = a / 1000000000;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 1000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Milyar " +
                        this.terbilang(belakang);
                } else if (a < 100000000000) {
                    var utama = a / 1000000000;
                    var depan = parseInt(String(utama).substr(0, 2));
                    var belakang = a % 1000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Milyar " +
                        this.terbilang(belakang);
                } else if (a < 1000000000000) {
                    var utama = a / 1000000000;
                    var depan = parseInt(String(utama).substr(0, 3));
                    var belakang = a % 1000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Milyar " +
                        this.terbilang(belakang);
                } else if (a < 10000000000000) {
                    var utama = a / 10000000000;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 10000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Triliun " +
                        this.terbilang(belakang);
                } else if (a < 100000000000000) {
                    var utama = a / 1000000000000;
                    var depan = parseInt(String(utama).substr(0, 2));
                    var belakang = a % 1000000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Triliun " +
                        this.terbilang(belakang);
                } else if (a < 1000000000000000) {
                    var utama = a / 1000000000000;
                    var depan = parseInt(String(utama).substr(0, 3));
                    var belakang = a % 1000000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Triliun " +
                        this.terbilang(belakang);
                } else if (a < 10000000000000000) {
                    var utama = a / 1000000000000000;
                    var depan = parseInt(String(utama).substr(0, 1));
                    var belakang = a % 1000000000000000;
                    var kalimat =
                        this.terbilang(depan) +
                        " Kuadriliun " +
                        this.terbilang(belakang);
                }

                var pisah = kalimat.split(" ");
                var full = [];
                for (var i = 0; i < pisah.length; i++) {
                    if (pisah[i] != "") {
                        full.push(pisah[i]);
                    }
                }
                return full.join(" ");
            }
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
            .use(VueSweetalert2)
            .use(ZiggyVue, Ziggy)
            .component("modal-md", modalMd)
            .component("input-text", inputText)
            .component("input-harga", inputHargaVue)
            .component("input-select", inputSelectVue)
            .component("input-number", inputNumberVue)
            .component("input-keypad", inputKeypadVue)
            .component("input-textarea", inputTextAreaVue)
            .component("input-pick", inputPickVue)
            .component("input-date", inputDateVue)
            .component("datatable", datatableVue)
            .component("Head", Head)
            .component("Link", Link)
            .mixin(mixin)
            .mount(el);
    },
});

// InertiaProgress.init({ color: '#4B5563' });
