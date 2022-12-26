<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title mb-4">
                List Data Hutang
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <datatable
                :dataPage="hutang.links"
                :dataTotal="hutang.total"
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
                                    <td>dibayar</td>
                                    <td>kurang</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(item, index) in hutang.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.kode }}</td>
                                        <td>{{ item.member.nama }}</td>
                                        <td>{{ item.tanggal }}</td>
                                        <td>{{ rupiah(item.grand_total) }}</td>
                                        <td>
                                            {{
                                                rupiah(
                                                    item.pembayaran_sum_nominal >=
                                                        0
                                                        ? item.pembayaran_sum_nominal
                                                        : 0
                                                )
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                rupiah(
                                                    item.pembayaran_sum_nominal >=
                                                        0
                                                        ? Math.abs(
                                                              item.grand_total -
                                                                  item.pembayaran_sum_nominal
                                                          )
                                                        : 0
                                                )
                                            }}
                                        </td>
                                        <td class="flex justify-center gap-2">
                                            <label
                                                @click="get_hutang(item)"
                                                for="detail"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                @click="print_hutang(item)"
                                                for="hapus"
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
            >Detail Hutang {{ form.kode }}
            <label for="detail" class="btn btn-xs">close</label></template
        >
        <template v-slot:content>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <table class="table table-compact w-max text-sm capitalize">
                        <tbody>
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
                        </tbody>
                    </table>
                    <table class="table table-compact w-max text-sm capitalize">
                        <tbody>
                            <tr>
                                <th>terakhir bayar</th>
                                <td class="flex items-center gap-2">
                                    :
                                    {{
                                        rupiah(
                                            form.pembayaran.length != 0
                                                ? form.pembayaran[
                                                      form.pembayaran.length - 1
                                                  ].nominal
                                                : 0
                                        )
                                    }}
                                    <label
                                        v-if="form.pembayaran.length > 0"
                                        for="detail_pembayaran"
                                        class="btn btn-xs btn-info"
                                        >lihat detail</label
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th>sisa pembayaran</th>
                                <td>
                                    :
                                    {{
                                        rupiah(
                                            Math.abs(
                                                form.bayar - form.grand_total
                                            )
                                        )
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th>Pembayaran</th>
                                <td>
                                    :
                                    <label
                                        for="bayar"
                                        class="btn btn-xs btn-success"
                                        >bayar</label
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
                            <td class="w-max">dibayar</td>
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

    <modal-md id="bayar">
        <template v-slot:title>Metode Pembayaran</template>
        <template v-slot:content>
            <input-select
                title="Metode Pembayaran"
                :dataSelect="jenis_pembayaran"
                v-model:inputValue="form.bayar_hutang.jenis"
                label="jenis"
            ></input-select>
            <input-text
                v-if="!form.bayar_hutang.jenis.toLowerCase().includes('tunai')"
                title="No Transaksi"
                v-model:inputValue="form.bayar_hutang.no_transaksi"
            ></input-text>
            <div class="flex flex-col gap-4">
                <input-harga
                    v-model:inputValue="form.bayar_hutang.final"
                    title="Bayar"
                ></input-harga>
            </div>
            <div class="grid grid-cols-4 py-4 gap-4">
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = form.sisa"
                >
                    uang pas
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = 100000"
                >
                    Rp 100.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = 50000"
                >
                    Rp 50.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = 20000"
                >
                    Rp 20.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = 10000"
                >
                    Rp 10.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="form.bayar_hutang.final = 5000"
                >
                    Rp 5.000
                </button>
            </div>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-success"
                :class="{
                    'loading btn-disabled': form.processing,
                    'btn-disabled': form.bayar_hutang.final == 0,
                }"
                @click="submit"
            >
                Submit
            </button></template
        >
    </modal-md>
</template>
<script>
import ModalLg from "@/Components/ModalLg.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    layout: LayoutMain,
    props: {
        hutang: Object,
        search: String,
        showItem: Number,
        dari: String,
        sampai: String,
        jenis_pembayaran: Array,
    },
    components: {
        "modal-lg": ModalLg,
    },
    data() {
        return {
            cari: this.search,
            itemShow: parseInt(this.showItem),
            cari_dari: this.dari,
            cari_sampai: this.sampai,
        };
    },
    setup() {
        const form = useForm({
            id: null,
            kode: null,
            total: null,
            diskon_total: null,
            ppn: null,
            ppn_total: null,
            lunas: null,
            grand_total: null,
            bayar: null,
            sisa: null,
            member: {},
            transaksi_detail: [],
            pembayaran: [],
            bayar_hutang: {
                jenis: "TUNAI",
                no_transaksi: "",
                final: 0,
            },
        });
        return {
            form,
        };
    },
    methods: {
        print_hutang(data) {
            var print = window.open(
                route("hutang.show", {
                    hutang: data.id,
                })
            );
        },
        get_hutang(data) {
            this.form.id = data.id;
            this.form.kode = data.kode;
            this.form.lunas = data.lunas;
            this.form.total = data.total;
            this.form.diskon_total = data.diskon_total;
            this.form.ppn = data.ppn;
            this.form.ppn_total = data.ppn_total;
            this.form.grand_total = data.grand_total;
            this.form.bayar = data.pembayaran_sum_nominal;
            this.form.member = data.member;
            this.form.transaksi_detail = data.transaksi_detail;
            this.form.pembayaran = data.pembayaran;
            this.form.sisa = Math.abs(
                data.pembayaran_sum_nominal - data.grand_total
            );
        },
        submit() {
            this.form.put(
                route("hutang.update", {
                    hutang: this.form.id,
                }),
                {
                    onSuccess: async () => {
                        var kembalian =
                            this.form.sisa - this.form.bayar_hutang.final;
                        this.modal_close("bayar");
                        this.modal_close("detail");
                        await this.$swal({
                            icon: "success",
                            text: "",
                            showCancelButton: true,
                            cancelButtonText: "CLOSE",
                            confirmButtonText:
                                "PRINT <i class='fa fa-print'></i>",
                            title:
                                kembalian >= 0
                                    ? " Transaksi Berhasil"
                                    : `Kembalian ${this.rupiah(
                                          Math.abs(kembalian)
                                      )}`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open(
                                    route("hutang.show", {
                                        hutang: this.form.id,
                                    })
                                );
                            }
                        });
                        this.form.reset();
                    },
                }
            );
        },
    },
    watch: {
        cari_dari() {
            this.$inertia.visit(
                route("hutang.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "hutang"],
                }
            );
        },
        cari_sampai() {
            this.$inertia.visit(
                route("hutang.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "hutang"],
                }
            );
        },
        cari() {
            this.$inertia.visit(
                route("hutang.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "hutang"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("hutang.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "hutang"],
                }
            );
        },
    },
};
</script>
<style lang=""></style>
