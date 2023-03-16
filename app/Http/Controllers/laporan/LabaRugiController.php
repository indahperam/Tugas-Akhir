<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transkasi = Transaksi::with('transaksi_detail')->whereMonth('created_at', date('m'))->get(['id','total', 'diskon_total', 'ppn_total']);
        $penjualan_kotor = $transkasi->sum('total');
        $diskon_penjualan = $transkasi->sum('diskon_total');
        $penjualan_bersih = $penjualan_kotor - $diskon_penjualan;
        $penjualan_pokok_data = $transkasi->map(function($q) {
            $harga_pokok = 0;
            foreach ($q->transaksi_detail as $key => $value) {
                $produk = Produk::where('nama',$value->nama)->first()->harga_beli;
                $harga_pokok+= $produk;
            }
            return $harga_pokok;
        });

        $penjualan_pokok = $penjualan_pokok_data->sum();
        $laba_kotor = $penjualan_bersih- $penjualan_pokok;

        $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->get(['nominal']);
        $pembelian = Pembelian::whereMonth('created_at', date('m'))->get(['total']);

        $pengeluaran_operasional = $pengeluaran->sum('nominal');
        $total_pembelian = $pembelian->sum('total');
        $total_beban = $pengeluaran_operasional + $total_pembelian;

        $laba_sebelum_pajak = $laba_kotor - $total_beban;
        $pajak_penghasilan = $transkasi->sum('ppn_total');

        $laba_bersih = $laba_sebelum_pajak - $pajak_penghasilan;
        $master = compact('laba_kotor','penjualan_pokok','penjualan_kotor', 'diskon_penjualan', 'penjualan_bersih', 'pengeluaran_operasional', 'total_pembelian', 'total_beban', 'laba_sebelum_pajak', 'pajak_penghasilan', 'laba_bersih');
        return inertia()->render('laporan/Laba_Rugi', ['master' => $master]);
    }

    public function print()
    {
        $transkasi = Transaksi::with('transaksi_detail')->whereMonth('created_at', date('m'))->get(['id','total', 'diskon_total', 'ppn_total']);
        $penjualan_kotor = $transkasi->sum('total');
        $diskon_penjualan = $transkasi->sum('diskon_total');
        $penjualan_bersih = $penjualan_kotor - $diskon_penjualan;
        $penjualan_pokok_data = $transkasi->map(function($q) {
            $harga_pokok = 0;
            foreach ($q->transaksi_detail as $key => $value) {
                $produk = Produk::where('nama',$value->nama)->first()->harga_beli;
                $harga_pokok+= $produk;
            }
            return $harga_pokok;
        });

        $penjualan_pokok = $penjualan_pokok_data->sum();
        $laba_kotor = $penjualan_bersih- $penjualan_pokok;

        $pengeluaran = Pengeluaran::whereMonth('created_at', date('m'))->get(['nominal']);
        $pembelian = Pembelian::whereMonth('created_at', date('m'))->get(['total']);

        $pengeluaran_operasional = $pengeluaran->sum('nominal');
        $total_pembelian = $pembelian->sum('total');
        $total_beban = $pengeluaran_operasional + $total_pembelian;

        $laba_sebelum_pajak = $laba_kotor - $total_beban;
        $pajak_penghasilan = $transkasi->sum('ppn_total');

        $laba_bersih = $laba_sebelum_pajak - $pajak_penghasilan;
        $master = compact('laba_kotor','penjualan_pokok','penjualan_kotor', 'diskon_penjualan', 'penjualan_bersih', 'pengeluaran_operasional', 'total_pembelian', 'total_beban', 'laba_sebelum_pajak', 'pajak_penghasilan', 'laba_bersih');
        return inertia()->render('print/labaRugiPrint', ['master' => $master]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
