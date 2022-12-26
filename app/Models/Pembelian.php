<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
