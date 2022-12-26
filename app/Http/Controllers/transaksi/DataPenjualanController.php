<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DataPenjualanController extends Controller
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
        $data = str_contains('non-member', strtolower($cari));
        $penjualan = Transaksi::with([
            'member',
            'pembayaran' => function ($q) {
                $q->selectRaw('*,date_format(created_at,"%d %M %Y") as waktu');
            },
            'transaksi_detail'
        ])
            ->selectRaw('*,date_format(created_at,"%d %M %Y %H:%i") as tanggal')
            ->whereBetween('created_at', [$dari, $sampai])
            ->where('active', false)
            ->where('lunas', 'lunas')
            ->where(function ($q) use ($cari, $data) {
                $q->where('kode', 'like', '%' . $cari . '%')
                    ->orWhere('grand_total', 'like', '%' . $cari . '%')
                    ->orWhere('member_id', $data ? 0 : "false")
                    ->orWhereHas('member', function ($member) use ($cari) {
                        $member->where('nama', 'like', '%' . $cari . '%');
                    });
            })
            ->withSum('pembayaran', 'nominal')
            ->latest()
            ->paginate($page)
            ->withQueryString();
        return inertia()->render('transaksi/data_penjualan', [
            'penjualan' => $penjualan,
            'jenis_pembayaran' => JenisPembayaran::all(),
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
    public function show(Transaksi $penjualan)
    {
        $penjualan->load(['member', 'transaksi_detail', 'pembayaran']);
        $penjualan->pembayaran_sum_nominal = $penjualan->pembayaran->sum('nominal');
        $penjualan->tanggal_print = date('d M Y');
        return inertia('print/print', ['transaksi' => $penjualan]);
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
