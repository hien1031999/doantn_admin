<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class SanPham extends Model
{
    use SoftDeletes, Sortable;

    protected $table = 'san_pham';
    protected $fillable = [
        'ma_sp',
        'hinh_anh'
    ];
}
