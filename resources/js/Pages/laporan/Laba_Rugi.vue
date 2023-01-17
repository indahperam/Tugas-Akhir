<template lang="">
    <div class="grid text-2xl font-bold">
        Pendapatan Penjualan
    </div>
    <div class="grid grid-cols-3">
        <div class="">Penjualan Kotor</div>
        <div class="">{{rupiah(master.penjualan_kotor)}}</div>
    </div>
    <div class="grid grid-cols-3">
        <div class="">Diskon Penjualan</div>
        <div class="border-b-2 border-black">{{rupiah(master.diskon_penjualan)}}</div>
    </div>
    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Pendapatan Penjualan Bersih</div>
        <div class=""></div>
        <div class="">{{rupiah(master.penjualan_bersih)}}</div>
    </div>

    <div class="grid text-xl font-bold mt-4">
        Beban
    </div>

    <div class="grid grid-cols-3 ">
        <div class="">Pengeluaran Operasional</div>
        <div class="">{{rupiah(master.pengeluaran_operasional)}}</div>
    </div>
    <div class="grid grid-cols-3">
        <div class="">Pembelian</div>
        <div class="border-b-2 border-black">{{rupiah(master.total_pembelian)}}</div>
    </div>
    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Total beban</div>
        <div class=""></div>
        <div class="border-b-2 border-black">{{rupiah(master.total_beban)}}</div>
    </div>


    <div class="grid grid-cols-3 text-lg font-bold mt-4">
        <div class="">Laba Sebelum Pajak Penghasilan</div>
        <div class=""></div>
        <div class="">{{rupiah(master.laba_sebelum_pajak)}}</div>
    </div>

    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Pajak Penghasilan</div>
        <div class=""></div>
        <div class="border-b-2 border-black">{{rupiah(master.pajak_penghasilan)}}</div>
    </div>
    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Laba Bersih</div>
        <div class=""></div>
        <div class="">{{rupiah(master.laba_bersih)}}</div>
    </div>
</template>
<script>
import LayoutMain from '@/Layouts/LayoutMain.vue';
export default {
    layout: LayoutMain,
    props: {
        master: Object,
    },
}
</script>
<style lang="">
    
</style>