<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title mb-4">List Data Pembelian <Link method="post" as="button" :href="route('pembelian.cetak',{
                data : {
                    waktu : [cari_dari,cari_sampai],
                pembelian : pembelian.data,
                }
            })" class="btn btn-xs">cetak laporan</Link></div>
            <datatable
                :dataPage="pembelian.links"
                :dataTotal="pembelian.total"
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
                                    <td>supplier</td>
                                    <td>tanggal</td>
                                    <td>total</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(item, index) in pembelian.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.kode }}</td>
                                        <td>
                                            {{
                                                item.supplier.nama
                                            }}
                                        </td>
                                        <td>{{ item.tanggal }}</td>
                                        <td>{{ rupiah(item.grand_total) }}</td>
                                        <td class="flex justify-center gap-2">
                                            <label
                                                @click="get_pembelian(item)"
                                                for="detail"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                @click="print_pembelian(item)"
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
        <template v-slot:title>
        Detail pembelian {{ form.kode }}
                <label for="detail" class="btn btn-xs">close</label>
        </template>
        <template v-slot:content>
        <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <table class="table table-compact w-max text-sm capitalize">
                        <tbody>
                            <template v-if="form.supplier">
                                    <tr>
                                        <th>Nama</th>
                                        <td>: {{ form.supplier.nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>alamat</th>
                                        <td>: {{ form.supplier.alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>kontak</th>
                                        <td>: {{ form.supplier.kontak }}</td>
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
                        <tr v-for="item in form.detail">
                            <td>{{ item.kode }}</td>
                            <td>{{ item.nama }}</td>
                            <td>{{ rupiah(item.harga_beli) }}</td>
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
                    </thead>
                </table>
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
    components: {
        'modal-lg': ModalLg
    },
    props: {
        pembelian: Object,
        search: String,
        showItem: Number,
        dari: String,
        sampai: String,
    },
    setup() {
        const form = useForm({
            id: null,
            kode: null,
            total: 0,
            ppn: 0,
            ppn_total: 0,
            diskon: 0,
            diskon_total: 0,
            grand_total: 0,
            supplier: {
                id: null,
                nama: null,
                alamat: null,
                kontak: null,
            },
            detail: []
        })
        return {
            form
        }
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
                route("data.pembelian.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pembelian"],
                }
            );
        },
        cari_sampai() {
            this.$inertia.visit(
                route("data.pembelian.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pembelian"],
                }
            );
        },
        cari() {
            this.$inertia.visit(
                route("data.pembelian.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pembelian"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("data.pembelian.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pembelian"],
                }
            );
        },
    },
    methods: {
        async print_pembelian(data) {
            var print = await window.open(route("data.pembelian.show", {
                pembelian: data.id
            }));
            await print.addEventListener("DOMContentLoaded", async () => {
                setTimeout(() => {
                    print.window.print();
                }, 1000);
                print.window.onafterprint = (event) => {
                    print.close();
                };
            });
        },
        get_pembelian(data) {
            this.form.id = data.id
            this.form.kode = data.kode
            this.form.total = data.total
            this.form.diskon = data.diskon
            this.form.diskon_total = data.diskon_total
            this.form.ppn = data.ppn
            this.form.ppn_total = data.ppn_total
            this.form.grand_total = data.grand_total
            this.form.supplier = data.supplier
            this.form.detail = data.pembelian_detail
        }
    },
}
</script>
<style lang="">
    
</style>