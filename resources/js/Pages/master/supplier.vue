<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Supplier
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <div class="mt-4">
                <datatable
                    :dataPage="supplier.links"
                    :dataTotal="supplier.total"
                    v-model:inputSearch="cari"
                    v-model:inputShow="itemShow"
                >
                    <template v-slot:content>
                        <div class="overflow-x-auto scrollbar-hide">
                            <table
                                class="table table-compact shadow-md w-full text-center"
                            >
                                <thead>
                                    <tr>
                                        <td>kode</td>
                                        <td>nama</td>
                                        <td>kontak</td>
                                        <td>alamat</td>
                                        <td>action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <transition-group name="listv2">
                                        <tr
                                            v-for="(
                                                item, index
                                            ) in supplier.data"
                                            :key="item.id"
                                        >
                                            <td>{{ item.kode }}</td>
                                            <td class="capitalize">
                                                {{ item.nama }}
                                            </td>
                                            <td>{{ item.kontak }}</td>
                                            <td>{{ item.alamat }}</td>
                                            <td
                                                class="flex justify-center gap-2"
                                            >
                                                <label
                                                    for="edit"
                                                    @click="editSupplier(item)"
                                                    class="btn btn-xs btn-info"
                                                    ><i class="fa fa-pen"></i
                                                ></label>
                                                <label
                                                    for="hapus"
                                                    @click="hapusSupplier(item)"
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
    </div>
    <modal-md id="tambah">
        <template v-slot:title>Tambah Supplier</template>
        <template v-slot:content>
            <input-text
                title="Nama Supplier"
                v-model:inputValue="tambah.nama"
                :error="tambah.errors.nama"
            ></input-text>
            <input-text
                title="Alamat"
                v-model:inputValue="tambah.alamat"
                :error="tambah.errors.alamat"
            ></input-text>
            <input-text
                title="Kontak"
                v-model:inputValue="tambah.kontak"
                :error="tambah.errors.kontak"
            ></input-text>
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
        <template v-slot:title>Edit Supplier {{ edit.kode }}</template>
        <template v-slot:content>
            <input-text
                title="Nama Supplier"
                v-model:inputValue="edit.nama"
                :error="edit.errors.nama"
            ></input-text>
            <input-text
                title="Alamat"
                v-model:inputValue="edit.alamat"
                :error="edit.errors.alamat"
            ></input-text>
            <input-text
                title="Kontak"
                v-model:inputValue="edit.kontak"
                :error="edit.errors.kontak"
            ></input-text>
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
        <template v-slot:title>Hapus Supplier {{ hapus.nama }}</template>
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
    setup() {
        const tambah = useForm({
            nama: null,
            alamat: null,
            kontak: null,
        });
        const edit = useForm({
            id: null,
            kode: null,
            nama: null,
            alamat: null,
            kontak: null,
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
            this.tambah.post(route("supplier.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.notifikasi("success", "supplier berhasil ditambahkan");
                    this.modal_close("tambah");
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("supplier.update", {
                    supplier: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.edit.reset();
                        this.notifikasi(
                            "success",
                            "perubahan berhasil di simpan"
                        );
                        this.modal_close("edit");
                    },
                }
            );
        },
        submitHapus() {
            this.hapus.delete(
                route("supplier.destroy", {
                    supplier: this.hapus.id,
                }),
                {
                    onSuccess: () => {
                        this.hapus.reset();
                        this.notifikasi(
                            "success",
                            "perubahan berhasil di simpan"
                        );
                        this.modal_close("hapus");
                    },
                }
            );
        },
        editSupplier(data) {
            this.edit.id = data.id;
            this.edit.kode = data.kode;
            this.edit.nama = data.nama;
            this.edit.kontak = data.kontak;
            this.edit.alamat = data.alamat;
        },
        hapusSupplier(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
    },
    props: {
        supplier: Object,
        search: String,
        showItem: String,
    },
    data() {
        return {
            cari: this.search,
            itemShow: this.showItem,
        };
    },
    watch: {
        cari() {
            this.$inertia.visit(
                route("supplier.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "supplier"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("supplier.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "supplier"],
                }
            );
        },
    },
};
</script>
<style lang=""></style>
