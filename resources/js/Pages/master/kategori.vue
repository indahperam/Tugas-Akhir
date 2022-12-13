<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Kategori
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-compact w-full card">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>nama</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <transition-group name="list">
                            <tr
                                v-for="(item, index) in kategori"
                                :key="index"
                                class="capitalize"
                                v-if="kategori.length"
                            >
                                <td class="pl-4">{{ index + 1 }}</td>
                                <td>{{ item.nama }}</td>
                                <td class="flex gap-2">
                                    <label
                                        for="edit"
                                        @click="editKategori(item)"
                                        class="btn btn-xs btn-info"
                                        ><i class="fa fa-pen"></i
                                    ></label>
                                    <label
                                        for="hapus"
                                        @click="hapusKategori(item)"
                                        class="btn btn-xs btn-error"
                                        ><i class="fa fa-trash"></i
                                    ></label>
                                </td>
                            </tr>
                            <tr v-else>
                                <td colspan="3" class="text-center">
                                    Belum Ada Data
                                </td>
                            </tr>
                        </transition-group>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <modal-md id="tambah">
        <template v-slot:title>Tambah Kategori</template>
        <template v-slot:content>
            <input-text
                title="Nama Kategori"
                v-model:inputValue="tambah.nama"
                :error="tambah.errors.nama"
            ></input-text>
        </template>
        <template v-slot:action
            ><button
                @click="submitTambah"
                class="btn btn-success"
                :class="{ 'loading btn-disabled': tambah.processing }"
            >
                tambah
            </button></template
        >
    </modal-md>
    <modal-md id="edit">
        <template v-slot:title>Edit Kategori {{ edit.nama }}</template>
        <template v-slot:content>
            <input-text
                title="Nama Kategori"
                v-model:inputValue="edit.nama"
                :error="edit.errors.nama"
            ></input-text>
        </template>
        <template v-slot:action
            ><button
                @click="submitEdit"
                class="btn btn-success"
                :class="{ 'loading btn-disabled': edit.processing }"
            >
                edit
            </button></template
        >
    </modal-md>
    <modal-md id="hapus">
        <template v-slot:title>Hapus Kategori {{ hapus.nama }}</template>
        <template v-slot:content>
            <p>
                Produk yang terkait dengan <b>'{{ hapus.nama }}'</b> akan di
                hapus secara permanen. Pindahkan terlebih dahulu data untuk
                melanjutkan.
            </p>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-error"
                @click="submitHapus"
                :class="{ 'loading btn-disabled': hapus.processing }"
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
        kategori: Array,
    },
    setup() {
        const tambah = useForm({
            nama: null,
        });
        const edit = useForm({
            id: null,
            nama: null,
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
            this.tambah.post(route("kategori.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.modal_close("tambah");
                    this.notifikasi("success", "kategori berhasil ditambahkan");
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("kategori.update", {
                    kategori: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.edit.reset();
                        this.modal_close("edit");
                        this.notifikasi("success", "data berhasil disimpan");
                    },
                }
            );
        },
        submitHapus() {
            this.hapus.delete(
                route("kategori.destroy", {
                    kategori: this.hapus.id,
                }),
                {
                    onSuccess: () => {
                        this.hapus.reset();
                        this.modal_close("hapus");
                        this.notifikasi("success", "kategori berhasil dihapus");
                    },
                }
            );
        },
        editKategori(data) {
            this.edit.id = data.id;
            this.edit.nama = data.nama;
        },
        hapusKategori(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
    },
};
</script>
<style lang=""></style>
