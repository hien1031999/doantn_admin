<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use SoftDeletes;

    protected $table = 'gio_hang';
    protected $fillable = [
        'khach_hang_id',
        'ma_gio_hang',
        'tong_tien'
    ];

    public function khach_hang()
    {
        return $this->belongsTo(KhachHang::class, 'khach_hang_id', 'id')
                    ->where('khach_hang.bi_khoa', 0)
                    ->select('id', 'ten', 'email', 'sdt', 'dia_chi');
    }
}
