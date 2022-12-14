<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">List Data Member</div>
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
                                        <th>kode</th>
                                        <th>nama</th>
                                        <th>kontak</th>
                                        <th>alamat</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <transition-group name="listv2">
                                        <tr
                                        v-for="(item, index) in member.data"
                                        :key="item.id"
                                    >
                                        <td>{{ item.kode }}</td>
                                        <td>{{ item.nama }}</td>
                                        <td>{{ item.kontak }}</td>
                                        <td>{{ item.alamat }}</td>
                                        <td>action</td>
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
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";

export default {
    layout: LayoutMain,
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
