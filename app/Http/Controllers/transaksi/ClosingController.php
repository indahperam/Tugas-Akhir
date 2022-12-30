<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Closing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClosingController extends Controller
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

        $closing = Closing::with(['user'])
            ->selectRaw('*,date_format(created_at,"%d %M %Y") as tanggal,date_format(created_at,"%H:%i") as waktu_mulai,date_format(updated_at,"%H:%i") as waktu_selesai')
            ->whereBetween('created_at', [$dari, $sampai])
            ->where('status', 'close')
            ->paginate($page)
            ->withQueryString();
        return inertia()->render('laporan/closing', [
            'closing' => $closing,
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
        $request->validate([
            'modal_awal' => 'required|integer|min:1'
        ]);
        $request['user_id'] = auth()->user()->id;
        $opening = Closing::create($request->all());
        $opening->update([
            'kode' => "CL-" . sprintf("%05s", $opening->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Closing $id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Closing $closing)
    {
        $user = auth()->user()->password;
        $check = Hash::check($request->password, $user);
        if (!$check) {
            return back()->withErrors(['password' => 'password tidak sesuai']);
        }
        $closing->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Closing $closing)
    {
        $closing->delete();
    }
}
