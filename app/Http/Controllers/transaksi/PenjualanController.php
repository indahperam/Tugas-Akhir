<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Member;
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
        return inertia()->render('transaksi/penjualan', [
            'produk' => $produk,
            'member' => $member,
            'jenis_pembayaran' => $jenis_pembayaran,
            'transaksi_aktif' => $transaksi_aktif,
        ]);
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
}
