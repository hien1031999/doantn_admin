<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    use SoftDeletes;

    protected $table = 'chi_tiet_gio_hang';
    protected $fillable = [
        'gio_hang_id',
        'san_pham_id',
        'gia_tien',
        'so_luong',
        'thanh_tien'
    ];

    public function gio_hang()
    {
        return $this->belongsTo(GioHang::class, 'gio_hang_id', 'id');
    }

    public function san_pham()
    {
        return $this->hasOne(SanPham::class, 'id', 'san_pham_id');
    }
}
