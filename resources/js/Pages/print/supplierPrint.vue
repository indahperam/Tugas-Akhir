<template lang="">
    <div class="w-[21cm]">
        <div class="text-center font-bold text-xl uppercase my-4">Data supplier</div>
        <table
            class="table table-compact shadow-md w-full text-center"
        >
            <thead>
                <tr>
                    <td>no</td>
                    <td>kode</td>
                    <td>nama</td>
                    <td>kontak</td>
                    <td>alamat</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in supplier">
                    <td>{{index+1}}</td>
                    <td>{{item.kode}}</td>
                    <td>{{item.nama}}</td>
                    <td>{{item.kontak}}</td>
                    <td>{{item.alamat}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: {
        supplier : Array
    }
}
</script>
<style lang="">
    
</style>