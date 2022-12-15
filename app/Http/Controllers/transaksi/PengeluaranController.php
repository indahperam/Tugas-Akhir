<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
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
        $pengeluaran = Pengeluaran::selectRaw('*,date_format(tanggal_input,"%d %M %Y") as tanggal')
            ->whereBetween('tanggal_input', [$dari, $sampai])
            ->where(function ($q) use ($cari) {
                $q->where('kode', 'like', "%" . $cari . "%")
                    ->orWhere('jenis_transaksi', 'like', "%" . $cari . "%")
                    ->orWhere('nominal', 'like', "%" . $cari . "%")
                    ->orWhere('keterangan', 'like', "%" . $cari . "%");
            })
            ->orderBy('tanggal_input', 'desc')
            ->paginate($page)
            ->withQueryString();
        return inertia()->render('transaksi/pengeluaran', [
            'pengeluaran' => $pengeluaran,
            'jenis_pembayaran' => JenisPembayaran::all(),
            'search' => $cari,
            'showItem' => $page,
            'dari' => date('Y-m-d', strtotime($dari)),
            'sampai' => date('Y-m-d', strtotime($sampai)),
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
        $request->validate([
            'jenis_transaksi' => 'required',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required',
            'tanggal_input' => 'required',
        ]);
        $request['tanggal_input'] = date('Y-m-d H:i', strtotime($request->tanggal_input));
        $pengeluaran = Pengeluaran::create($request->all());
        $pengeluaran->kode = "PN-" . sprintf("%05s", $pengeluaran->id);
        $pengeluaran->update();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'jenis_transaksi' => 'required',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required',
            'tanggal_input' => 'required',
        ]);
        $pengeluaran->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
    }
}
