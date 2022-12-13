<template lang="">
    <div class="grid lg:grid-cols-3 gap-4">
        <div class="card shadow-lg">
            <div
                class="card-body h-full flex items-center justify-between flex-col"
            >
                <div class="card-title h-max uppercase">Logo</div>
                <div class="h-full w-full flex justify-center">
                    <img
                        :src="user_aktif.perusahaan.logo"
                        alt=""
                        class="max-h-[10rem]"
                    />
                </div>
                <div class="h-max w-full">
                    <div class="form-control">
                        <label class="label label-text">Pilih Gambar</label>
                        <input
                            type="file"
                            class="file-input file-input-bordered file-input-sm w-full"
                            @input="logo.foto = $event.target.files[0]"
                        />
                        <progress
                            v-if="logo.progress"
                            class="progress progress-primary w-full mt-3"
                            :value="logo.progress.percentage"
                            max="100"
                        ></progress>
                        <label class="label label-text-alt" v-if="logo.progress"
                            >{{ logo.progress.percentage }}%</label
                        >
                    </div>
                </div>
                <div class="flex justify-end w-full">
                    <button
                        @click="submit_logo"
                        :class="{
                            'loading btn-disabled': logo.processing,
                            'btn-disabled': logo.foto == null,
                        }"
                        class="btn btn-info btn-sm"
                    >
                        simpan
                    </button>
                </div>
            </div>
        </div>
        <div class="grid rounded-xl shadow-lg gap-2 p-4 lg:col-span-2">
            <form class="gap-2 grid" @submit.prevent="submit">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Perusahaan</span>
                    </label>
                    <input
                        type="text"
                        class="input input-sm input-bordered"
                        placeholder="Nama Perusahaan"
                        v-model="form.nama"
                    />
                    <label class="label" v-if="form.errors.nama">
                        <span class="label-text-alt text-error">{{
                            form.errors.nama
                        }}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Alamat Perusahaan</span>
                    </label>
                    <input
                        type="text"
                        class="input input-sm input-bordered"
                        placeholder="Alamat Perusahaan"
                        v-model="form.alamat"
                    />
                    <label class="label" v-if="form.errors.alamat">
                        <span class="label-text-alt text-error">{{
                            form.errors.alamat
                        }}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">PPN</span>
                    </label>
                    <input
                        type="number"
                        min="0"
                        max="100"
                        class="input input-sm input-bordered"
                        placeholder="PPN"
                        v-model="form.ppn"
                    />
                    <label class="label" v-if="form.errors.ppn">
                        <span class="label-text-alt text-error">{{
                            form.errors.ppn
                        }}</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Keterangan Tambahan</span>
                    </label>
                    <input
                        type="text"
                        class="input input-sm input-bordered"
                        placeholder="Alamat Perusahaan"
                        v-model="form.tambahan"
                    />
                    <label class="label" v-if="form.errors.tambahan">
                        <span class="label-text-alt text-error">{{
                            form.errors.tambahan
                        }}</span>
                    </label>
                </div>
                <div class="flex justify-end mt-4">
                    <button
                        :class="{ 'loading btn-disabled': form.processing }"
                        class="btn btn-info w-max btn-sm"
                    >
                        simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        user_aktif: Object,
    },
    layout: LayoutMain,
    setup(props) {
        const logo = useForm({
            foto: null,
        });
        const form = useForm({
            nama: props.user_aktif.perusahaan.nama,
            alamat: props.user_aktif.perusahaan.alamat,
            ppn: props.user_aktif.perusahaan.ppn,
            kontak: props.user_aktif.perusahaan.kontak,
            tambahan: props.user_aktif.perusahaan.tambahan,
        });
        return {
            form,
            logo,
        };
    },
    methods: {
        submit_logo() {
            this.logo.post(route("pengaturan.perusahaan.logo_update"), {
                onSuccess: () => {
                    this.logo.reset();
                    this.notifikasi("success", "logo berhasil diubah");
                },
            });
        },
        submit() {
            this.form.patch(
                route("pengaturan.perusahaan.update", {
                    perusahaan: this.user_aktif.id,
                }),
                {
                    onSuccess: () => {
                        this.notifikasi("success", "data berhasil disimpan");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
