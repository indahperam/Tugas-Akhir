<?php

namespace App\Http\Controllers\pengaturan;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use File;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia()->render('pengaturan/perusahaan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia()->render('Auth/Perusahaan', [
            "img" => asset("asset/perusahaan.png"),
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
            'nama' => ['required'],
            'alamat' => ['required'],
        ]);
        $id = Perusahaan::create($request->all())->id;
        User::find(auth()->user()->id)->update([
            'perusahaan_id' => $id
        ]);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ]);
        $perusahaan->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perusahaan $perusahaan)
    {
        //
    }

    public function logo_update(Request $request)
    {
        $perusahaan = auth()->user()->perusahaan();
        $logo = $request->foto;
        $nama_logo = date('ymdHis') . '.' . $logo->extension();
        $logo->move(public_path('img'), $nama_logo);
        if ($perusahaan->logo != 'asset/logo.png') {
            if (file_exists(public_path($perusahaan->logo))) {
                File::delete(public_path($perusahaan->logo));
            };
        }
        $perusahaan->logo = 'img/' . $nama_logo;
        $perusahaan->update();
    }
}
