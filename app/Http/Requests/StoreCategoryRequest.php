<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'required|unique:category,name',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'status' => 'required|in:0,1',
            'parent_id' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'thumbnail.image' => 'Tập tin phải là hình ảnh.',
            'thumbnail.mimes' => 'Ảnh không đúng định dạng (chỉ cho phép: jpg, jpeg, png, gif, webp).',
            'thumbnail.max' => 'Ảnh vượt quá dung lượng cho phép (tối đa 2MB).',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'parent_id.required' => 'Vui lòng chọn danh mục cha.',
            'parent_id.integer' => 'Danh mục cha phải là số.',
            'parent_id.min' => 'Danh mục cha không hợp lệ.',
            'sort_order.required' => 'Thứ tự sắp xếp không được để trống.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số.',
            'sort_order.min' => 'Thứ tự sắp xếp không hợp lệ.',
        ];
    }

}
