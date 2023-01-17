<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class HutangController extends Controller
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
        $hutang = Transaksi::with([
            'pembayaran' => function ($q) {
                $q->selectRaw('*,date_format(created_at,"%d %M %Y %H:%i") as waktu');
            },
            'member',
            'transaksi_detail'
        ])
            ->selectRaw('*,date_format(created_at,"%d %M %Y") as tanggal')
            ->where('lunas', 'belum lunas')
            ->whereBetween('created_at', [$dari, $sampai])
            ->where(function ($q) use ($cari) {
                $q->where('kode', 'like', '%' . $cari . '%')
                    ->orWhere('grand_total', 'like', '%' . $cari . '%')
                    ->orWhereHas('member', function ($member) use ($cari) {
                        $member->where('nama', 'like', '%' . $cari . '%');
                    });
            })
            ->withSum('pembayaran', 'nominal')
            ->latest()
            ->paginate($page)
            ->withQueryString();
        return inertia()->render('transaksi/piutang', [
            'hutang' => $hutang,
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
    public function show(Transaksi $hutang)
    {
        $hutang->load(['member', 'pembayaran', 'transaksi_detail']);
        $hutang->bayar = $hutang->pembayaran->sum('nominal');
        $hutang->tanggal_print = date('d M Y');
        return inertia()->render('print/printHutang', ['transaksi' => $hutang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $hutang)
    {
        $final = [
            'tipe' => $request->bayar_hutang['jenis'],
            'no_transaksi' => $request->bayar_hutang['no_transaksi'],
            'nominal' => $request->bayar_hutang['final'],
        ];
        $hutang->pembayaran()->create($final);
        if ($hutang->pembayaran()->sum('nominal') >= $request->grand_total) {
            $hutang->lunas = 'lunas';
            $hutang->update();
        }
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
