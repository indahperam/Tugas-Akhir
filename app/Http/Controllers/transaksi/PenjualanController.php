<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Closing;
use App\Models\JenisPembayaran;
use App\Models\Member;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::with(['satuan' => function ($q) {
            $q->select('id', 'nama');
        }])->get(['kode', 'nama', 'harga_jual', 'satuan_id', 'stok']);

        $member = Member::all();
        $jenis_pembayaran = JenisPembayaran::all();
        $transaksi_aktif = Transaksi::with(['transaksi_detail.produk.satuan', 'member'])->where('active', true)->latest()->get()->map(function ($q) {
            $q['waktu'] = $q->created_at->format('d M Y H:i');
            $q['transaksi_detail']->map(function ($detail) {
                $detail['stok'] = $detail->produk['stok'];
            });
            return $q;
        });

        $closing = Closing::with(['user'])->whereDate('created_at', date('Y-m-d'))->where('status', 'open')->get();
        $closing_data = $this->updateClosing($closing);

        return inertia()->render('transaksi/penjualan', [
            'produk' => $produk,
            'member' => $member,
            'jenis_pembayaran' => $jenis_pembayaran,
            'transaksi_aktif' => $transaksi_aktif,
            'closing' => $closing->count(),
            'closing_data' => $closing_data,
        ]);
    }

    public function updateClosing($data)
    {
        if ($data->count() > 0) {
            $data = $data->first();
            $data['waktu'] =  $data->created_at->format('d M Y H:i');

            $penjualan = Transaksi::whereDate('created_at', date("Y-m-d"))->where('lunas', 'lunas')->get();
            $pembayaran = Pembayaran::with(['transaksi'])->whereDate('created_at', date("Y-m-d"))->get();
            $pengeluaran = Pengeluaran::whereDate('tanggal_input', date("Y-m-d"))->where('jenis_transaksi', 'TUNAI')->get();

            $data->nota_awal = $penjualan->first() ? $penjualan->first()->kode : '';
            $data->nota_akhir = $penjualan->last() ? $penjualan->last()->kode : '';
            $data->total_nota = $penjualan->count();
            $data->cash = $pembayaran->where('tipe', 'TUNAI')->sum('nominal');
            $data->transfer = $pembayaran->where('tipe', '!=', 'TUNAI')->sum('nominal');
            $data->gross_sales = $pembayaran->sum('nominal');
            $data->diskon = $penjualan->sum('diskon_total');
            $data->ppn = $penjualan->sum('ppn_total');
            $data->net_sales = $data->gross_sales - $data->ppn;
            $data->rata_rata = $data->total_nota != 0 ? ($data->net_sales / $data->total_nota) : 0;
            $data->pengeluaran = $pengeluaran->sum('nominal');
            $data->selisih = ($data->total_uang_tunai - $data->modal_awal) - $data->pengeluaran;
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
    public function penjualan_cetak(Request $request)
    {
        $data_penjualan = $request->data;
        return inertia()->render('print/penjualan', compact('data_penjualan'));
    }
}
