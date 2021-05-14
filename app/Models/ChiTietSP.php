<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ChiTietSP extends Model
{
    use SoftDeletes, Sortable;

    protected $table = 'chi_tiet_sp';
    protected $fillable = [
        'san_pham_id',
        'loai_sp_id',
        'nha_sx_id',
        'ten_sp',
        'gia',
        'mo_ta',
        'mau_sac',
        'so_luong',
        'giam_gia',
        'hinh_anh'
    ];
}
