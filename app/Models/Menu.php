<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'kategori_id',
        'nama_menu',
        'harga',
        'deskripsi',
        'foto',
        'status',
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}