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
        switch ($this->method()) {
            case 'GET': {
                return [];
            }
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'code' => 'required|min:3|max:255',
                    'category' => 'required|min:3|max:255',
                    'type' => 'nullable|min:3|max:255',
                    'product_name' => 'required|min:3|max:255',
                    'supplier' => 'nullable|min:3|max:255',
                    'brand' => 'nullable|min:3|max:255',
                    'price' => 'required|numeric',
                    'quantity' => 'required|integer',
                ];
            }
            case 'PUT': {
                return [
                    'code' => 'required|min:3|max:255',
                    'category' => 'required|min:3|max:255',
                    'type' => 'nullable|min:3|max:255',
                    'product_name' => 'required|min:3|max:255',
                    'supplier' => 'nullable|min:3|max:255',
                    'brand' => 'nullable|min:3|max:255',
                    'price' => 'required|numeric',
                    'quantity' => 'required|integer',
                    'income' => 'nullable|integer',
                    'outcome' => 'nullable|integer|lte:quantity',
                ];
            }
            case 'PATCH': {
                return [];
            }
            default: {
                break;
            }
        }
        return [];
    }
}
