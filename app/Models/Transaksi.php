<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }


    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function transaksi_detail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
