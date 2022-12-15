<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Satuan
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full table-compact shadow card">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Nama</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <transition-group name="list">
                            <tr
                                v-for="(item, index) in satuan"
                                :key="index"
                                class="capitalize"
                                v-if="satuan.length"
                            >
                                <td class="pl-4">{{ index + 1 }}</td>
                                <td>{{ item.nama }}</td>
                                <td class="flex gap-2">
                                    <label
                                        for="edit"
                                        @click="editSatuan(item)"
                                        class="btn btn-xs btn-info"
                                    >
                                        <i class="fa fa-pen"></i
                                    ></label>
                                    <label
                                        for="hapus"
                                        @click="hapusSatuan(item)"
                                        class="btn btn-xs btn-error"
                                    >
                                        <i class="fa fa-trash"></i
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
        <template v-slot:title>Tambah Satuan</template>
        <template v-slot:content>
            <input-text
                title="Nama Satuan"
                :error="tambah.errors.nama"
                v-model:inputValue="tambah.nama"
            ></input-text>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :class="{ 'loading btn-disabled': tambah.processing }"
                @click="submitTambah"
            >
                simpan
            </button>
        </template>
    </modal-md>
    <modal-md id="edit">
        <template v-slot:title>edit satuan {{ edit.nama }}</template>
        <template v-slot:content>
            <input-text
                title="Nama Satuan"
                v-model:inputValue="edit.nama"
                :error="edit.errors.nama"
            ></input-text>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-info"
                @click="submitEdit"
                :class="{ 'loading btn-disabled': edit.processing }"
            >
                edit
            </button></template
        >
    </modal-md>
    <modal-md id="hapus">
        <template v-slot:title>Hapus Satuan {{ hapus.nama }}</template>
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
        satuan: Array,
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
            this.tambah.post(route("satuan.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.modal_close("tambah");
                    this.notifikasi("success", "satuan berhasil ditambahkan");
                },
            });
        },
        submitEdit() {
            this.edit.put(route("satuan.update", { satuan: this.edit.id }), {
                onSuccess: () => {
                    this.edit.reset();
                    this.modal_close("edit");
                    this.notifikasi("success", "perubahan telah disimpan");
                },
            });
        },
        submitHapus() {
            this.hapus.delete(
                route("satuan.destroy", { satuan: this.hapus.id }),
                {
                    onSuccess: () => {
                        this.hapus.reset();
                        this.modal_close("hapus");
                        this.notifikasi("success", "satuan telah di hapus");
                    },
                }
            );
        },
        editSatuan(data) {
            this.edit.id = data.id;
            this.edit.nama = data.nama;
        },
        hapusSatuan(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
    },
};
</script>
<style lang=""></style>
