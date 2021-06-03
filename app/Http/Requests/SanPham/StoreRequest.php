<?php

namespace App\Http\Requests\SanPham;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ma_sp'         => 'bail|required|unique:san_pham,ma_sp|regex:/^[\w]{6,10}$/',
            'loai_sp_id'    => 'bail|required|integer',
            'nha_sx_id'     => 'bail|required|integer',
            'ten_sp'        => 'bail|required|unique:chi_tiet_sp,ten_sp|regex:/^[\wÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s,]{1,191}$/',
            'gia'           => 'bail|required|numeric',
            'mo_ta'         => 'bail|required|max:191',
            'mau_sac'       => 'bail|required|max:50',
            'so_luong'      => 'bail|required|integer',
            'giam_gia'      => 'bail|nullable|numeric',
            'hinh_anh.*'    => 'bail|required|mimes:jpg,jpeg,png',
            'chat_lieu'     => 'bail|required|regex:/^[a-zA-ZÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s\+]{1,100}$/',
            'so_ngan'       => 'bail|required|regex:/^[\wÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s\-]{1,100}$/',
            'khoi_luong'    => 'bail|required|regex:/^[\d.]{1,5}$/',
            'kich_thuoc'    => 'bail|required|regex:/^[\dx\s]{1,20}$/',
            'tai_trong'     => 'bail|required|regex:/^[\d]{1,3}$/',
            'ngan_lap'      => 'bail|required|regex:/^[\d]{1,2}$/',
            'tinh_trang'    => 'bail|required|boolean'
        ];
    }

    public function messages() {
        return [
            'ma_sp.required'        => 'Vui lòng nhập mã sản phẩm',
            'loai_sp_id.required'   => 'Vui lòng chọn loại sản phẩm',
            'nha_sx_id.required'    => 'Vui lòng chọn nhà sản xuất',
            'ten_sp.required'       => 'Vui lòng nhập tên sản phẩm',
            'gia.required'          => 'Vui lòng nhập giá',
            'mo_ta.required'        => 'Vui lòng nhập mô tả',
            'mau_sac.required'      => 'Vui lòng nhập màu sắc',
            'so_luong.required'     => 'Vui lòng nhập số lượng',
            'hinh_anh.*.required'   => 'Vui lòng chọn hình ảnh',
            'ma_sp.unique'          => 'Mã sản phẩm đã tồn tại',
            'ma_sp.regex'           => 'Mã sản phẩm không đúng định dạng',
            'loai_sp_id.integer'    => 'Loại sản phẩm không đúng định dạng',
            'ten_sp.unique'         => 'Tên sản phẩm đã tồn tại',
            'ten_sp.regex'          => 'Tên sản phẩm không đúng định dạng',
            'gia.numeric'           => 'Giá không đúng định dạng',
            'mo_ta.max'             => 'Mô tả không quá 191 ký tự',
            'mau_sac.max'           => 'Màu sắc không quá 50 ký tự',
            'so_luong.integer'      => 'Số lượng không đúng định dạng',
            'giam_gia.numeric'      => 'Giảm giá không đúng định dạng',
            'hinh_anh.*.mimes'      => 'Hình ảnh phải là jpg, jpeg, png',
            'chat_lieu.required'    => 'Vui lòng nhập chất liệu',
            'so_ngan.required'      => 'Vui lòng nhập số ngăn',
            'khoi_luong.required'   => 'Vui lòng nhập khối lượng',
            'kich_thuoc.required'   => 'Vui lòng nhập kích thước',
            'tai_trong.required'    => 'Vui lòng nhập tải trọng',
            'ngan_lap.required'     => 'Vui lòng nhập ngăn laptop',
            'tinh_trang.required'   => 'Vui lòng chọn tình trạng',
            'chat_lieu.regex'       => 'Chất liệu không đúng định dạng',
            'so_ngan.regex'         => 'Số ngăn không đúng định dạng',
            'khoi_luong.regex'      => 'Khối lượng không đúng định dạng',
            'kich_thuoc.regex'      => 'Kích thước không đúng định dạng',
            'tai_trong.regex'       => 'Tải trọng không đúng định dạng',
            'ngan_lap.regex'        => 'Ngăn laptop không đúng định dạng',
            'tinh_trang.boolean'    => 'Tình trạng không đúng định dạng'
        ];
    }
}
