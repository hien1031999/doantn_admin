<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuanTriVien;
use App\Models\VaiTro;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NhanVien\StoreRequest;
use App\Http\Requests\NhanVien\UpdateRequest;

class QuanTriVienController extends Controller
{
    private $viewFolder = 'nhan-vien';
    private $page = 'Nhân viên';

    public function index(Request $req) {
        $pageInfo = [
            'page'  => $this->page
        ];

        $inputSearch = [
            'ten'           => $req->ten,
            'email'         => $req->email,
            'sdt'           => $req->sdt,
            'vai_tro_id'    => $req->vai_tro_id,
            'bi_khoa'       => $req->bi_khoa
        ];

        $isSearch = false;
        foreach($inputSearch as $key => $value) {
            if (!empty($value)) {
                $isSearch = true;
                break;
            }
        }

        $admins = QuanTriVien::sortable()
                             ->where('vai_tro_id', '<>', '1');

        if (!empty($req->ten)) {
            $admins->where('ten', 'like', "%{$req->ten}%");
        }

        if (!empty($req->email)) {
            $admins->where('email', 'like', "%{$req->email}%");
        }

        if (!empty($req->sdt)) {
            $admins->where('sdt', $req->sdt);
        }

        if (!empty($req->vai_tro_id)) {
            $admins->where('vai_tro_id', $req->vai_tro_id);
        }

        if (isset($req->bi_khoa)) {
            $admins->where('bi_khoa', $req->bi_khoa);
        }

        $vai_tro = VaiTro::whereNotIn('ten', ['Quản trị viên', 'Khách hàng'])
                         ->get();

        $admins = $admins->orderBy('ten')
                         ->with('vai_tro')
                         ->paginate($this->limit);

        return view("{$this->viewFolder}.list", compact('pageInfo', 'admins', 'inputSearch', 'vai_tro', 'isSearch'));
    }

    public function show($id) {
        $pageInfo = [
            'page'  => 'Chi tiết nhân viên'
        ];

        $admin = QuanTriVien::with('vai_tro')
                            ->find($id);
        if (!empty($admin)) {
            return view('detail-user', compact('pageInfo', 'admin'));
        }

        return redirect()->route('dashboard');
    }

    public function create() {
        $pageInfo = [
            'subtitle'  => $this->add,
            'page'      => $this->page,
            'route'     => $this->viewFolder
        ];

        $vai_tro = VaiTro::whereNotIn('ten', ['Quản trị viên', 'Khách hàng'])
                         ->get();

        return view("{$this->viewFolder}.store-edit", compact('pageInfo', 'vai_tro'));
    }

    public function store(StoreRequest $req) {
        $status = "error";
        $message = $this->msgStoreErr;

        $valid = $req->validated();
        $valid['mat_khau'] = Hash::make('nv@123');
        $valid['bi_khoa'] = false;

        $admin = QuanTriVien::create($valid);

        if (!empty($admin)) {
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

        $admin = QuanTriVien::find($id);

        $vai_tro = VaiTro::whereNotIn('ten', ['Quản trị viên', 'Khách hàng'])
                         ->get();

        if (!empty($admin)) {
            return view("{$this->viewFolder}.store-edit", compact('pageInfo', 'admin', 'vai_tro'));
        }

        $status = 'error';
        $message = $this->msgNotFound;

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function update(Request $req, $id) {
        $status = 'error';
        $message = $this->msgUpdateErr;

        $admin = QuanTriVien::find($id);

        if (!empty($admin)) {
            $valid = $this->validate($req, (new UpdateRequest)->rules($admin->id), (new UpdateRequest)->messages());

            $admin->update($valid);

            $status = 'success';
            $message = $this->msgUpdateSuc;
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $message);
    }

    public function destroy(Request $req) {
        $id = $req->id;

        $admin = QuanTriVien::find($id);

        if (!empty($admin)) {
            $admin->delete();

            return response()->json([
                'title'     => 'Xóa nhân viên',
                'status'    => 'success',
                'msg'       => $this->msgDeleteSuc
            ]);
        }

        return response()->json([
            'title'     => 'Xóa nhân viên',
            'status'    => 'error',
            'msg'       => $this->msgDeleteErr
        ]);
    }

    public function updateDetail(Request $req, $id) {
        $data = $req->toArray();
        $admin = QuanTriVien::find($id);
        if (!empty($admin)) {
            $admin->update($data);
            return response()->json([
                'status'    => 'success',
                'msg'       => 'Cập nhật thông tin thành công'
            ], 200);
        }

        return response()->json([
            'status'    => 'error',
            'msg'       => 'Cập nhật thông tin không thất bại'
        ], 400);
    }

    public function changePass(Request $req) {
        $status = 'error';

        $admin = QuanTriVien::find($req->id);

        if (!empty($admin)) {
            $status = 'success';

            $admin->update([
                'mat_khau'  => Hash::make($req->new_pass)
            ]);

            return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $this->msgChangePassSuc);
        }

        return redirect()->route("{$this->viewFolder}.list")->with('status', $status)->with('message', $this->msgChangePassErr);
    }

    public function viewChangePassDetail() {
        $pageInfo = [
            'page'  => 'Thay đổi mật khẩu'
        ];

        return view('change-pass', compact('pageInfo'));
    }

    public function changePassDetail(Request $req, $id) {
        $status = 'error';

        $admin = QuanTriVien::find($id);

        if (!empty($admin)) {
            if (Hash::check($req->old_pass, $admin->mat_khau)) {
                if ($req->new_pass != $req->confirm_pass) {
                    return redirect()->route('detail.view-change', ['id' => $admin->id])->with('status', $status)->with('message', 'Xác nhận mật khẩu mới không trùng mật khẩu mới');
                }

                $admin->update([
                    'mat_khau'  => Hash::make($req->new_pass)
                ]);

                $status = 'success';

                return redirect()->route('detail.view-change', ['id' => $admin->id])->with('status', $status)->with('message', $this->msgChangePassSuc);
            }

            return redirect()->route('detail.view-change', ['id' => $admin->id])->with('status', $status)->with('message', 'Mật khẩu cũ không đúng');
        }

        return redirect()->route('detail.view-change', ['id' => $admin->id])->with('status', $status)->with('message', $this->msgChangePassErr);
    }

    public function lockOrUnlockUser(Request $req) {
        $admin = QuanTriVien::find($req->id);

        if (!empty($admin)) {
            $admin->update(['bi_khoa' => !$admin->bi_khoa]);
            $title = ($admin->bi_khoa == 1) ? 'Khóa' : 'Mở khóa';
            return response()->json([
                'title'     => "{$title} nhân viên",
                'status'    => 'success',
                'msg'       => 'Thành công'
            ]);
        }

        return response()->json([
            'title'     => "{$title} nhân viên",
            'status'    => 'error',
            'msg'       => 'Có lỗi trong khi thực hiện'
        ]);
    }
}
