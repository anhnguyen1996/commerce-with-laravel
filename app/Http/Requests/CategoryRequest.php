<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required',
            'category_priority' => 'required|integer|min:1|max:255'
        ];
    }

    public function messages()
    {
        return [
            'category_name.required' => 'Tên danh mục không được rỗng',            
            'category_priority.required' => 'Độ ưu tiên không được rỗng'       
        ];
    }
}
