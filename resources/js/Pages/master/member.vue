<template lang="">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="card-title">List Data Member</div>
            <div class="mt-4">
                <datatable>
                    <template v-slot:content>
                        <div class="overflow-x-auto">
                            <table class="table table-compact shadow-md w-full text-center">
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
                                    <tr>
                                        <td>kode</td>
                                        <td>nama</td>
                                        <td>kontak</td>
                                        <td>alamat</td>
                                        <td>action</td>
                                    </tr>
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
};
</script>
<style lang=""></style>
