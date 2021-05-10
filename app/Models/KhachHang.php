<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KhachHang extends Model
{
    use SoftDeletes, Sortable;

    protected $table = 'khach_hang';
    protected $fillable = [
        'mat_khau',
        'bi_khoa'
    ];

    protected $hidden = ['mat_khau'];

    public function biKhoaSortable($query, $direction) {
        return $query->orderByRaw("if (bi_khoa = 1, 'Bị khóa', 'Không khóa') {$direction}");
    }
}
