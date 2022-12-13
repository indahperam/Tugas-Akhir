<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Produk
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex justify-end gap-2 items-center">
                    <div>Tampilkan</div>
                    <select class="select select-sm select-bordered w-max">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact w-full text-center">
                        <thead>
                            <tr>
                                <th>kode</th>
                                <th>nama</th>
                                <th>kategori</th>
                                <th>harga beli</th>
                                <th>harga jual</th>
                                <th>satuan</th>
                                <th>stok</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in produk.data"
                                :key="index"
                                v-if="produk.data.length"
                            >
                                <td>{{ item.kode }}</td>
                                <td class="capitalize">{{ item.nama }}</td>
                                <td class="capitalize">
                                    {{ item.kategori.nama }}
                                </td>
                                <td>{{ rupiah(item.harga_beli) }}</td>
                                <td>{{ rupiah(item.harga_jual) }}</td>
                                <td class="capitalize">
                                    {{ item.satuan.nama }}
                                </td>
                                <td>{{ item.stok }}</td>
                                <td class="gap-2 flex justify-center">
                                    <label
                                        @click="editProduk(item)"
                                        for="edit"
                                        class="btn btn-xs btn-info"
                                        ><i class="fa fa-pen"></i
                                    ></label>
                                    <label
                                        @click="hapusProduk(item)"
                                        for="hapus"
                                        class="btn btn-xs btn-error"
                                        ><i class="fa fa-trash"></i
                                    ></label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <modal-md id="tambah">
        <template v-slot:title>Tambah Produk</template>
        <template v-slot:content>
            <input-text
                title="Nama Produk"
                v-model:inputValue="tambah.nama"
                :error="tambah.errors.nama"
            ></input-text>
            <div class="grid grid-cols-2 gap-2">
                <input-select
                    title="Kategori"
                    v-model:inputValue="tambah.kategori_id"
                    :error="tambah.errors.kategori_id"
                    :dataSelect="kategori"
                ></input-select>
                <input-select
                    title="Satuan"
                    v-model:inputValue="tambah.satuan_id"
                    :error="tambah.errors.satuan_id"
                    :dataSelect="satuan"
                ></input-select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <input-harga
                    title="Harga Beli"
                    v-model:inputValue="tambah.harga_beli"
                    :error="tambah.errors.harga_beli"
                ></input-harga>
                <input-harga
                    title="Harga Jual"
                    v-model:inputValue="tambah.harga_jual"
                    :error="tambah.errors.harga_jual"
                ></input-harga>
            </div>
            <input-number
                title="Stok"
                v-model:inputValue="tambah.stok"
                :error="tambah.errors.stok"
            ></input-number>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': tambah.processing }"
                @click="submitTambah"
            >
                tambah
            </button>
        </template>
    </modal-md>

    <modal-md id="edit">
        <template v-slot:title>Edit Produk {{ edit.kode }}</template>
        <template v-slot:content>
            <input-text
                title="Nama Produk"
                v-model:inputValue="edit.nama"
                :error="edit.errors.nama"
            ></input-text>
            <div class="grid grid-cols-2 gap-2">
                <input-select
                    title="Kategori"
                    v-model:inputValue="edit.kategori_id"
                    :error="edit.errors.kategori_id"
                    :dataSelect="kategori"
                ></input-select>
                <input-select
                    title="Satuan"
                    v-model:inputValue="edit.satuan_id"
                    :error="edit.errors.satuan_id"
                    :dataSelect="satuan"
                ></input-select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <input-harga
                    title="Harga Beli"
                    v-model:inputValue="edit.harga_beli"
                    :error="edit.errors.harga_beli"
                ></input-harga>
                <input-harga
                    title="Harga Jual"
                    v-model:inputValue="edit.harga_jual"
                    :error="edit.errors.harga_jual"
                ></input-harga>
            </div>
            <input-number
                title="Stok"
                v-model:inputValue="edit.stok"
                :error="edit.errors.stok"
            ></input-number>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': edit.processing }"
                @click="submitEdit"
            >
                edit
            </button>
        </template>
    </modal-md>

    <modal-md id="hapus">
        <template v-slot:title>Hapus Produk {{ hapus.nama }}</template>
        <template v-slot:action
            ><button
                class="btn btn-error"
                :class="{ 'loading btn-disabled': hapus.processing }"
                @click="submitHapus"
            >
                Hapus
            </button></template
        >
    </modal-md>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    layout: LayoutMain,
    props: {
        satuan: Array,
        kategori: Array,
        produk: Object,
    },
    setup() {
        const tambah = useForm({
            nama: null,
            kategori_id: null,
            satuan_id: null,
            harga_beli: null,
            harga_jual: null,
            stok: null,
        });
        const edit = useForm({
            id: null,
            kode: null,
            nama: null,
            kategori_id: null,
            satuan_id: null,
            harga_beli: null,
            harga_jual: null,
            stok: null,
        });
        const hapus = useForm({
            id: null,
            nama: null,
        });
        return {
            tambah,
            edit,
            hapus,
        };
    },
    methods: {
        submitTambah() {
            this.tambah.post(route("produk.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.modal_close("tambah");
                    this.notifikasi("success", "produk berhasil ditambahkan");
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("produk.update", {
                    produk: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.edit.reset();
                        this.modal_close("edit");
                        this.notifikasi(
                            "success",
                            "perubahan berhasil di simpan"
                        );
                    },
                }
            );
        },
        submitHapus() {
            this.hapus.delete(
                route("produk.destroy", {
                    produk: this.hapus.id,
                }),
                {
                    onSuccess: () => {
                        this.hapus.reset();
                        this.modal_close("hapus");
                        this.notifikasi("success", "Produk berhasil dihapus");
                    },
                }
            );
        },
        editProduk(data) {
            this.edit.id = data.id;
            this.edit.kode = data.kode;
            this.edit.nama = data.nama;
            this.edit.kategori_id = data.kategori_id;
            this.edit.satuan_id = data.satuan_id;
            this.edit.harga_jual = data.harga_jual;
            this.edit.harga_beli = data.harga_beli;
            this.edit.stok = data.stok;
        },
        hapusProduk(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
    },
};
</script>
<style lang=""></style>
