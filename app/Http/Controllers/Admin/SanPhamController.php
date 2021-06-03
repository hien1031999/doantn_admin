<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\ChiTietSP;
use App\Models\LoaiSP;
use App\Models\NhaSanXuat;
use App\Http\Requests\SanPham\StoreRequest;
use App\Http\Requests\SanPham\UpdateRequest;

class SanPhamController extends Controller
{
    private $viewFolder = 'san-pham';
    private $page = 'Sản phẩm';

    public function index(Request $req) {
        $pageInfo = [
            'page'  => $this->page
        ];

        $keyword = (empty($req->keyword)) ? null : $req->keyword;

        $products = SanPham::sortable();

        if (!empty($keyword)) {
            $products->where('ma_sp', 'like', "%{$keyword}%");
        }

        $products = $products->orderBy('ma_sp')
                             ->paginate($this->limit);

        return view("{$this->viewFolder}.list", compact('pageInfo', 'products', 'keyword'));
    }

    public function show(Request $req) {
        // when click button detail -> show detail product
    }

    public function create() {
        $pageInfo = [
            'subtitle'  => $this->add,
            'page'      => $this->page,
            'route'     => $this->viewFolder
        ];

        $product_types = LoaiSP::all();
        $manufactures = NhaSanXuat::all();

        return view("{$this->viewFolder}.store-edit", compact('pageInfo', 'product_types', 'manufactures'));
    }

    public function store(StoreRequest $req) {
        $status = "error";
        $message = $this->msgStoreErr;

        // echo "<pre>";
        // $a = $req->toArray();
        // print_r($a); exit;

        // $images = [];
        // if($files = $req->file('upload_file')) {
        //     foreach ($files as $file) {
        //         $name = $file->getClientOriginalName();
        //         $images[] = $name;
        //     }
        // }
        // print_r($images); exit;

        $product = SanPham::create(['ma_sp' => $req->ma_sp]);

        $product_detail = ChiTietSP::create([
            'san_pham_id'   => $product->id,
            'ten_sp'        => $req->ten_sp,
            'loai_sp_id'    => $req->loai_sp_id,
            'nha_sx_id'     => $req->nha_sx_id,
            'gia'           => $req->gia,
            'so_luong'      => $req->so_luong,
            'giam_gia'      => $req->giam_gia,
            'mau_sac'       => $req->mau_sac,
            'mo_ta'         => $req->mo_ta,
            'chat_lieu'     => $req->chat_lieu,
            'so_ngan'       => $req->so_ngan,
            'khoi_luong'    => $req->khoi_luong,
            'kich_thuoc'    => $req->kich_thuoc,
            'tai_trong'     => $req->tai_trong,
            'ngan_lap'      => $req->ngan_lap,
            'tinh_trang'    => $req->tinh_trang
        ]);

        if (!empty($product_detail)) {
            $status = "success";
            $message = $this->msgStoreSuc;
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function edit($id) {
        $pageInfo = [
            'subtitle'  => $this->edit,
            'page'      => $this->page,
            'route'     => $this->viewFolder
        ];

        $product_types = LoaiSP::all();
        $manufactures = NhaSanXuat::all();

        $product = SanPham::find($id);

        if (!empty($product)) {
            $product_detail = ChiTietSP::where('san_pham_id', $product->id)
                                       ->first();
            return view("{$this->viewFolder}.store-edit", compact('pageInfo', 'product', 'product_detail', 'product_types', 'manufactures'));
        }

        $status = 'error';
        $message = $this->msgNotFound;

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function update(Request $req, $id) {
        $status = 'error';
        $message = $this->msgUpdateErr;

        $product = SanPham::find($id);

        if (!empty($product)) {
            $product_detail = ChiTietSP::where('san_pham_id', $product->id)
                                       ->first();
            $valid = $this->validate($req, (new UpdateRequest)->rules($product->id, $product_detail->id), (new UpdateRequest)->messages());

            $product->update(['ma_sp' => $valid['ma_sp']]);
            $product_detail->update([
                'ten_sp'        => $valid['ten_sp'],
                'loai_sp_id'    => $valid['loai_sp_id'],
                'nha_sx_id'     => $valid['nha_sx_id'],
                'gia'           => $valid['gia'],
                'so_luong'      => $valid['so_luong'],
                'giam_gia'      => $valid['giam_gia'],
                'mau_sac'       => $valid['mau_sac'],
                'mo_ta'         => $valid['mo_ta'],
                'chat_lieu'     => $valid['chat_lieu'],
                'so_ngan'       => $valid['so_ngan'],
                'khoi_luong'    => $valid['khoi_luong'],
                'kich_thuoc'    => $valid['kich_thuoc'],
                'tai_trong'     => $valid['tai_trong'],
                'ngan_lap'      => $valid['ngan_lap'],
                'tinh_trang'    => $valid['tinh_trang']
            ]);

            $status = 'success';
            $message = $this->msgUpdateSuc;
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function destroy(Request $req) {
        $id = $req->id;

        $product = SanPham::find($id);

        if (!empty($product)) {
            $product_detail = ChiTietSP::where('nha_sx_id', $product->id)
                                       ->first();
            $product_detail->delete();
            $product->delete();

            return response()->json([
                'title'     => 'Xóa nhà sản xuất',
                'status'    => 'success',
                'msg'       => $this->msgDeleteSuc
            ]);
        }

        return response()->json([
            'title'     => 'Xóa nhà sản xuất',
            'status'    => 'error',
            'msg'       => $this->msgDeleteErr
        ]);
    }
}
