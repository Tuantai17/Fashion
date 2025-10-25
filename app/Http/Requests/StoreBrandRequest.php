<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên thương hiệu không được để trống!',
        ];
    }
}
