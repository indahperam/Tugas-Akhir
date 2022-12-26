<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class DataPembelian extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari ?: null;
        $page = $request->showItem ?: 5;
        $dari = $request->dari ? date('Y-m-d H:i:s', strtotime($request->dari)) : date('Y-m-d H:i:s', strtotime(date('Y-m-d')));
        $sampai = $request->sampai ? date('Y-m-d H:i:s', strtotime('+23 hours', strtotime($request->sampai))) : date('Y-m-d H:i:s', strtotime('+23 hours', strtotime($dari)));
        $pembelian = Pembelian::with(['pembelian_detail', 'supplier'])
            ->selectRaw('*,date_format(created_at,"%d %M %Y %H:%i") as tanggal')
            ->whereBetween('created_at', [$dari, $sampai])
            ->where(function ($q) use ($cari) {
                $q->where('kode', 'like', '%' . $cari . '%')
                    ->orWhere('grand_total', 'like', '%' . $cari . '%')
                    ->orWhereHas('supplier', function ($supplier) use ($cari) {
                        $supplier->where('nama', 'like', '%' . $cari . '%');
                    });
            })
            ->paginate($page)
            ->withQueryString();
        return inertia()->render('transaksi/data_pembelian', [
            'pembelian' => $pembelian,
            'search' => $cari,
            'showItem' => $page,
            'dari' => date('Y-m-d', strtotime($dari)),
            'sampai' => date('Y-m-d', strtotime($sampai)),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        return inertia()->render('print/printPembelian');
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
