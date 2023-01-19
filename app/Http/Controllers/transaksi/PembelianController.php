<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        $produk = Produk::with(['satuan'])->get();
        return inertia()->render('transaksi/pembelian', [
            'supplier' => $supplier,
            'produk' => $produk,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $final = [
            'supplier_id' => $request->supplier['id'],
            'total' => $request->total,
            'diskon' => $request->diskon['dummy'],
            'diskon_total' => $request->diskon['final'],
            'ppn' => $request->ppn,
            'ppn_total' => $request->ppn_total,
            'grand_total' => $request->grand_total,
            'active' => false,
            'status' => 'lunas'
        ];
        $pembelian = Pembelian::create($final);
        $pembelian->kode = "PB-" . sprintf("%05s", $pembelian->id);
        $pembelian->update();
        $detail = collect($request->keranjang)->map(function ($q) use ($pembelian) {
            $keranjang = Produk::where('kode', $q['kode'])->first();
            $keranjang->update([
                'stok' => $q['jumlah'] + $keranjang->stok
            ]);
            unset($q['stok']);
            $q['pembelian_id'] = $pembelian->id;
            return $q;
        })->toArray();
        PembelianDetail::insert($detail);
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
    public function pembelian_cetak(Request $request)
    {
        $data_pembelian = $request->data;
        return inertia()->render('print/pembelian', compact('data_pembelian'));
    }
}
