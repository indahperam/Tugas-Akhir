<template lang="">
    <div class="w-[21cm]">
        <div class="text-center text-xl capitalize">laporan pembelian</div>
        <div class="text-center text-md capitalize">{{data_pembelian.waktu[0]}} sampai {{data_pembelian.waktu[1]}}</div>
        <table class="table table-compact w-full table-zebra text-center">
            <thead>
                <tr>
                    <td>no</td>
                    <td>tanggal</td>
                    <td>kode</td>
                    <td>supplier</td>
                    <td>total</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item,index in data_pembelian.pembelian">
                    <td>{{index + 1}}</td>
                    <td>{{item.tanggal}}</td>
                    <td>{{item.kode }}</td> 
                    <td>{{item.supplier.nama}}</td>
                    <td>{{rupiah(item.grand_total)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        data_pembelian: Object
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