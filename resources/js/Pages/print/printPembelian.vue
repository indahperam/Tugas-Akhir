<template lang="">
    <div class="w-[21cm] p-4 flex flex-col text-black bg-white print">
        <div class="flex justify-center text-2xl font-bold">
            List Data Pembelian
        </div>
        <div class="font-semibold">
            <ul class="flex gap-2">
                <li>Kode Pembelian</li>
                <li>:</li>
                <li>{{pembelian.kode}}</li>
            </ul>
            <ul class="flex gap-2">
                <li>Waktu Pembelian</li>
                <li>:</li>
                <li>{{pembelian.waktu}}</li>
            </ul>
            <ul class="flex gap-2">
                <li>supplier</li>
                <li>:</li>
                <li>{{pembelian.supplier.nama}}</li>
            </ul>
            <ul class="flex gap-2">
                <li>alamat</li>
                <li>:</li>
                <li>{{pembelian.supplier.alamat}}</li>
            </ul>
            <ul class="flex gap-2">
                <li>kontak</li>
                <li>:</li>
                <li>{{pembelian.supplier.kontak}}</li>
            </ul>
        </div>
        <table class="table table-compact mt-4 w-full">
            <thead>
                <tr class="capitalize">
                    <td>No.</td>
                    <td>Nama</td>
                    <td>harga beli</td>
                    <td>jumlah</td>
                    <td>subtotal</td>
                </tr>
            </thead>
            <tbody>
                <tr class="capitalize" v-for="(item,index) in pembelian.pembelian_detail">
                    <td>{{index +1}}</td>
                    <td>{{item.nama}}</td>
                    <td>{{rupiah(item.harga_beli)}}/{{item.produk.satuan.nama}}</td>
                    <td>{{item.jumlah}}</td>
                    <td>{{rupiah(item.subtotal)}}</td>
                </tr>
            </tbody>
            <thead>
                <tr class="capitalize">
                    <td colspan="3" rowspan="4"></td>
                    <td>total</td>
                    <td>{{rupiah(pembelian.total)}}</td>
                </tr>
                <tr class="capitalize">
                    <td>diskon</td>
                    <td>{{rupiah(pembelian.diskon_total)}}</td>
                </tr>
                <tr class="capitalize">
                    <td>ppn</td>
                    <td>{{rupiah(pembelian.ppn_total)}}</td>
                </tr>
                <tr class="capitalize">
                    <td>grand total</td>
                    <td>{{rupiah(pembelian.grand_total)}}</td>
                </tr>
            </thead>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        pembelian: Object,
    }
}
</script>
<style>
.print {
    page-break-after: always;
}
</style>