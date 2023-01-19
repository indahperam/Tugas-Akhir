<template lang="">
    <div class="w-[21cm]">
        <div class="text-center text-xl capitalize">laporan penjualan</div>
        <div class="text-center text-md capitalize">{{data_penjualan.waktu[0]}} sampai {{data_penjualan.waktu[1]}}</div>
        <table class="table table-compact w-full table-zebra text-center">
            <thead>
                <tr>
                    <td>no</td>
                    <td>tanggal</td>
                    <td>kode</td>
                    <td>member</td>
                    <td>total</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item,index in data_penjualan.penjualan">
                    <td>{{index + 1}}</td>
                    <td>{{item.tanggal}}</td>
                    <td>{{item.kode }}</td> 
                    <td>{{item.member ? item.member.nama : 'non-member'}}</td>
                    <td>{{rupiah(item.grand_total)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        data_penjualan: Object
    },
    mounted() {
        this.$nextTick(
            () => {
                window.print()
            }
        )
    },
}
</script>
<style lang="">
    
</style>