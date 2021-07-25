<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class NhaSanXuat extends Model
{
    use SoftDeletes, Sortable;

    protected $table = 'nha_san_xuat';
    protected $fillable = [
        'ten',
        'hinh_anh'
    ];
    protected $appends = ['anh'];

    public function getAnhAttribute() {
        if (empty($this->hinh_anh)) {
            return null;
        }

        return request()->getSchemeAndHttpHost(). '/anh_nsx/'. $this->hinh_anh;
    }
}
