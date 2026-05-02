<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'invoice',
        'total',
        'bayar',
        'kembalian',
        'diskon',
        'pajak',
        'metode'
    ];

    protected $casts = [
        'total' => 'integer',
        'bayar' => 'integer',
        'kembalian' => 'integer',
        'diskon' => 'integer',
        'pajak' => 'integer',
    ];

    // =========================
    // RELASI
    // =========================

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =========================
    // ACCESSOR FORMAT
    // =========================

    public function getTotalRupiahAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getBayarRupiahAttribute()
    {
        return 'Rp ' . number_format($this->bayar, 0, ',', '.');
    }

    public function getKembalianRupiahAttribute()
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }

    public function getDiskonRupiahAttribute()
    {
        return 'Rp ' . number_format($this->diskon, 0, ',', '.');
    }

    public function getPajakRupiahAttribute()
    {
        return 'Rp ' . number_format($this->pajak, 0, ',', '.');
    }

    public function getTanggalFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }
}