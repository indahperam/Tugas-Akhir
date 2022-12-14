<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ProdukController extends Controller
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
        $produk = Produk::with(['kategori', 'satuan'])
            ->where('kode', 'like', "%" . $cari . "%")
            ->orWhere('nama', 'like', "%" . $cari . "%")
            ->orWhereHas('kategori', function ($q) use ($cari) {
                $q->where('nama', 'like', "%" . $cari . "%");
            })
            ->orWhereHas('satuan', function ($q) use ($cari) {
                $q->where('nama', 'like', "%" . $cari . "%");
            })
            ->orWhere('harga_beli', 'like', "%" . $cari . "%")
            ->orWhere('harga_jual', 'like', "%" . $cari . "%")
            ->orWhere('stok', 'like', "%" . $cari . "%")
            ->orderBy('id', 'desc')
            ->paginate($page)
            ->withQueryString();
        $kategori = Kategori::all();
        $satuan = satuan::all();

        return inertia()->render('master/produk', [
            'produk' => $produk,
            'kategori' => $kategori,
            'satuan' => $satuan,
            'search' => $cari,
            'showItem' => $page,
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
            'nama' => 'required|unique:produks',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
        ]);
        $produk = Produk::create($request->all());
        $produk->kode = "P-" . sprintf("%05s", $produk->id);
        $produk->update();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required',
        ]);
        if ($request->nama != $produk->nama) {
            $request->validate([
                'nama' => 'unique:produks'
            ]);
        }
        $produk->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
    }
}
