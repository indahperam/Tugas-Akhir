<template lang="">
    <div class="w-[21cm] p-4 flex flex-col text-black bg-white print">
        <div class="flex justify-center">
            List Data Pembelian
        </div>
        <div class="">
            <ul class="flex">
                <li>Kode</li>
                <li>:</li>
                <li>Kode</li>
            </ul>
            <ul class="flex">
                <li>supplier</li>
                <li>:</li>
                <li>Kode</li>
            </ul>
            <ul class="flex">
                <li>alamat</li>
                <li>:</li>
                <li>Kode</li>
            </ul>
            <ul class="flex">
                <li>kontak</li>
                <li>:</li>
                <li>Kode</li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style>
.print {
    page-break-after: always;
}
</style>