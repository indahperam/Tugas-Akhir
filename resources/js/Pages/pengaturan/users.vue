<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
        <modal-md id="tambah">
            <template v-slot:title>Tambah User</template>
            <template v-slot:content>
                <input-text title="Nama" :error="tambah.errors.name" v-model:inputValue="tambah.name"></input-text>
                <input-text title="Email" :error="tambah.errors.email" v-model:inputValue="tambah.email"></input-text>
                <input-select title="Role" label="nama" :error="tambah.errors.role" :dataSelect="DataRole" v-model:inputValue="tambah.role"></input-select>
                <input-password title="Password" :error="tambah.errors.password" v-model:inputValue="tambah.password"></input-password>
                <input-password title="Konfirmasi Password" :error="tambah.errors.password_confirmation" v-model:inputValue="tambah.password_confirmation"></input-password>
            </template>
            <template v-slot:action>
                <button class="btn btn-success" @click="submit_tambah" :class="{'btn-disabled loading' : tambah.processing}">tambah</button>
            </template>
        </modal-md>
            <div class="card-title mb-4">List Data Users <label for="tambah" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></label></div>
            <datatable
                :dataPage="user.links"
                :dataTotal="user.total"
                v-model:inputSearch="cari"
                v-model:inputShow="itemShow"
            >
            <template v-slot:content>
                    <div class="mt-4 overflow-x-auto scrollbar-hide">
                        <table class="table table-compact w-full text-center">
                            <thead>
                                <tr>
                                    <td>Nama</td>
                                    <td>Role</td>
                                    <td>kontak</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <transition-group name="listv2">
                                    <tr
                                        v-for="(item, index) in user.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.name }}</td>
                                        <td>
                                            {{item.role}}
                                        </td>
                                        <td>{{ item.email }}</td>
                                        <td class="flex justify-center gap-2">
                                            <label
                                                for="detail"
                                                class="btn btn-xs btn-info"
                                                ><i class="fa fa-pen"></i
                                            ></label>
                                            <label
                                                class="btn btn-xs btn-error" :class="item.id == 1 ? 'hidden' : ''"
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
</template>
<script>
import InputPassword from "@/Components/inputPassword.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components: {
        'input-password': InputPassword
    },
    setup(props) {
        const tambah = useForm({
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            role: null,
            perusahaan_id: 1,
        })
        return {
            tambah
        }
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route('pengaturan.users.store'), {
                onSuccess: () => {
                    this.modal_close('tambah');
                    this.tambah.reset();
                    this.notifikasi('success', 'User berhasil ditambahkan');
                }
            });
        },
    },
    layout: LayoutMain,
    props: {
        user: Object,
        search: String,
        showItem: Number,
    },
    data() {
        return {
            cari: this.search,
            itemShow: parseInt(this.showItem),
            DataRole: [
                { nama: 'admin' },
                { nama: 'kasir' },
            ]
        }
    },
    watch: {
        cari() {
            this.$inertia.visit(
                route("pengaturan.users.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "user"],
                }
            );
        },
        itemShow() {
            this.$inertia.visit(
                route("pengaturan.users.index", {
                    cari: this.cari,
                    showItem: this.itemShow,
                }),
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ["search", "user"],
                }
            );
        },
    }
};
</script>
<style lang=""></style>
