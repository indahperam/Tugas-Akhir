<template lang="">
    <div class="card shadow-lg bg-base-100 z-0" id="screen">
        <div class="card-body">
            <div class="flex justify-between">
                <div class="card-title mb-4">Menu Penjualan</div>
                <label class="swap swap-rotate btn btn-ghost btn-sm text-xl hidden">
                    <!-- this hidden checkbox controls the state -->
                    <input type="checkbox" hidden v-model="maxScreen" />
                    <i class="fa fa-maximize swap-off"></i>
                    <i class="fa fa-minimize swap-on"></i>
                </label>
            </div>
            <div class="flex justify-between mb-4 z-20">
                <table class="table table-compact w-max z-0">
                    <tbody>
                        <tr>
                            <th class="min-w-[7rem] uppercase">supplier</th>
                            <td class="flex gap-4 items-center">
                                <input-pick
                                    :dataPick="dataSupplier"
                                    v-model:dataSelect="addSupplier"
                                    member="true"
                                ></input-pick>
                            </td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">Nama</th>
                            <td>{{ tambah.supplier.nama }}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">Alamat</th>
                            <td>{{ tambah.supplier.alamat }}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">kontak</th>
                            <td>{{ tambah.supplier.kontak }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-between">
                <div class="flex items-center gap-4 z-10">
                    <div class="">Produk</div>
                    <input-pick
                        :dataPick="produk"
                        v-model:dataSelect="addProduk"
                        supplier="true"
                    ></input-pick>
                </div>
                <div class="" v-if="tambah.id != 0">
                    Transaksi Aktif : {{ tambah.kode }}
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hide max-h-[20rem]">
                <table class="table table-compact w-full">
                    <thead class="sticky top-0 uppercase">
                        <tr>
                            <td class="w-[4rem]"></td>
                            <td>no</td>
                            <td>Nama</td>
                            <td>Harga</td>
                            <td class="text-center">Jumlah</td>
                            <td class="text-right">subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        <transition-group name="listv2">
                            <tr
                                v-for="item in tambah.keranjang
                                    .slice()
                                    .reverse()"
                                :key="item.kode"
                            >
                                <td>
                                    <button
                                        class="btn btn-error btn-xs"
                                        @click="removeProduk(item.kode)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>{{ item.kode }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ rupiah(item.harga_beli) }}</td>
                                <td
                                    class="flex justify-center select-none gap-3 items-center"
                                >
                                    <button
                                        class="btn btn-xs"
                                        v-on:mousedown="addStok(item)"
                                        v-on:mouseup="
                                            () => {
                                                click_check = false;
                                            }
                                        "
                                        v-on:mouseleave="
                                            () => {
                                                click_check = false;
                                            }
                                        "
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    {{ item.jumlah }}
                                    <button
                                        class="btn btn-xs"
                                        v-on:mousedown="removeStok(item)"
                                        v-on:mouseup="
                                            () => {
                                                click_check = false;
                                            }
                                        "
                                        v-on:mouseleave="
                                            () => {
                                                click_check = false;
                                            }
                                        "
                                    >
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                                <td class="text-right">
                                    {{ rupiah(item.subtotal) }}
                                </td>
                            </tr>
                        </transition-group>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end">
                <table class="w-full table table-compact uppercase font-bold">
                    <tbody>
                        <tr>
                            <td rowspan="4">
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <div class="text-xl">Grand Total</div>
                                    <div class="text-6xl">
                                        {{ rupiah(tambah.grand_total) }}
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-[10rem]">total</td>
                            <td class="text-right w-32">
                                {{ rupiah(tambah.total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="flex items-center gap-2">
                                diskon
                                <select
                                    class="select select-sm w-max"
                                    v-model="tambah.diskon.type"
                                >
                                    <option value="rp">RP</option>
                                    <option value="%">%</option>
                                </select>
                                <input-keypad
                                    v-model:keypadValue="tambah.diskon.final"
                                    v-if="tambah.diskon.type == 'rp'"
                                    id="diskon"
                                    harga="true"
                                    min="0"
                                    :location="maxScreen ? '#screen' : false"
                                    :max="tambah.total"
                                ></input-keypad>
                                <input-keypad
                                    min="0"
                                    max="100"
                                    id="%"
                                    :location="maxScreen ? '#screen' : false"
                                    v-model:keypadValue="tambah.diskon.dummy"
                                    v-else
                                ></input-keypad>
                            </td>
                            <td class="text-right">
                                {{ rupiah(tambah.diskon.final) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[10rem]">
                                PPN {{ user_aktif.perusahaan.ppn }}%
                            </td>
                            <td class="text-right">
                                {{ rupiah(tambah.ppn_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-[10rem]">grand total</td>
                            <td class="text-right">
                                {{ rupiah(tambah.grand_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                {{
                                    tambah.grand_total
                                        ? terbilang(tambah.grand_total) +
                                          " Rupiah"
                                        : ""
                                }}
                            </td>
                            <td colspan="2" class="w-[10rem] px-4">
                                <div class="flex justify-between gap-4">
                                    <label
                                        for=""
                                        @click="simpan"
                                        :class="{
                                            'btn-disabled':
                                                tambah.keranjang.length < 1 ||
                                                tambah.supplier.id == 0,
                                        }"
                                        class="btn btn-primary btn-sm w-max"
                                        >simpan</label
                                    >
                                    <label
                                        @click="tambah.reset()"
                                        for="reset"
                                        class="btn btn-error btn-sm w-max"
                                        >reset</label
                                    >
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    layout: LayoutMain,
    props: {
        supplier: Array,
        produk: Array,
        user_aktif: Object,
    },
    setup(props) {
        const tambah = useForm({
            id: 0,
            kode: null,
            keranjang: [],
            total: 0,
            diskon: {
                type: "%",
                dummy: 0,
                final: 0,
            },
            supplier: {
                id: 0,
                nama: "-",
                alamat: "-",
                kontak: "-",
            },
            ppn_total: 0,
            ppn: 0,
            grand_total: 0,
            bayar: {
                jenis: "TUNAI",
                no_transaksi: "",
                final: 0,
            },
            status: "active",
        });
        return {
            tambah,
        };
    },
    data() {
        return {
            maxScreen: false,
            addProduk: null,
            addSupplier: null,
            dataSupplier: this.supplier,
            click_check: false,
            looping_state: null,
            debounce_time: null,
        };
    },
    watch: {
        "tambah.diskon.dummy": {
            handler: function (baru) {
                this.tambah.diskon.final = this.tambah.total * (baru / 100);
            },
        },
        "tambah.diskon.final": {
            handler: function (baru) {
                this.master_hitung();
            },
        },
        addSupplier: {
            handler: function (data) {
                if (data != null) {
                    this.tambah.supplier.id = data.id;
                    this.tambah.supplier.nama = data.nama;
                    this.tambah.supplier.alamat = data.alamat;
                    this.tambah.supplier.kontak = data.kontak;
                }
            },
        },
        addProduk: {
            handler: function (baru) {
                if (baru != null) {
                    this.addKeranjang(baru);
                }
            },
        },
    },
    methods: {
        simpan() {
            this.tambah.post(route('pembelian.store'), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.$swal({
                        icon: "success",
                        text: "Transaksi Berhasil di simpan",
                    });
                }
            })
        },
        addStok(data) {
            clearTimeout(this.debounce_time);
            this.addKeranjang(data);
            this.click_check = true;
            this.debounce_time = setTimeout(() => {
                if (this.click_check) {
                    this.looping_state = setInterval(() => {
                        if (this.click_check) {
                            this.addKeranjang(data);
                        } else {
                            clearInterval(this.looping_state);
                        }
                    }, 100);
                }
            }, 800);
        },
        removeStok(data) {
            clearTimeout(this.debounce_time);
            this.removeKeranjang(data);
            this.click_check = true;
            this.debounce_time = setTimeout(() => {
                if (this.click_check) {
                    this.looping_state = setInterval(() => {
                        if (this.click_check) {
                            this.removeKeranjang(data);
                        } else {
                            clearInterval(this.looping_state);
                        }
                    }, 100);
                }
            }, 800);
        },
        async addKeranjang(baru) {
            var keranjang = false;
            keranjang = await this.tambah.keranjang.find((item) => {
                if (item.kode == baru.kode) {
                    return item;
                }
            });
            if (keranjang) {
                keranjang.jumlah = parseInt(keranjang.jumlah) + 1;
                keranjang.subtotal =
                    keranjang.jumlah * keranjang.harga_beli;

            } else {
                var produk = {
                    kode: baru.kode,
                    nama: baru.nama,
                    harga_beli: baru.harga_beli,
                    jumlah: 1,
                    stok: baru.stok - 1,
                    subtotal: baru.harga_beli,
                };
                this.tambah.keranjang.push(produk);
            }
            this.addProduk = null;
            this.master_hitung();
        },
        async removeKeranjang(baru) {
            var keranjang = false;
            keranjang = await this.tambah.keranjang.find((item) => {
                if (item.kode == baru.kode) {
                    return item;
                }
            });
            if (keranjang) {
                if (keranjang.jumlah > 1) {
                    keranjang.stok += 1;
                    keranjang.jumlah -= 1;
                    keranjang.subtotal =
                        keranjang.jumlah * keranjang.harga_beli;
                } else {
                    this.$swal({
                        icon: "warning",
                        text: "Minimal Pembelian Produk berjumlah 1.",
                    });
                }
            }
            this.master_hitung();
        },
        async master_hitung() {
            var total = await this.tambah.keranjang.reduce((a, b) => {
                return a + parseInt(b.subtotal);
            }, 0);
            this.tambah.total = total;

            if (this.tambah.diskon.final <= this.tambah.total) {
                if (this.tambah.diskon.type == "%") {
                    this.tambah.diskon.final =
                        this.tambah.total * (this.tambah.diskon.dummy / 100);
                }
            } else {
                this.tambah.diskon.final = 0;
            }

            total = await (total - this.tambah.diskon.final);

            this.tambah.ppn = await this.user_aktif.perusahaan.ppn;
            var ppn = (this.tambah.ppn / 100) * (await total);
            this.tambah.ppn_total = ppn;

            this.tambah.grand_total =
                this.tambah.total -
                this.tambah.diskon.final +
                this.tambah.ppn_total;
        },
    }
};
</script>
<style lang=""></style>
