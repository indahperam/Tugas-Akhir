<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisPembayaran = JenisPembayaran::all();
        return inertia()->render('master/jenis_pembayaran', ['jenis_pembayaran' => $jenisPembayaran]);
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
            'jenis' => 'required|unique:jenis_pembayarans',
            'no_rek' => 'required|unique:jenis_pembayarans',
        ]);
        JenisPembayaran::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisPembayaran  $jenisPembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPembayaran $jenisPembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisPembayaran  $jenisPembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisPembayaran $jenisPembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisPembayaran  $jenisPembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JenisPembayaran $jenisPembayaran)
    {
        $request->validate([
            'jenis' => 'required',
            'no_rek' => 'required',
        ]);
        if ($request->jenis != $jenisPembayaran->jenis) {
            $request->validate([
                'jenis' => 'unique:jenis_pembayarans',
            ]);
        }
        if ($request->no_rek != $jenisPembayaran->no_rek) {
            $request->validate([
                'no_rek' => 'unique:jenis_pembayarans',
            ]);
        }
        $jenisPembayaran->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisPembayaran  $jenisPembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisPembayaran $jenisPembayaran)
    {
        $jenisPembayaran->delete();
    }
}
