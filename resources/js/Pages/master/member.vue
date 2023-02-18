<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">
                List Data Member
                <label for="tambah" class="btn btn-xs btn-success"
                    ><i class="fa fa-plus"></i
                ></label>
                <button class="btn btn-xs" @click="printMember()"
                    ><i class="fa fa-print"></i
                ></button>
            </div>
            <div class="mt-4">
                <datatable
                    :dataPage="member.links"
                    :dataTotal="member.total"
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
                                            v-for="(item, index) in member.data"
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
                                                    @click="editMember(item)"
                                                    class="btn btn-xs btn-info"
                                                    ><i class="fa fa-pen"></i
                                                ></label>
                                                <label
                                                    for="hapus"
                                                    @click="hapusMember(item)"
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
        <template v-slot:title>Tambah Member</template>
        <template v-slot:content>
            <input-text
                title="Nama Member"
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
        <template v-slot:title>Edit Member {{ edit.kode }}</template>
        <template v-slot:content>
            <input-text
                title="Nama Member"
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
        <template v-slot:title>Hapus Member {{ hapus.nama }}</template>
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
            this.tambah.post(route("member.store"), {
                onSuccess: () => {
                    this.tambah.reset();
                    this.notifikasi("success", "member berhasil ditambahkan");
                    this.modal_close("tambah");
                },
            });
        },
        submitEdit() {
            this.edit.put(
                route("member.update", {
                    member: this.edit.id,
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
                route("member.destroy", {
                    member: this.hapus.id,
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
        editMember(data) {
            this.edit.id = data.id;
            this.edit.kode = data.kode;
            this.edit.nama = data.nama;
            this.edit.kontak = data.kontak;
            this.edit.alamat = data.alamat;
        },
        hapusMember(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
        async printMember() {
            let print = await window.open(route('member.print_all'))
            await print.addEventListener("DOMContentLoaded", () => {
                print.window.onafterprint = (event) => {
                    print.close();
                };
                print.window.print()
            });

        }
    },
    props: {
        member: Object,
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
                route("member.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "member"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("member.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "member"],
                }
            );
        },
    },
};
</script>
<style lang=""></style>
