<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Closing
            </div>
            <datatable
                :dataPage="closing.links"
                :dataTotal="closing.total"
                v-model:inputSearch="cari"
                v-model:inputShow="itemShow"
                inputDate
                v-model:dateStart="cari_dari"
                v-model:dateEnd="cari_sampai"
            >
                <template v-slot:content>
                    <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-primary scrollbar-track-base-300 pb-2">
                        <table
                            class="table table-compact w-full text-center shadow-lg"
                        >
                            <thead>
                                <tr>
                                    <td>kode</td>
                                    <td>tanggal</td>
                                    <td>mulai</td>
                                    <td>selesai</td>
                                    <td>user</td>
                                    <td>total transaksi</td>
                                    <td>modal awal</td>
                                    <td>Total Uang Tunai</td>
                                    <td>selisih</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(item, index) in closing.data"
                                        :key="item.id"
                                        v-if="closing.data.length"
                                    >
                                    <td>{{item.kode}}</td>
                                    <td>{{item.tanggal}}</td>
                                    <td>{{item.waktu_mulai}}</td>
                                    <td>{{item.waktu_selesai}}</td>
                                    <td>{{item.user.name}}</td>
                                    <td>{{item.total_nota}}</td>
                                    <td>{{rupiah(item.modal_awal)}}</td>
                                    <td>{{rupiah(item.total_uang_tunai)}}</td>
                                    <td>{{rupiah(item.selisih)}}</td>
                                        <td class="gap-2 flex justify-center">
                                            <label
                                                @click="editClosing(item)"
                                                for="show"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                @click="hapusClosing(item)"
                                                for="hapus"
                                                class="btn btn-xs btn-error"
                                                ><i class="fa fa-trash"></i
                                            ></label>
                                        </td>
                                    </tr>
                                </transition-group>
                            </tbody>
                        </table>
                    </div>
                </template>
            </datatable>
        </div>
    </div>
    <modal-lg id="show">
        <template v-slot:title>detail closing {{form.waktu}}</template>
        <template v-slot:content>
            <div class="w-full grid grid-cols-2">
                <div class="w-full grid grid-cols-2 gap-2 p-2">
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">tgl. transaksi</span>
                        </label>
                        <input type="text" disabled :value="form.tanggal" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">id closing</span>
                        </label>
                        <input type="text" disabled :value="form.kode" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize col-span-2">
                        <label class="label">
                            <span class="label-text">User</span>
                        </label>
                        <input type="text" disabled :value="form.user?.name" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">nota awal</span>
                        </label>
                        <input type="text" disabled :value="form.nota_awal" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">nota akhir</span>
                        </label>
                        <input type="text" disabled :value="form.nota_akhir" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">total nota</span>
                        </label>
                        <input type="text" disabled :value="form.total_nota" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">total nota dihapus</span>
                        </label>
                        <input type="text" disabled :value="form.total_nota_duhapus" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize col-span-2">
                        <label class="label">
                            <span class="label-text">modal awal</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.modal_awal)" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">Tunai</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.cash)" class="input input-bordered">
                    </div>
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text">transfer</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.transfer)" class="input input-bordered">
                    </div>
                </div>
                <div class="flex flex-col px-4 py-2 bg-primary rounded-lg">
                    <div class="form-control capitalize">
                        <label class="label">
                            <span class="label-text text-white">Gross Sales</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.gross_sales)" class="input input-bordered">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-control capitalize">
                            <label class="label">
                                <span class="label-text text-white">diskon</span>
                            </label>
                            <input type="text" disabled :value="rupiah(form.diskon)" class="input input-bordered">
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-white">PPN</span>
                            </label>
                            <input type="text" disabled :value="rupiah(form.ppn)" class="input input-bordered">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-control capitalize">
                            <label class="label">
                                <span class="label-text text-white">net Sales</span>
                            </label>
                            <input type="text" disabled :value="rupiah(form.gross_sales)" class="input input-bordered">
                        </div>
                        <div class="form-control capitalize">
                            <label class="label">
                                <span class="label-text text-white">avg. sales</span>
                            </label>
                            <input type="text" disabled :value="rupiah(form.rata_rata)" class="input input-bordered">
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-white">Pengeluaran</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.pengeluaran)" class="input input-bordered">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-white">Total Uang Tunai : {{rupiah(form.total_uang_tunai)}}</span>
                        </label>
                        <input type="number" v-model="form.total_uang_tunai" disabled class="input input-bordered">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-white">Selisih</span>
                        </label>
                        <input type="text" disabled :value="rupiah(form.selisih)" class="input input-bordered">
                    </div>
                </div>
            </div>
        </template>
    </modal-lg>
</template>
<script>
import ModalLg from '@/Components/ModalLg.vue';
import LayoutMain from '@/Layouts/LayoutMain.vue';
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    layout: LayoutMain,
    components: { 'modal-lg': ModalLg },
    props: {
        closing: Object,
        search: String,
        showItem: Number,
        dari: String,
        sampai: String,
    },
    data() {
        return {
            cari: this.search,
            itemShow: parseInt(this.showItem),
            cari_dari: this.dari,
            cari_sampai: this.sampai,
        };
    },
    watch: {
        cari_dari() {
            this.$inertia.visit(
                route("closing.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "closing"],
                }
            );
        },
        cari_sampai() {
            this.$inertia.visit(
                route("closing.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "closing"],
                }
            );
        },
        cari() {
            this.$inertia.visit(
                route("closing.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "closing"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("closing.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "closing"],
                }
            );
        },
    },
    setup() {
        const form = useForm({
            id: null,
            kode: null,
            user_id: null,
            nota_awal: null,
            nota_akhir: null,
            total_nota: null,
            total_nota_hapus: null,
            modal_awal: null,
            cash: null,
            transfer: null,
            gross_sales: null,
            diskon: null,
            ppn: null,
            net_sales: null,
            rata_rata: null,
            pengeluaran: null,
            selisih: null,
            tanggal: null,
            total_uang_tunai: 0,
            user: {},
        })
        return {
            form
        }
    },
    methods: {
        editClosing(data) {
            this.form.id = data.id
            this.form.kode = data.kode
            this.form.nota_awal = data.nota_awal
            this.form.nota_akhir = data.nota_akhir
            this.form.total_nota = data.total_nota
            this.form.total_nota_hapus = data.total_nota_hapus
            this.form.modal_awal = data.modal_awal
            this.form.cash = data.cash
            this.form.transfer = data.transfer
            this.form.gross_sales = data.gross_sales
            this.form.diskon = data.diskon
            this.form.ppn = data.ppn
            this.form.net_sales = data.net_sales
            this.form.rata_rata = data.rata_rata
            this.form.pengeluaran = data.pengeluaran
            this.form.selisih = data.selisih
            this.form.total_uang_tunai = data.total_uang_tunai
            this.form.user = data.user
            this.form.tanggal = data.tanggal
        },
        hapusClosing(data) {
            this.form.delete(route('closing.destroy', {
                closing: data.id
            }), {
                onSuccess: () => {
                    this.notifikasi('success', 'Closing berhasil dihapus!')
                }
            })
        }
    }
}
</script>
<style lang="">
    
</style>