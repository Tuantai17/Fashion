<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:post,title',  // Đảm bảo 'title' là bắt buộc và duy nhất
            'slug' => 'nullable|unique:post,slug',  // Slug có thể là null nhưng phải duy nhất
            'type' => 'required|string',  // Loại bài viết bắt buộc và phải là chuỗi
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',  // Hình ảnh là tùy chọn nhưng phải có định dạng hình ảnh
            'status' => 'required|in:0,1',  // Trạng thái bài viết phải là 0 hoặc 1
            'topic_id' => 'required|exists:topic,id',  // Kiểm tra chủ đề tồn tại trong bảng topics
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'slug.unique' => 'Slug đã tồn tại.',
            'type.required' => 'Vui lòng chọn loại.',
            'thumbnail.image' => 'Không phải hình',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'topic_id.required' => 'Vui lòng chọn một chủ đề.',
            'topic_id.exists' => 'Chủ đề không hợp lệ.',
        ];
    }

}
