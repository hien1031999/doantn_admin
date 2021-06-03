<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ChiTietSP extends Model
{
    use SoftDeletes;

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
        'hinh_anh',
        'chat_lieu',
        'so_ngan',
        'khoi_luong',
        'kich_thuoc',
        'tai_trong',
        'ngan_lap',
        'tinh_trang'
    ];

    public function loai_sp()
    {
        return $this->belongsTo(LoaiSP::class, 'loai_sp_id', 'id')
                    ->whereNotNull('loai_sp.id')
                    ->select('id', 'ten');
    }

    public function nha_san_xuat()
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_sx_id', 'id')
                    ->whereNotNull('nha_san_xuat.id')
                    ->select('id', 'ten');
    }

    public function getAnhChiTietSpAttribute() {
        if (empty($this->hinh_anh)) {
            return null;
        }

        return request()->getSchemeAndHttpHost(). '/anh_chi_tiet_sp/'. $this->hinh_anh;
    }

}
