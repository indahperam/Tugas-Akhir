<template lang="">
    <div class="grid grid-cols-4 gap-4">
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    Transaksi hari ini
                </div>
                <p class="font-semibold">{{data_master.transaksi_hari_ini}}</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    total Transaksi
                </div>
                <p class="font-semibold">{{data_master.transaksi_total}}</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">
                    jumlah Transaksi
                </div>
                <p class="font-semibold">{{rupiah(data_master.jumlah_transaksi)}}</p>
            </div>
        </div>
        <div class="card shadow-lg w-full">
            <div class="card-body flex items-center w-full drop-shadow-lg">
                <div class="card-title capitalize font-bold">Total hutang</div>
                <p class="font-semibold">{{rupiah(data_master.hutang)}}</p>
            </div>
        </div>
        <div class="col-span-4 h-[16rem] overflow-hidden p-4">
            <chart-area :data_chart="data_master.statistik_transaksi" title="Statistik Penjualan" label="Produk Terjual"></chart-area>
        </div>
    </div>
</template>
<script>
import ChartArea from "@/Components/chart/chartArea.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
export default {
    layout: LayoutMain,
    components: {
        'chart-area': ChartArea,
    },
    props: {
        'data_master': Object,
    }
};
</script>
<style lang=""></style>
