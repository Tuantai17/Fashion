<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:topic,slug',
        'description' => 'nullable|string|max:1000', // ✅ thêm mô tả
        'status' => 'required|in:0,1',                // ✅ thêm trạng thái
    ];
}


    
    public function messages(): array
    {
        return [
            'name.required' => 'Tên chủ đề không được để trống.',
            'name.max' => 'Tên chủ đề quá dài.',
            'slug.unique' => 'Slug đã tồn tại.',
        ];
    }
}
