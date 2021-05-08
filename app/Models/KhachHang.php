<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use SoftDeletes;

    protected $table = 'khach_hang';
    protected $fillable = [
        'bi_khoa'
    ];
    protected $hidden = ['mat_khau'];
}
