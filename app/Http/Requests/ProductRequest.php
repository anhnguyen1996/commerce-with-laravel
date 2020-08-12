<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|string',
            'product_alias' => 'required|string',
            'product_price' => 'required|integer|min:1000',
            'product_sale_price' => 'integer',
            'inventory_quantity' => 'required|integer|min:0',
            'product_image' => 'image|mimes:jpeg,jpg,bmp,png|max:5120',
            'sub_product_image[]' => 'image|mimes:jpeg,jpg,bmp,png|max:5120',
            'product_category' => 'required|integer',
            'product_status' => 'required|integer',
            'product_priority' => 'required|integer'
        ];
    }

    /**
     * Get the messages when apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => 'Tên sản phẩm không được rỗng!',
            'product_name.string' => 'Tên sản phẩm phải là chuỗi!',
            'product_alias.required' => 'Tên đường dẫn không được rỗng!',
            'product_alias.string' => 'Tên đường dẫn vẫn là chuỗi!',
            'product_price.required' => 'Giá sản phẩm không được rỗng!',
            'product_price.integer' => 'Giá sản phẩm phải là số!',
            'product_price.min' => 'Giá sản phẩm ít nhất là 1000!',
            'product_sale_price.integer' => 'Giá khuyến mãi sản phẩm phải là số!',
            'intentory_quantity.required' => 'Số lượng trong kho không được rỗng!',
            'inventory_quantity.integer' => 'Số lượng trong kho phải là số!',
            'inventory_quantity.min' => 'Số lượng trong kho tối thiểu là 0!',
            'product_image.image' => 'File được tải lên không phải là ảnh!',
            'product_image.mimes' => 'Hình ảnh không đúng định dạng!',
            'product_image.max' => 'Dung lượng hình ảnh không vượt quá 5MB!',
            'sub_product_image[].image' => 'File được tải lên không phải là ảnh!',
            'sub_product_image[].mimes' => 'Hình ảnh không đúng định dạng!',
            'sub_product_image[].max' => 'Dung lượng hình ảnh không vượt quá 5MB!',
            'product_category.required' => 'Danh mục sản phẩm không được rỗng!',
            'product_category.integer' => 'Danh mục sản phẩm không hợp lệ!',
            'product_status.required' => 'Trạng thái sản phẩm không được rỗng!',
            'product_status.integer' => 'Trạng thái sản phẩm không hợp lệ!',
            'product_priority.required' => 'Độ ưu tiên sản phẩm không được rỗng!',
            'product_priority.integer' => 'Độ ưu tiên sản phẩm không hợp lệ!'
        ];
    }
}
