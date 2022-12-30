<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode', 'kode');
    }
}
