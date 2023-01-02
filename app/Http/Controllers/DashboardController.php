<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaksi = Transaksi::selectRaw('*,date_format(created_at, "%Y-%m-%d") as waktu')->orderBy('waktu', 'asc')->get();
        $transaksi_hari_ini = Transaksi::whereDate('created_at', date('Y-m-d'))->count();
        $transaksi_total = $transaksi->count();
        $jumlah_transaksi = $transaksi->where('lunas', 'lunas')->sum('grand_total');
        $hutang = $transaksi->where('lunas', 'belum lunas')->sum('grand_total');

        $statistik_transaksi =
            $transaksi->groupBy('waktu')->map(function ($q, $key) {
                return [$key, $q->count()];
            })->values();

        $master = [
            'transaksi_hari_ini' => $transaksi_hari_ini,
            'transaksi_total' => $transaksi_total,
            'jumlah_transaksi' => $jumlah_transaksi,
            'hutang' => $hutang,
            'statistik_transaksi' => $statistik_transaksi,
        ];
        return Inertia::render('Dashboard', [
            'data_master' => $master,
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
