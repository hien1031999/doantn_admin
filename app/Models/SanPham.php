<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class SanPham extends Model
{
    use SoftDeletes, Sortable;

    protected $table = 'san_pham';
    protected $appends = ['anh_sp'];
    protected $fillable = [
        'ma_sp',
        'hinh_anh'
    ];

    public function getAnhSpAttribute() {
        if (empty($this->hinh_anh)) {
            return null;
        }

        return request()->getSchemeAndHttpHost(). '/anh_sp/'. $this->hinh_anh;
    }

}
