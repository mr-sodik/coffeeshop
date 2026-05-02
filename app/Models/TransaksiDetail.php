<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';

    protected $fillable = [
        'transaksi_id',
        'menu_id',
        'qty',
        'harga',
        'subtotal'
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'integer',
        'subtotal' => 'integer',
    ];

    // =========================
    // RELASI
    // =========================

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // =========================
    // ACCESSOR FORMAT
    // =========================

    public function getHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getSubtotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // =========================
    // AUTO HITUNG SUBTOTAL
    // =========================

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->subtotal = $model->qty * $model->harga;
        });
    }
}