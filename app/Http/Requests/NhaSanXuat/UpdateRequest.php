<?php

namespace App\Http\Requests\NhaSanXuat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
    public function rules($id)
    {
        return [
            'ten'       => "bail|required|unique:nha_san_xuat,ten,{$id}|regex:/^[\w_ÀÁÃẢẠÂẤẦẨẪẬĂẮẰẲẴẶÈÉẸẺẼÊỀẾỂỄỆÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴÝỶỸĐàáãạảâấầẩẫậăắằẳẵặèéẹẻẽêềếểễệìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳýỵỷỹđ\s]{1,50}$/",
            'hinh_anh'  => 'bail|nullable|image|mimes:jpg,jpeg,png',
        ];
    }

    public function messages() {
        return [
            'ten.required'      => 'Vui lòng nhập tên',
            'ten.unique'        => 'Tên đã tồn tại',
            'ten.regex'         => 'Tên không đúng định dạng',
            'hinh_anh.image'    => 'Hình ảnh phải là định dạng hình',
            'hinh_anh.mimes'    => 'Hình ảnh phải là jpg, jpeg, png',
        ];
    }
}
