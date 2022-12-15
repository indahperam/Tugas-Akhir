<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title mb-4">
                List Jenis Pembayaran
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
            </div>
            <div class="overflow-x-auto scrollbar-hide">
                <table class="table table-compact w-full text-center">
                    <thead>
                        <tr>
                            <td>jenis</td>
                            <td>no rek</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <transition-group name="listv2">
                            <tr
                                v-for="(item, index) in jenis_pembayaran"
                                :key="item.id"
                            >
                                <td>{{ item.jenis }}</td>
                                <td>{{ item.no_rek }}</td>
                                <td class="flex justify-center gap-2">
                                    <label
                                        for="edit"
                                        class="btn btn-xs btn-info"
                                        @click="editJenisPembayaran(item)"
                                        ><i class="fa fa-pen"></i
                                    ></label>
                                    <label
                                        for="hapus"
                                        class="btn btn-xs btn-error"
                                        @click="hapusJenisPembayaran(item)"
                                        ><i class="fa fa-trash"></i
                                    ></label>
                                </td>
                            </tr>
                        </transition-group>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <modal-md id="tambah">
        <template v-slot:title>Tambah Jenis Pembayaran</template>
        <template v-slot:content
            ><input-text
                title="Jenis Pembayaran"
                v-model:inputValue="tambah.jenis"
                :error="tambah.errors.jenis"
            ></input-text
            ><input-text
                title="No Rekening"
                v-model:inputValue="tambah.no_rek"
                :error="tambah.errors.no_rek"
            ></input-text
        ></template>
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
        <template v-slot:title>Ubah Jenis Pembayaran</template>
        <template v-slot:content
            ><input-text
                title="Jenis Pembayaran"
                v-model:inputValue="edit.jenis"
                :error="edit.errors.jenis"
            ></input-text
            ><input-text
                title="No Rekening"
                v-model:inputValue="edit.no_rek"
                :error="edit.errors.no_rek"
            ></input-text
        ></template>
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
        <template v-slot:title
            >Hapus Jenis Pembayaran {{ hapus.jenis }}</template
        >
        <template v-slot:action
            ><button
                class="btn btn-error"
                :class="{ 'loading btn-disabled': hapus.processing }"
                @click="submitHapus"
            >
                hapus
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
        jenis_pembayaran: Array,
    },
    setup() {
        const tambah = useForm({
            jenis: null,
            no_rek: null,
        });
        const edit = useForm({
            id: null,
            jenis: null,
            no_rek: null,
        });
        const hapus = useForm({
            id: null,
            jenis: null,
        });
        return {
            tambah,
            edit,
            hapus,
        };
    },
    methods: {
        submitTambah() {
            this.tambah.post(route("jenis-pembayaran.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.notifikasi(
                        "success",
                        "jenis pembayaran telah ditambahkan"
                    );
                    this.modal_close("tambah");
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("jenis-pembayaran.update", {
                    jenis_pembayaran: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.edit.reset();
                        this.notifikasi(
                            "success",
                            "perubahan berhasil disimpan"
                        );
                        this.modal_close("edit");
                    },
                }
            );
        },
        submitHapus() {
            this.hapus.delete(
                route("jenis-pembayaran.destroy", {
                    jenis_pembayaran: this.hapus.id,
                }),
                {
                    onSuccess: () => {
                        this.hapus.reset();
                        this.notifikasi(
                            "success",
                            "jenis pembayaran berhasil di hapus"
                        );
                        this.modal_close("hapus");
                    },
                }
            );
        },
        editJenisPembayaran(data) {
            this.edit.id = data.id;
            this.edit.jenis = data.jenis;
            this.edit.no_rek = data.no_rek;
        },
        hapusJenisPembayaran(data) {
            this.hapus.id = data.id;
            this.hapus.jenis = data.jenis;
        },
    },
};
</script>
<style lang=""></style>
