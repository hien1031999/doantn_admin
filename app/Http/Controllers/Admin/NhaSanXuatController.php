<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietSP;
use App\Models\NhaSanXuat;
use App\Http\Requests\NhaSanXuat\StoreRequest;
use App\Http\Requests\NhaSanXuat\UpdateRequest;
use App\Helpers\UploadFile as Upload;

class NhaSanXuatController extends Controller
{
    private $viewFolder = 'nha-san-xuat';
    private $page = 'Nhà sản xuất';

    public function index(Request $req) {
        $pageInfo = [
            'page'  => $this->page
        ];

        $keyword = (empty($req->keyword)) ? null : $req->keyword;

        $manufactures = NhaSanXuat::sortable();

        if (!empty($keyword)) {
            $manufactures->where('ten', 'like', "%{$keyword}%");
        }

        $manufactures = $manufactures->orderBy('ten')
                                     ->paginate($this->limit);

        return view("admin.{$this->viewFolder}.list", compact('pageInfo', 'manufactures', 'keyword'));
    }

    public function create() {
        $pageInfo = [
            'subtitle'  => $this->add,
            'page'      => $this->page,
            'route'     => $this->viewFolder
        ];

        return view("admin.{$this->viewFolder}.store-edit", compact('pageInfo'));
    }

    public function store(StoreRequest $req) {
        $status = "error";
        $message = $this->msgStoreErr;

        $manufacture = NhaSanXuat::create(['ten' => $req->ten]);

        if (!empty($manufacture)) {
            if($files = $req->file('hinh_anh')) {
                $manufacture->update(['hinh_anh' => Upload::store($files, "anh_nsx")]);
            }
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

        $manufacture = NhaSanXuat::find($id);

        if (!empty($manufacture)) {
            return view("admin.{$this->viewFolder}.store-edit", compact('pageInfo', 'manufacture'));
        }

        $status = 'error';
        $message = $this->msgNotFound;

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function update(Request $req, $id) {
        $status = 'error';
        $message = $this->msgUpdateErr;

        $manufacture = NhaSanXuat::find($id);

        if (!empty($manufacture)) {
            $valid = $this->validate($req, (new UpdateRequest)->rules($manufacture->id), (new UpdateRequest)->messages());
            $manufacture->update(['ten' => $valid['ten']]);

            if ($req->is_remove == 'removed') {
                Upload::delete($manufacture->hinh_anh, 'anh_nsx');
                $manufacture->update(['hinh_anh' => null]);
            }

            if($file = $req->file('hinh_anh')) {
                if (!empty($manufacture->hinh_anh)) {
                    Upload::delete($manufacture->hinh_anh, 'anh_nsx');
                }
                $manufacture->update(['hinh_anh' => Upload::store($file, "anh_nsx")]);
            }

            $status = 'success';
            $message = $this->msgUpdateSuc;
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function destroy(Request $req) {
        $id = $req->id;

        $manufacture = NhaSanXuat::find($id);

        if (!empty($manufacture)) {
            $detail_product = ChiTietSP::where('nha_sx_id', $manufacture->id)
                                       ->first();
            if (empty($detail_product)) {
                $manufacture->delete();

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
