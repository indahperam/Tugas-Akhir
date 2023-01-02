<script>
import LayoutAuth from "@/Layouts/LayoutAuth.vue";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    layout: LayoutAuth,
    props: {
        img: String,
        user_aktif: Object,
    },
    setup() {
        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });
        return {
            form,
        };
    },
    methods: {
        submit() {
            {
                this.form.post(route("login"), {
                    onFinish: () => {
                        this.form.reset("password");
                    },
                });
            }
        },
    },
};
</script>

<template>
    <div>
        <div
            class="grid lg:grid-cols-2 w-full h-full bg-base-200 p-4 rounded-[2rem] max-w-4xl justify-items-center overflow-hidden border-2 border-base-300 shadow-[rgba(0,_0,_0,_0.09)_30px_30px_40px_3px]">
            <div class="w-96 h-full hidden lg:flex justify-center items-center">
                <div class="w-96 h-96">
                    <img :src="img" alt="" class="w-full" />
                </div>
            </div>
            <div class="w-full h-full flex flex-col justify-center p-4 lg:p-8 lg:border-l-2 border-base-300">
                <div class="text-3xl font-bold">Login</div>
                <form @submit.prevent="submit" class="gap-2 flex flex-col w-full">
                    <div class="form form-control w-full">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="text" class="input input-bordered shadow-lg input-sm" required
                            placeholder="Masukkan Email" v-model="form.email" />
                        <transition name="opacity">
                            <label class="label" v-if="form.errors.email">
                                <span class="label-text text-error">{{
        form.errors.email
}}</span>
                            </label>
                        </transition>
                    </div>
                    <div class="form form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" class="input input-bordered shadow-lg input-sm" required
                            placeholder="Masukkan Password" v-model="form.password" />
                        <transition name="opacity">
                            <label class="label" v-if="form.errors.password">
                                <span class="label-text text-error">{{
        form.errors.password
}}</span>
                            </label>
                        </transition>
                    </div>
                    <div class="justify-between flex">
                        <!-- <Link :href="route('register')">
                            <label
                                class="label label-text underline hover:text-primary hover:scale-105 transition-all"
                                >Daftar Sekarang</label
                            >
                        </Link> -->
                    </div>
                    <button :class="{ 'loading btn-disabled': form.processing }" type="submit"
                        class="btn mt-3 w-full btn-success">
                        login
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
