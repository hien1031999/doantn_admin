<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\ChiTietSP;
use App\Models\LoaiSP;
use App\Models\NhaSanXuat;

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

    public function store(Request $req) {
        $status = "error";
        $message = $this->msgStoreErr;

        echo "<pre>";
        $a = $req->toArray();
        print_r($a); exit;

        $valid = $this->validate($req, [
            'ten'   => 'required|unique:nha_san_xuat,ten|regex:/^[\w_ÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s]{1,50}$/',
        ], [
            'ten.required'  => 'Vui lòng nhập tên',
            'ten.unique'    => 'Tên đã tồn tại',
            'ten.regex'     => 'Tên không đúng định dạng'
        ]);

        $product_types = LoaiSP::all();
        $manufactures = NhaSanXuat::all();

        $product = SanPham::create($valid);

        if (!empty($product)) {
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

        $product = SanPham::find($id);

        if (!empty($product)) {
            return view("{$this->viewFolder}.store-edit", compact('pageInfo', 'product', 'product_types', 'manufactures'));
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
            $valid = $this->validate($req, [
                'ten'   => "required|unique:nha_san_xuat,ten,{$product->id}|regex:/^[\w_ÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s]{1,50}$/",
            ], [
                'ten.required'  => 'Vui lòng nhập tên',
                'ten.unique'    => 'Tên đã tồn tại',
                'ten.regex'     => 'Tên không đúng định dạng'
            ]);

            $product->update($valid);

            $status = 'success';
            $message = $this->msgUpdateSuc;
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function destroy(Request $req) {
        $id = $req->id;

        $product = SanPham::find($id);

        if (!empty($product)) {
            $detail_product = ChiTietSP::where('nha_sx_id', $product->id)
                                       ->first();
            if (empty($detail_product)) {
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
                'msg'       => $this->msgDeleteCant
            ]);
        }

        return response()->json([
            'title'     => 'Xóa nhà sản xuất',
            'status'    => 'error',
            'msg'       => $this->msgDeleteErr
        ]);
    }
}
