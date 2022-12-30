<template lang="">
    <div class="card shadow-lg bg-base-100 z-0" id="screen">
        <div class="card-body" v-if="closing > 0">
                    <modal-lg id="closing">
                        <template v-slot:title>detail closing {{closing_data.waktu}}</template>
                        <template v-slot:content>
                            <div class="w-full grid grid-cols-2">
                                <div class="w-full grid grid-cols-2 gap-2 p-2">
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">tgl. transaksi</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.waktu" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">id closing</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.kode" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize col-span-2">
                                        <label class="label">
                                            <span class="label-text">User</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.user.name" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">nota awal</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.nota_awal" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">nota akhir</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.nota_akhir" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">total nota</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.total_nota" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">total nota dihapus</span>
                                        </label>
                                        <input type="text" disabled :value="closing_data.total_nota_duhapus" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize col-span-2">
                                        <label class="label">
                                            <span class="label-text">modal awal</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_data.modal_awal)" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">Tunai</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_data.cash)" class="input input-bordered">
                                    </div>
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text">transfer</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_data.transfer)" class="input input-bordered">
                                    </div>
                                </div>
                                <div class="flex flex-col px-4 py-2 bg-primary rounded-lg">
                                    <div class="form-control capitalize">
                                        <label class="label">
                                            <span class="label-text text-white">Gross Sales</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_data.gross_sales)" class="input input-bordered">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="form-control capitalize">
                                            <label class="label">
                                                <span class="label-text text-white">diskon</span>
                                            </label>
                                            <input type="text" disabled :value="rupiah(closing_data.diskon)" class="input input-bordered">
                                        </div>
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text text-white">PPN</span>
                                            </label>
                                            <input type="text" disabled :value="rupiah(closing_data.ppn)" class="input input-bordered">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="form-control capitalize">
                                            <label class="label">
                                                <span class="label-text text-white">net Sales</span>
                                            </label>
                                            <input type="text" disabled :value="rupiah(closing_data.gross_sales)" class="input input-bordered">
                                        </div>
                                        <div class="form-control capitalize">
                                            <label class="label">
                                                <span class="label-text text-white">avg. sales</span>
                                            </label>
                                            <input type="text" disabled :value="rupiah(closing_data.rata_rata)" class="input input-bordered">
                                        </div>
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-white">Pengeluaran</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_data.pengeluaran)" class="input input-bordered">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-white">Total Uang Tunai : {{rupiah(closing_form.total_uang_tunai)}}</span>
                                        </label>
                                        <input type="number" v-model="closing_form.total_uang_tunai" class="input input-bordered">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-white">Selisih</span>
                                        </label>
                                        <input type="text" disabled :value="rupiah(closing_form.selisih)" class="input input-bordered">
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-slot:action>
                            <label for="submit_closing" class="btn btn-success">closing</label>
                            <modal-md id="submit_closing">
                                <template v-slot:title>Konfirmasi Closing</template>
                                <template v-slot:content>
                                    <input-password title="Password" :error="closing_form.errors.password" v-model:inputValue="closing_form.password"></input-password>
                                </template>
                                <template v-slot:action><button class="btn btn-success" :class="{'loading btn-disabled' : closing_form.processing}" @click="submit_closing_form">konfirmasi</button></template>
                            </modal-md>
                        </template>
                    </modal-lg>
            <div class="flex justify-between">
                <div class="card-title mb-4">
                    Menu Penjualan
                    <label for="closing" class="btn btn-sm btn-warning"
                        >closing</label
                    >
                </div>
                <label class="swap swap-rotate btn btn-ghost btn-sm text-xl">
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
                <div class="w-[24rem] h-max max-h-[10rem] card shadow-lg">
                    <div
                        class="m-4 relative overflow-y-auto scrollbar-thin scrollbar-track-base-200 scrollbar-thumb-primary"
                    >
                        <div class="sticky top-0 bg-base-100 py-2">
                            Transaksi Aktif
                        </div>
                        <ul
                            class="flex gap-5 mt-1"
                            v-for="(item, index) in transaksi_aktif"
                            :key="item.kode"
                            v-if="transaksi_aktif.length > 0"
                        >
                            <li class="flex items-center gap-4">
                                <div class="bg-success p-1 rounded-full"></div>
                                {{ item.kode }}
                            </li>
                            <li class="flex items-center gap-4">
                                {{ item.waktu }}
                            </li>
                            <li class="flex items-center gap-1">
                                <label
                                    @click="moveTransaksi(item)"
                                    for="selectTransaksi"
                                    class="btn btn-success btn-xs"
                                >
                                    <i class="fa fa-pen"></i>
                                </label>
                                <label
                                    @click="removeTransaksi(item)"
                                    for="hapusTransaksi"
                                    class="btn btn-error btn-xs"
                                >
                                    <i class="fa fa-trash"></i
                                ></label>
                            </li>
                        </ul>
                        <ul v-else class="text-center">
                            belum ada data
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="flex items-center gap-4 z-10">
                    <div class="">Produk</div>
                    <input-pick
                        :dataPick="produk"
                        v-model:dataSelect="addProduk"
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
                            <td class="text-center">Stok</td>
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
                                <td>{{ rupiah(item.harga_jual) }}</td>
                                <td class="text-center">{{ item.stok }}</td>
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
                                        :class="{
                                            'btn-disabled':
                                                tambah.keranjang.length < 1,
                                        }"
                                        for="bayar"
                                        class="btn btn-success btn-sm w-max"
                                        >Bayar
                                    </label>
                                    <label
                                        for=""
                                        class="btn btn-secondary btn-sm w-max"
                                        v-if="tambah.member.id != 0"
                                        :class="{
                                            'btn-disabled':
                                                tambah.keranjang.length < 1,
                                        }"
                                        @click="hutang"
                                        >hutang</label
                                    >
                                    <label
                                        for=""
                                        @click="simpan"
                                        :class="{
                                            'btn-disabled':
                                                tambah.keranjang.length < 1 ||
                                                tambah.id != 0,
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
        <div class="card-body" v-else>
            <label for="opening" class="btn btn-info">OPEN shift</label>
            <modal-md id="opening">
                <template v-slot:content>
                    <input-harga
                        v-model:inputValue="opening.modal_awal"
                        :error="opening.errors.modal_awal"
                        title="Modal Awal"
                    >
                    </input-harga>
                </template>
                <template v-slot:action>
                    <button
                        @click="submit_opening"
                        :class="
                            opening.processing ? 'btn-disabled loading' : ''
                        "
                        class="btn btn-success"
                    >
                        Opening
                    </button>
                </template>
            </modal-md>
        </div>
    </div>
    <modal-md id="bayar" :location="maxScreen ? '#screen' : ''">
        <template v-slot:title>Metode Pembayaran</template>
        <template v-slot:content>
            <input-select
                title="Metode Pembayaran"
                :dataSelect="jenis_pembayaran"
                v-model:inputValue="tambah.bayar.jenis"
                label="jenis"
            ></input-select>
            <input-text
                v-if="!tambah.bayar.jenis.toLowerCase().includes('tunai')"
                title="No Transaksi"
                v-model:inputValue="tambah.bayar.no_transaksi"
            ></input-text>
            <div class="flex flex-col gap-4">
                <input-harga
                    v-model:inputValue="tambah.bayar.final"
                    :disabled="tambah.keranjang.length < 1"
                    :location="maxScreen ? '#screen' : false"
                    title="Bayar"
                ></input-harga>
            </div>
            <div class="grid grid-cols-4 py-4 gap-4">
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = tambah.grand_total"
                >
                    uang pas
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = 100000"
                >
                    Rp 100.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = 50000"
                >
                    Rp 50.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = 20000"
                >
                    Rp 20.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = 10000"
                >
                    Rp 10.000
                </button>
                <button
                    class="btn btn-sm btn-outline"
                    @click="tambah.bayar.final = 5000"
                >
                    Rp 5.000
                </button>
            </div>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': tambah.processing }"
                @click="submitTransaksi"
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
import inputPassword from './../../Components/inputPassword.vue'

export default {
    layout: LayoutMain,
    components: { 'modal-lg': ModalLg, 'input-password': inputPassword },
    props: [
        "produk",
        "user_aktif",
        "member",
        "jenis_pembayaran",
        "transaksi_aktif",
        "closing",
        "closing_data",
    ],
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
            member: {
                id: 0,
                nama: "non-member",
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
        const opening = useForm({
            modal_awal: 0,
        });
        const closing_form = useForm({
            id: props.closing_data.id,
            kode: props.closing_data.kode,
            user_id: props.closing_data.user_id,
            nota_awal: props.closing_data.nota_awal,
            nota_akhir: props.closing_data.nota_akhir,
            total_nota: props.closing_data.total_nota,
            total_nota_hapus: props.closing_data.total_nota_hapus,
            modal_awal: props.closing_data.modal_awal,
            cash: props.closing_data.cash,
            transfer: props.closing_data.transfer,
            gross_sales: props.closing_data.gross_sales,
            diskon: props.closing_data.diskon,
            ppn: props.closing_data.ppn,
            net_sales: props.closing_data.net_sales,
            rata_rata: props.closing_data.rata_rata,
            pengeluaran: props.closing_data.pengeluaran,
            selisih: props.closing_data.selisih,
            status: 'close',
            total_uang_tunai: 0,
            password: '',
        });
        return {
            tambah,
            opening,
            closing_form
        };
    },
    data() {
        return {
            maxScreen: false,
            addProduk: null,
            addMember: null,
            dataMember: this.member,
            click_check: false,
            looping_state: null,
            debounce_time: null,
        };
    },
    watch: {
        'closing_form.total_uang_tunai'(data) {
            this.closing_form.selisih = this.closing_data.selisih + data
        },
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
        submit_closing_form() {
            this.closing_form.put(route('closing.update', {
                closing: this.closing_form.id
            }))
        },
        submit_opening() {
            this.opening.post(route("closing.store"), {
                onSuccess: () => {
                    // this.modal_close('closing')
                    this.notifikasi("success", "shift telah dijalanan!");
                },
            });
        },
        removeTransaksi(data) {
            this.$inertia.delete(
                route("transaksi.hapus", {
                    transaksi: data.id,
                }),
                {
                    onSuccess: () => {
                        this.$swal({
                            icon: "success",
                            text: "Transaksi berhasil di hapus",
                        });
                    },
                }
            );
        },
        moveTransaksi(data) {
            var produk = JSON.parse(JSON.stringify(data.transaksi_detail));
            this.tambah.id = data.id;
            this.tambah.kode = data.kode;
            this.tambah.keranjang = produk;
            this.tambah.total = data.total;
            this.tambah.diskon.type = "%";
            this.tambah.diskon.dummy = data.diskon;
            this.tambah.diskon.final = data.diskon_total;
            this.tambah.ppn = data.ppn;
            this.tambah.ppn_total = data.ppn_total;
            this.tambah.grand_total = data.grand_total;
            if (data.member_id == 0) {
                this.tambah.member.id = 0;
                this.tambah.member.nama = "non-member";
                this.tambah.member.alamat = "-";
                this.tambah.member.kontak = "-";
            } else {
                this.tambah.member.id = data.member.id;
                this.tambah.member.nama = data.member.nama;
                this.tambah.member.alamat = data.member.alamat;
                this.tambah.member.kontak = data.member.kontak;
            }
        },
        hutang() {
            this.tambah.post(route("transaksi.hutang"), {
                onSuccess: async () => {
                    this.tambah.reset();
                    this.$swal({
                        icon: "success",
                        text: "Hutang Berhasil di simpan",
                    });
                },
            });
        },
        simpan() {
            this.tambah.post(route("transaksi.save"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.$swal({
                        icon: "success",
                        text: "Transaksi Berhasil di simpan",
                    });
                },
            });
        },
        async removeProduk(kode) {
            await this.tambah.keranjang.find((item, index) => {
                if (item.kode === kode) {
                    this.tambah.keranjang.splice(index, 1);
                    return item;
                }
            });
            await this.master_hitung();
        },
        async print_invoice() {
            var print = await window.open(route("print_lunas"));
            await print.addEventListener("DOMContentLoaded", () => {
                print.window.print();
                print.window.onafterprint = (event) => {
                    print.close();
                };
            });
        },
        submitTransaksi() {
            if (this.tambah.bayar.final < this.tambah.grand_total) {
                this.modal_close("bayar");
                this.$swal({
                    target: "#screen",
                    icon: "error",
                    title: "Proses Gagal",
                    text: "Pembayaran tidak sesuai, uang diterima harus lebih atau sama dengan pembayaran",
                });
            } else {
                this.tambah.post(route("transaksi.simpan"), {
                    onSuccess: async (data) => {
                        this.modal_close("bayar");
                        await this.$swal({
                            target: "#screen",
                            icon: "success",
                            title: `Kembalian ${this.rupiah(
                                this.tambah.bayar.final -
                                this.tambah.grand_total
                            )}`,
                            text: "Transaksi Berhasil",
                        });
                        this.print_invoice();
                        this.tambah.reset();
                    },
                });
            }
        },
        resetMember() {
            this.tambah.member = {
                id: 0,
                nama: "non-member",
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
                if (keranjang.stok >= 1) {
                    keranjang.stok -= 1;
                    keranjang.jumlah = parseInt(keranjang.jumlah) + 1;
                    keranjang.subtotal =
                        keranjang.jumlah * keranjang.harga_jual;
                } else {
                    this.$swal({
                        icon: "warning",
                        text: "Pesanan telah mencapai batas stok tersedia.",
                    });
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
                        keranjang.jumlah * keranjang.harga_jual;
                } else {
                    this.$swal({
                        icon: "warning",
                        text: "Minimal Pemesanan Produk berjumlah 1.",
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
    },
};
</script>
<style lang=""></style>
