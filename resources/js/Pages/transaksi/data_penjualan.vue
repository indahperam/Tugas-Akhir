<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title mb-4">List Data Penjualan</div>
            <datatable
                :dataPage="penjualan.links"
                :dataTotal="penjualan.total"
                v-model:inputSearch="cari"
                v-model:inputShow="itemShow"
                inputDate
                v-model:dateStart="cari_dari"
                v-model:dateEnd="cari_sampai"
            >
                <template v-slot:content>
                    <div class="mt-4 overflow-x-auto scrollbar-hide">
                        <table class="table table-compact w-full text-center">
                            <thead>
                                <tr>
                                    <td>kode</td>
                                    <td>member</td>
                                    <td>tanggal</td>
                                    <td>total</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(item, index) in penjualan.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.kode }}</td>
                                        <td>
                                            {{
                                                item.member_id != 0
                                                    ? item.member.nama
                                                    : "non-member"
                                            }}
                                        </td>
                                        <td>{{ item.tanggal }}</td>
                                        <td>{{ rupiah(item.grand_total) }}</td>
                                        <td class="flex justify-center gap-2">
                                            <label
                                                @click="get_penjualan(item)"
                                                for="detail"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                @click="print_penjualan(item)"
                                                class="btn btn-xs btn-primary"
                                                ><i class="fa fa-print"></i
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
    <modal-lg id="detail">
        <template v-slot:title
            >Detail Penjualan {{ form.kode }}
            <label for="detail" class="btn btn-xs">close</label></template
        >
        <template v-slot:content>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <table class="table table-compact w-max text-sm capitalize">
                        <tbody>
                            <template v-if="form.member">
                                    <tr>
                                        <th>Nama</th>
                                        <td>: {{ form.member.nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>alamat</th>
                                        <td>: {{ form.member.alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>kontak</th>
                                        <td>: {{ form.member.kontak }}</td>
                                    </tr>
                            </template>
                            <tr>
                                <th>Detail Pembayaran</th>
                                <td>
                                    :
                                    <label
                                        for="detail_pembayaran"
                                        class="btn btn-xs btn-info"
                                        >lihat detail</label
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table
                    class="table table-compact w-full text-center capitalize"
                >
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>nama</th>
                            <th>harga</th>
                            <th>jumlah</th>
                            <th class="text-right">subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in form.transaksi_detail">
                            <td>{{ item.kode }}</td>
                            <td>{{ item.nama }}</td>
                            <td>{{ rupiah(item.harga_jual) }}</td>
                            <td>{{ item.jumlah }}</td>
                            <td class="text-right">
                                {{ rupiah(item.subtotal) }}
                            </td>
                        </tr>
                    </tbody>
                    <thead class="text-left">
                        <tr>
                            <td
                                colspan="3"
                                rowspan="5"
                                class="text-center text-5xl"
                                :class="
                                    form.lunas == 'belum lunas'
                                        ? 'text-red-600'
                                        : 'text-success'
                                "
                            >
                                {{ form.lunas }}
                            </td>
                            <td class="w-[8rem]">total</td>
                            <td class="text-right w-[8rem]">
                                {{ rupiah(form.total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-max">diskon</td>
                            <td class="text-right w-[5rem]">
                                {{ rupiah(form.diskon_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-max">ppn {{ form.ppn }}%</td>
                            <td class="text-right w-[5rem]">
                                {{ rupiah(form.ppn_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-max">grand total</td>
                            <td class="text-right w-[5rem]">
                                {{ rupiah(form.grand_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-max">bayar</td>
                            <td class="text-right w-[5rem]">
                                {{ rupiah(form.bayar) }}
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </template>
    </modal-lg>

    <modal-md id="detail_pembayaran">
        <template v-slot:title>Detail Pembayaran</template>
        <template v-slot:content>
            <table class="w-full table table-compact table-zebra text-center">
                <thead>
                    <tr>
                        <th>tanggal</th>
                        <th>jenis</th>
                        <th>transaksi</th>
                        <th>nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in form.pembayaran">
                        <td>{{ item.waktu }}</td>
                        <td>{{ item.tipe }}</td>
                        <td>
                            {{ item.no_transaksi ? item.no_transaksi : "-" }}
                        </td>
                        <td>{{ rupiah(item.nominal) }}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </modal-md>
</template>
<script>
import ModalLg from "@/Components/ModalLg.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    layout: LayoutMain,
    components: {
        "modal-lg": ModalLg,
    },
    setup(props) {
        const form = useForm({
            id: null,
            kode: null,
            total: null,
            diskon_total: null,
            ppn: null,
            ppn_total: null,
            lunas: null,
            grand_total: null,
            member: {
                nama: null,
                alamat: null,
                kontak: null,
            },
            transaksi_detail: [],
            pembayaran: [],
            bayar: {
                jenis: "TUNAI",
                no_transaksi: "",
                final: 0,
            },
        });
        return {
            form,
        };
    },
    props: {
        penjualan: Object,
        search: String,
        showItem: Number,
        dari: String,
        sampai: String,
        jenis_pembayaran: Array,
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
                route("data.penjualan.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "penjualan"],
                }
            );
        },
        cari_sampai() {
            this.$inertia.visit(
                route("data.penjualan.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "penjualan"],
                }
            );
        },
        cari() {
            this.$inertia.visit(
                route("data.penjualan.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "penjualan"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("data.penjualan.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "penjualan"],
                }
            );
        },
    },
    methods: {
        async print_penjualan(data) {
            var print = await window.open(
                route("data.penjualan.show", {
                    penjualan: data.id,
                })
            );
            await print.addEventListener("DOMContentLoaded", () => {
                print.window.print();
                print.window.onafterprint = (event) => {
                    print.close();
                };
            });
        },
        get_penjualan(data) {
            this.form.id = data.id;
            this.form.kode = data.kode;
            this.form.transaksi_detail = data.transaksi_detail;
            this.form.ppn = data.ppn;
            this.form.ppn_total = data.ppn_total;
            this.form.diskon = data.diskon;
            this.form.diskon_total = data.diskon_total;
            this.form.grand_total = data.grand_total;
            this.form.total = data.total;
            this.form.bayar = data.pembayaran_sum_nominal;
            this.form.member = data.member;
            this.form.lunas = data.lunas;
            this.form.pembayaran = data.pembayaran;
        },
    },
};
</script>
<style lang=""></style>
