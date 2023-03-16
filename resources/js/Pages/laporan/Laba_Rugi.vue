<template lang="">
    <button class="btn btn-sm gap-2 mb-3" @click="print()"><i class="fa fa-print"></i> Print Laporan</button>
    <div class="text-center mb-4 text-2xl font-bold capitalize">
        {{waktu}}
    </div>
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
    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Harga Pokok Penjualan</div>
        <div class=""></div>
        <div class="border-b-2 border-black">{{rupiah(master.penjualan_pokok)}}</div>
    </div>
    <div class="grid grid-cols-3 text-lg font-bold">
        <div class="">Laba Kotor</div>
        <div class=""></div>
        <div class="">{{rupiah(master.laba_kotor)}}</div>
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
    setup() {
        const datetime = new Date()
        const hari = namaHari(datetime.getDay())
        const tanggal = datetime.getMonth()
        const bulan = namaBulan(datetime.getMonth())
        const tahun = datetime.getFullYear()
        const waktu = `${hari}, ${tanggal} ${bulan} ${tahun}`

        function namaBulan(params) {
            switch (params) {
                case 0:
                    return 'januari'
                    break;
            
                case 1:
                    return 'februari'
                    break;
            
                case 2:
                    return 'maret'
                    break;
            
                case 3:
                    return 'april'
                    break;
            
                case 4:
                    return 'mei'
                    break;
            
                case 5:
                    return 'juni'
                    break;
            
                case 6:
                    return 'juli'
                    break;
            
                case 7:
                    return 'agustus'
                    break;
            
                case 8:
                    return 'september'
                    break;
            
                case 9:
                    return 'oktober'
                    break;
            
                case 10:
                    return 'november'
                    break;
            
                case 11:
                    return 'desember'
                    break;
            
                default:
                    break;
            }
        }
        function namaHari(params){
            switch (params) {
                case 1:
                    return 'senin'
                    break;
            
                case 2:
                    return 'selasa'
                    break;
            
                case 3:
                    return 'rabu'
                    break;
            
                case 4:
                    return 'kamis'
                    break;
            
                case 5:
                    return 'jumat'
                    break;
            
                case 6:
                    return 'sabtu'
                    break;
            
                case 7:
                    return 'minggu'
                    break;
            
                default:
                    break;
            }
        }
        return {
            waktu
        }
    },
    methods : {
        async print(){
            let print = await window.open(route('labaRugi.print'))
            await print.addEventListener("DOMContentLoaded", async () => {
                print.window.onafterprint = (event) => {
                    print.close();
                };
                print.window.print()
            });
        }
    }
}
</script>
<style lang="">
    
</style>