<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi request này không.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả, bạn có thể thêm quyền nếu cần
    }

    /**
     * Các quy tắc validate cho việc thêm menu.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'parent_id' => 'nullable|integer',
            'sort_order' => 'nullable|integer|min:0',
            'type' => 'required|in:category,brand,page,topic,custom',
            'position' => 'required|in:mainmenu,footer',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (nếu muốn).
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên menu.',
            'type.required' => 'Vui lòng chọn loại menu.',
            'type.in' => 'Loại menu không hợp lệ.',
            'position.required' => 'Vui lòng chọn vị trí hiển thị.',
            'position.in' => 'Vị trí hiển thị không hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
