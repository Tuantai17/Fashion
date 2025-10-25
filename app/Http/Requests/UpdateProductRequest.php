<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'detail' => 'required',
            'price_root' => 'required',
            'price_sale' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm không để trống',
            'detail.required' => 'Chi tiết bắt buộc nhập',
            'price_root.required' => 'Giá gốc bắt buộc nhập',
            'price_sale.required' => 'Giá sale bắt buộc nhập',
            'qyt.required' => 'bắt buộc nhập',
            'category_id.required' => 'Danh mục bắt buộc nhập',
            'brand_id.required' => 'Thương hiệu bắt buộc nhập',
            'thumbnail.image' => 'Ảnh không hợp lệ',
            'thumbnail.mimes' => 'Không đúng định dạng',
        ];
    }
}