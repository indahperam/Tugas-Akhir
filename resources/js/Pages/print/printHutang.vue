<template lang="">
    <div class="w-[21cm] p-4 flex flex-col text-black bg-white print">
        <div class="flex items-center">
            <div class="w-max mx-2 mb-2">
                <img
                    :src="user_aktif.perusahaan.logo"
                    class="h-[5rem] w-[5rem]"
                />
            </div>
            <div class="flex flex-col">
                <div class="uppercase text-3xl font-extrabold">
                    {{ user_aktif.perusahaan.nama }}
                </div>
                <div class="capitalize text-xs">
                    {{ user_aktif.perusahaan.alamat }}
                </div>
                <div class="text-xs">{{ user_aktif.perusahaan.kontak }}</div>
            </div>
        </div>
        <div class="border border-black mt-1"></div>
        <div class="flex flex-col mb-2">
            <div class="flex justify-between py-4">
                <table
                    class="w-max text-left text-sm font-normal capitalize h-max"
                    v-if="transaksi.member"
                >
                    <tbody>
                        <tr>
                            <td class="w-[5rem]">Nama</td>
                            <td>: {{ transaksi.member.nama }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ transaksi.member.alamat }}</td>
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>: {{ transaksi.member.kontak }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="w-max text-left text-sm font-normal capitalize">
                    <tbody>
                        <tr>
                            <td class="w-[7rem]">Tgl. Cetak</td>
                            <td>: {{ transaksi.tanggal_print }}</td>
                        </tr>
                        <tr>
                            <td>No. Transaksi</td>
                            <td>: {{ transaksi.kode }}</td>
                        </tr>
                        <tr v-if="transaksi.pembayaran.length">
                            <td>Pembayaran ke</td>
                            <td>: {{ transaksi.pembayaran.length }}</td>
                        </tr>
                        <tr v-if="transaksi.pembayaran.length">
                            <td>Nominal</td>
                            <td>
                                :
                                {{
                                    rupiah(
                                        transaksi.pembayaran.slice(-1)[0]
                                            .nominal
                                    )
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                :
                                {{ transaksi.lunas }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="">
                <table class="w-full table-compact table">
                    <thead>
                        <tr class="border-y border-black uppercase text-center">
                            <td class="text-left">No.</td>
                            <td class="text-left">nama</td>
                            <td>harga</td>
                            <td>jumlah</td>
                            <td class="text-right">subtotal</td>
                        </tr>
                    </thead>
                    <tbody class="capitalize">
                        <tr v-for="(item, index) in transaksi.transaksi_detail">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.nama }}</td>
                            <td class="text-center">
                                {{ rupiah(item.harga_jual) }} / pak
                            </td>
                            <td class="text-center">{{ item.jumlah }} pak</td>
                            <td class="text-right">
                                {{ rupiah(item.subtotal) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="border-t border-black flex justify-end gap-5">
                    <ul class="flex justify-center w-full items-center">
                        <li
                            colspan="5"
                            class="uppercase font-bold text-5xl"
                            :class="
                                transaksi.lunas != 'lunas'
                                    ? 'text-red-600'
                                    : 'text-green-600'
                            "
                        >
                            {{ transaksi.lunas }}
                        </li>
                    </ul>
                    <ul class="capitalize min-w-[6rem]">
                        <li>total</li>
                        <li>diskon</li>
                        <li>ppn {{ transaksi.ppn }}%</li>
                        <li class="font-bold">grand total</li>
                        <li>total bayar</li>
                        <li v-if="transaksi.lunas != 'lunas'">Sisa</li>
                        <li v-if="transaksi.lunas == 'lunas'">Kembalian</li>
                    </ul>
                    <ul>
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>
                        <li v-if="transaksi.lunas != 'lunas'">:</li>
                        <li v-if="transaksi.lunas == 'lunas'">:</li>
                    </ul>
                    <ul class="text-right">
                        <li>{{ rupiah(transaksi.total) }}</li>
                        <li>{{ rupiah(transaksi.diskon_total) }}</li>
                        <li>{{ rupiah(transaksi.ppn_total) }}</li>
                        <li class="font-bold">
                            {{ rupiah(transaksi.grand_total) }}
                        </li>
                        <li>{{ rupiah(transaksi.bayar) }}</li>
                        <li class="w-[8rem]" v-if="transaksi.lunas != 'lunas'">
                            {{
                                rupiah(transaksi.bayar - transaksi.grand_total)
                            }}
                        </li>
                        <li class="w-[8rem]" v-if="transaksi.lunas == 'lunas'">
                            {{
                                rupiah(transaksi.bayar - transaksi.grand_total)
                            }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border border-black mt-1"></div>
        <div
            class="flex justify-center text-xs pt-3"
            v-html="user_aktif.perusahaan.tambahan"
        ></div>
    </div>
</template>
<script>
export default {
    props: {
        user_aktif: Object,
        transaksi: Object,
    },
    mounted: function () {
        this.$nextTick(function () {
            setTimeout(() => {
                window.print();
            }, 1000);
            window.onafterprint = function () {
                window.close();
            };
        });
    },
};
</script>
<style>
.print {
    page-break-after: always;
}
</style>
