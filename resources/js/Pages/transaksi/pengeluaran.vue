<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title mb-4">
                List Data Pengeluaran
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <datatable
                :dataPage="pengeluaran.links"
                :dataTotal="pengeluaran.total"
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
                                    <td>tanggal</td>
                                    <td>jenis</td>
                                    <td>nominal</td>
                                    <td>keterangan</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(
                                            item, index
                                        ) in pengeluaran.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.kode }}</td>
                                        <td>{{ item.tanggal }}</td>
                                        <td>{{ item.jenis_transaksi }}</td>
                                        <td>{{ rupiah(item.nominal) }}</td>
                                        <td>{{ item.keterangan }}</td>
                                        <td class="flex justify-center gap-2">
                                            <label
                                                @click="editPengeluaran(item)"
                                                for="edit"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                @click="hapusPengeluaran(item)"
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
    <modal-md id="tambah">
        <template v-slot:title>Tambah pengeluaran</template>
        <template v-slot:content>
            <input-textarea
                title="Keterangan Pengeluaran"
                v-model:inputValue="tambah.keterangan"
                :error="tambah.errors.keterangan"
            ></input-textarea>
            <input-date
                title="Tanggal Pengeluaran"
                v-model:inputValue="tambah.tanggal_input"
                :error="tambah.errors.tanggal_input"
            ></input-date>
            <div class="grid grid-cols-2 gap-2">
                <input-select
                    title="Pilih Metode"
                    :dataSelect="jenis_pembayaran"
                    label="jenis"
                    v-model:inputValue="tambah.jenis_transaksi"
                    :error="tambah.errors.jenis_transaksi"
                ></input-select>
                <input-harga
                    title="Nominal"
                    v-model:inputValue="tambah.nominal"
                    :error="tambah.errors.nominal"
                ></input-harga>
            </div>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': tambah.processing }"
                @click="submitTambah"
            >
                tambah
            </button></template
        >
    </modal-md>

    <modal-md id="edit">
        <template v-slot:title>Edit pengeluaran </template>
        <template v-slot:content>
            <input-textarea
                title="Keterangan Pengeluaran"
                v-model:inputValue="edit.keterangan"
                :error="edit.errors.keterangan"
            ></input-textarea>
            <input-date
                title="Tanggal Pengeluaran"
                v-model:inputValue="edit.tanggal_input"
                :error="edit.errors.tanggal_input"
            ></input-date>
            <div class="grid grid-cols-2 gap-2">
                <input-select
                    title="Pilih Metode"
                    :dataSelect="jenis_pembayaran"
                    label="jenis"
                    v-model:inputValue="edit.jenis_transaksi"
                    :error="edit.errors.jenis_transaksi"
                ></input-select>
                <input-harga
                    title="Nominal"
                    v-model:inputValue="edit.nominal"
                    :error="edit.errors.nominal"
                ></input-harga>
            </div>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': edit.processing }"
                @click="submitEdit"
            >
                edit
            </button></template
        >
    </modal-md>
    <modal-md id="hapus">
        <template v-slot:title>Hapus Pengeluaran {{ hapus.kode }}</template>
        <template v-slot:action>
            <button
                class="btn btn-error"
                :class="{ 'loading btn-disabled': hapus.processing }"
                @click="submitHapus"
            >
                hapus
            </button>
        </template>
    </modal-md>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    layout: LayoutMain,
    props: {
        pengeluaran: Object,
        jenis_pembayaran: Array,
        search: String,
        showItem: Number,
        dari: String,
        sampai: String,
    },
    setup() {
        const tambah = useForm({
            jenis_transaksi: null,
            nominal: null,
            keterangan: null,
            tanggal_input: null,
        });
        const edit = useForm({
            id: null,
            kode: null,
            jenis_transaksi: null,
            nominal: null,
            keterangan: null,
            tanggal_input: null,
        });
        const hapus = useForm({
            id: null,
            kode: null,
        });
        return {
            tambah,
            edit,
            hapus,
        };
    },
    methods: {
        submitTambah() {
            this.tambah.post(route("pengeluaran.store"), {
                onSuccess: () => {
                    this.modal_close("tambah");
                    this.notifikasi(
                        "success",
                        "pengeluaran berhasil ditambahkan"
                    );
                    this.tambah.reset();
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("pengeluaran.update", {
                    pengeluaran: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.modal_close("edit");
                        this.notifikasi(
                            "success",
                            "perubahan berhasil di simpan"
                        );
                        this.edit.reset();
                    },
                }
            );
        },
        submitHapus() {
            this.hapus.delete(
                route("pengeluaran.destroy", {
                    pengeluaran: this.hapus.id,
                }),
                {
                    onSuccess: () => {
                        this.modal_close("hapus");
                        this.notifikasi("success", "data berhasil di hapus");
                        this.hapus.reset();
                    },
                }
            );
        },
        editPengeluaran(data) {
            this.edit.id = data.id;
            this.edit.kode = data.kode;
            this.edit.nominal = data.nominal;
            this.edit.jenis_transaksi = data.jenis_transaksi;
            this.edit.tanggal_input = data.tanggal_input;
            this.edit.keterangan = data.keterangan;
        },
        hapusPengeluaran(data) {
            this.hapus.id = data.id;
            this.hapus.kode = data.kode;
        },
    },
    data() {
        return {
            cari: this.search,
            itemShow: this.showItem,
            cari_dari: this.dari,
            cari_sampai: this.sampai,
        };
    },
    watch: {
        cari_dari() {
            this.$inertia.visit(
                route("pengeluaran.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pengeluaran"],
                }
            );
        },
        cari_sampai() {
            this.$inertia.visit(
                route("pengeluaran.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pengeluaran"],
                }
            );
        },
        cari() {
            this.$inertia.visit(
                route("pengeluaran.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pengeluaran"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("pengeluaran.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                    dari: this.cari_dari,
                    sampai: this.cari_sampai,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "pengeluaran"],
                }
            );
        },
    },
};
</script>
<style lang=""></style>
