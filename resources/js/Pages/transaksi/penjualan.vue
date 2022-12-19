<template lang="">
    <div class="card shadow-lg bg-base-100" id="screen">
        <div class="card-body">
            <div class="flex justify-between">
                <div class="card-title mb-4">Menu Penjualan</div>
                <label class="swap swap-rotate btn btn-ghost btn-sm text-xl">
                    <!-- this hidden checkbox controls the state -->
                    <input type="checkbox" hidden v-model="maxScreen" />
                    <i class="fa fa-maximize swap-off"></i>
                    <i class="fa fa-minimize swap-on"></i>
                </label>
            </div>
            <div class="flex justify-start mb-4">
                <table class="table table-compact w-max">
                    <tbody>
                        <tr>
                            <th class="min-w-[7rem] uppercase">member</th>
                            <td class="flex gap-4 items-center">
                                <input-pick
                                    :dataPick="dataMember"
                                    v-model:dataSelect="addMember"
                                    member="true"
                                ></input-pick>
                                <button class="btn btn-xs" @click="resetMember">
                                    non-member
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">Nama</th>
                            <td>{{ tambah.member.nama }}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">Alamat</th>
                            <td>{{ tambah.member.alamat }}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[7rem] uppercase">kontak</th>
                            <td>{{ tambah.member.kontak }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center gap-4">
                <div class="">Produk</div>
                <input-pick
                    :dataPick="dataProduk"
                    v-model:dataSelect="addProduk"
                ></input-pick>
            </div>
            <div class="overflow-x-auto scrollbar-hide max-h-[20rem]">
                <table class="table table-compact w-full">
                    <thead class="sticky top-0">
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
                                    <button class="btn btn-error btn-xs">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>{{ item.kode }}</td>
                                <td>{{ item.nama }}</td>
                                <td>{{ rupiah(item.harga_jual) }}</td>
                                <td
                                    class="flex justify-center select-none gap-3 items-center"
                                >
                                    <button
                                        class="btn btn-xs"
                                        v-on:mousedown="addStok(item)"
                                        v-on:mouseup="
                                            (click_check = false),
                                                clearInterval(looping_state)
                                        "
                                        v-on:mouseleave="
                                            (click_check = false),
                                                clearInterval(looping_state)
                                        "
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    {{ item.jumlah }}
                                    <button class="btn btn-xs">
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
                <table class="w-full table table-compact">
                    <thead>
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
                                    <input-keypad
                                        v-model:keypadValue="tambah.bayar"
                                        :disabled="tambah.keranjang.length < 1"
                                        :location="
                                            maxScreen ? '#screen' : false
                                        "
                                        title="Bayar"
                                        type="success"
                                        id="bayar"
                                        harga="true"
                                    ></input-keypad>
                                    <label
                                        for=""
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
                    </thead>
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
    props: ["produk", "user_aktif", "member"],
    setup(props) {
        const tambah = useForm({
            keranjang: [],
            total: 0,
            diskon: {
                type: "%",
                dummy: 0,
                final: 0,
            },
            member: {
                id: 0,
                nama: "Non-Member",
                alamat: "-",
                kontak: "-",
            },
            ppn_total: 0,
            ppn: 0,
            grand_total: 0,
            bayar: 0,
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
            addMember: null,
            dataProduk: this.produk,
            dataMember: this.member,
            click_check: false,
            looping_state: null,
            debounce_time: null,
        };
    },
    watch: {
        addMember: {
            handler: function (data) {
                if (data != null) {
                    this.tambah.member.id = data.id;
                    this.tambah.member.nama = data.nama;
                    this.tambah.member.alamat = data.alamat;
                    this.tambah.member.kontak = data.kontak;
                }
            },
        },
        "tambah.bayar": {
            handler: function (baru) {
                if (baru < this.tambah.grand_total) {
                    this.$swal({
                        icon: "error",
                        title: "Proses Gagal",
                        text: "Pembayaran tidak sesuai, uang diterima harus lebih atau sama dengan pembayaran",
                    });
                } else {
                    this.$swal({
                        icon: "success",
                        title: `Kembalian ${this.rupiah(
                            baru - this.tambah.grand_total
                        )}`,
                        text: "Transaksi Berhasil",
                    });
                }
            },
        },
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
        addProduk: {
            handler: function (baru) {
                if (baru != null) {
                    this.addKeranjang(baru);
                }
            },
        },
        maxScreen(data) {
            var elem = document.getElementById("screen");
            if (data) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    /* IE11 */
                    elem.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        },
    },
    methods: {
        resetMember() {
            this.tambah.member = {
                id: 0,
                nama: "Non-Member",
                alamat: "-",
                kontak: "-",
            };
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
        async addKeranjang(baru) {
            var keranjang = false;
            keranjang = await this.tambah.keranjang.find((item) => {
                if (item.kode == baru.kode) {
                    return item;
                }
            });
            if (keranjang) {
                if (keranjang.stok >= 1) {
                    keranjang.stok -= 1;
                    keranjang.jumlah += 1;
                    keranjang.subtotal =
                        keranjang.jumlah * keranjang.harga_jual;
                }
            } else {
                var produk = {
                    kode: baru.kode,
                    nama: baru.nama,
                    harga_jual: baru.harga_jual,
                    jumlah: 1,
                    stok: baru.stok - 1,
                    subtotal: baru.harga_jual,
                };
                this.tambah.keranjang.push(produk);
            }
            this.addProduk = null;
            this.master_hitung();
        },
        async master_hitung() {
            var total = await this.tambah.keranjang.reduce((a, b) => {
                return a + b.subtotal;
            }, 0);
            this.tambah.total = total;

            if (this.tambah.diskon.type == "%") {
                this.tambah.diskon.final =
                    this.tambah.total * (this.tambah.diskon.dummy / 100);
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
    },
};
</script>
<style lang=""></style>
