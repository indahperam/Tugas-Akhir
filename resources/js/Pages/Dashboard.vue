<template lang="">
    <div class="grid grid-cols-4 gap-4">
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    Transaksi hari ini
                </div>
                <p class="font-semibold">123</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    total Transaksi
                </div>
                <p class="font-semibold">123</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    jumlah Transaksi
                </div>
                <p class="font-semibold">Rp 20.000.000.000</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">Total hutang</div>
                <p class="font-semibold">Rp 20.000.000.000</p>
            </div>
        </div>
    </div>
</template>
<script>
import LayoutMain from "@/Layouts/LayoutMain.vue";
export default {
    layout: LayoutMain,
    beforeMount() {},
};
</script>
<style lang=""></style>
