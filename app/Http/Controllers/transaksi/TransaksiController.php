<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function simpan_transaksi(Request $request)
    {
        if ($request->id == 0) {
            $final = [
                'member_id' => $request->member['id'],
                'total' => $request->total,
                'diskon' => $request->diskon['dummy'],
                'diskon_total' => $request->diskon['final'],
                'ppn' => $request->ppn,
                'ppn_total' => $request->ppn_total,
                'grand_total' => $request->grand_total,
                'active' => false,
                'lunas' => 'lunas'
            ];
            $transaksi = Transaksi::create($final);
            $transaksi->kode = "TR-" . sprintf("%05s", $transaksi->id);
            $transaksi->update();
            $detail = collect($request->keranjang)->map(function ($q) use ($transaksi) {
                Produk::where('kode', $q['kode'])->update([
                    'stok' => $q['stok']
                ]);
                unset($q['stok']);
                $q['transaksi_id'] = $transaksi->id;
                return $q;
            })->toArray();
            TransaksiDetail::insert($detail);
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tipe' => $request->bayar['jenis'],
                'no_transaksi' => $request->bayar['no_transaksi'],
                'nominal' => $request->bayar['final'],
            ]);
        } else {
            $transaksi = Transaksi::with(['transaksi_detail'])->find($request->id);
            $transaksi->total = $request->total;
            $transaksi->member_id = $request->member_id ?: 0;
            $transaksi->diskon = $request->diskon['dummy'];
            $transaksi->diskon_total = $request->diskon['final'];
            $transaksi->ppn = $request->ppn;
            $transaksi->ppn_total = $request->ppn_total;
            $transaksi->grand_total = $request->grand_total;
            $transaksi->lunas = 'lunas';
            $transaksi->active = false;
            $transaksi->transaksi_detail->map(function ($q) {
                $produk = Produk::where('kode', $q['kode'])->first();
                $produk->update([
                    'stok' => $q['jumlah'] + $produk->stok
                ]);
            });
            $transaksi->transaksi_detail()->delete();
            $transaksi->update();
            $detail = collect($request->keranjang)->map(function ($q) use ($transaksi) {
                Produk::where('kode', $q['kode'])->update([
                    'stok' => $q['stok']
                ]);
                unset($q['produk']);
                unset($q['stok']);
                $q['transaksi_id'] = $transaksi->id;
                return $q;
            })->toArray();
            TransaksiDetail::insert($detail);
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tipe' => $request->bayar['jenis'],
                'no_transaksi' => $request->bayar['no_transaksi'],
                'nominal' => $request->bayar['final'],
            ]);
        }
    }

    public function hutang_transaksi(Request $request)
    {
        if ($request->id == 0) {
            $final = [
                'member_id' => $request->member['id'],
                'total' => $request->total,
                'diskon' => $request->diskon['dummy'],
                'diskon_total' => $request->diskon['final'],
                'ppn' => $request->ppn,
                'ppn_total' => $request->ppn_total,
                'grand_total' => $request->grand_total,
                'active' => false,
                'lunas' => 'hutang'
            ];
            $transaksi = Transaksi::create($final);
            $transaksi->kode = "TR-" . sprintf("%05s", $transaksi->id);
            $transaksi->update();
            $detail = collect($request->keranjang)->map(function ($q) use ($transaksi) {
                Produk::where('kode', $q['kode'])->update([
                    'stok' => $q['stok']
                ]);
                unset($q['stok']);
                $q['transaksi_id'] = $transaksi->id;
                return $q;
            })->toArray();
            TransaksiDetail::insert($detail);
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tipe' => $request->bayar['jenis'],
                'no_transaksi' => $request->bayar['no_transaksi'],
                'nominal' => $request->bayar['final'],
            ]);
        } else {
            Transaksi::find($request->id)->update([
                'active' => false,
                'lunas' => 'hutang',
            ]);
        }
    }
    public function save_transaksi(Request $request)
    {
        $final = [
            'member_id' => $request->member['id'],
            'total' => $request->total,
            'diskon' => $request->diskon['dummy'],
            'diskon_total' => $request->diskon['final'],
            'ppn' => $request->ppn,
            'ppn_total' => $request->ppn_total,
            'grand_total' => $request->grand_total,
            'active' => true,
            'lunas' => 'save'
        ];
        $transaksi = Transaksi::create($final);
        $transaksi->kode = "TR-" . sprintf("%05s", $transaksi->id);
        $transaksi->update();
        $detail = collect($request->keranjang)->map(function ($q) use ($transaksi) {
            Produk::where('kode', $q['kode'])->update([
                'stok' => $q['stok']
            ]);
            unset($q['stok']);
            $q['transaksi_id'] = $transaksi->id;
            return $q;
        })->toArray();
        TransaksiDetail::insert($detail);
    }
    public function print_lunas()
    {
        $transaksi = Transaksi::with(['member', 'transaksi_detail'])
            ->latest()
            ->withSum('pembayaran', 'nominal')
            ->first();
        $transaksi->tanggal_print = date('d M Y');
        // $transaksi->bayar = $transaksi->pembayaran->sum('nominal');
        return inertia()->render('print/print', ['transaksi' => $transaksi]);
    }
    public function hapus_transaksi(Transaksi $transaksi)
    {
        $transaksi->transaksi_detail()->delete();
        $transaksi->delete();
    }
}
