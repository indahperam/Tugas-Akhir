<template lang="">
    <div class="w-[21cm]">
        <div class="text-center font-bold text-xl uppercase my-4">Data Closing {{closing.waktu}}</div>
        <table class="table table-compact table-zebra">
            <tbody>
                <tr>
                    <td>Tanggal Transaksi</td>
                    <td>: {{closing.waktu}}</td>
                </tr>
                <tr>
                    <td>id closing</td>
                    <td>: {{closing.kode}}</td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>: {{closing.user.name}}</td>
                </tr>
                <tr>
                    <td>Nota Awal</td>
                    <td>: {{closing.nota_awal}}</td>
                </tr>
                <tr>
                    <td>Nota Dihapus</td>
                    <td>: {{closing.total_nota_hapus}}</td>
                </tr>
                <tr>
                    <td>Modal Awal</td>
                    <td>: {{rupiah(closing.modal_awal)}}</td>
                </tr>
                <tr>
                    <td>Tunai</td>
                    <td>: {{rupiah(closing.cash)}}</td>
                </tr>
                <tr>
                    <td>Gross Sales</td>
                    <td>: {{rupiah(closing.gross_sales)}}</td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td>: {{rupiah(closing.diskon)}}</td>
                </tr>
                <tr>
                    <td>PPN</td>
                    <td>: {{rupiah(closing.ppn)}}</td>
                </tr>
                <tr>
                    <td>Net. Sales</td>
                    <td>: {{rupiah(closing.net_sales)}}</td>
                </tr>
                <tr>
                    <td>Avg. Sales</td>
                    <td>: {{rupiah(closing.rata_rata)}}</td>
                </tr>
                <tr>
                    <td>Pengeluaran</td>
                    <td>: {{rupiah(closing.pengeluaran)}}</td>
                </tr>
                <tr>
                    <td>Total Uang Tunai</td>
                    <td>: {{rupiah(closing.total_uang_tunai)}}</td>
                </tr>
                <tr>
                    <td>Selisih</td>
                    <td>: {{rupiah(closing.selisih)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props : {
        closing : Object
    }
}
</script>
<style lang="">
    
</style>