<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
                    'proof_of_payment' => 'required|mimes:pdf,jpg,jpeg',
                    'quantity' => 'required|numeric',
                    'seller_package' => 'required|min:3|max:255',
                    'seller_modifications' => 'required|min:3|max:255',
                    'delivery_type' => 'required',
                    'preferential_schedule' => 'nullable|min:3|max:255',
                    'observations_finances' => 'nullable|min:3|max:255',
                    'observations_buildings' => 'nullable|min:3|max:255',
                    'observations_shippings' => 'nullable|min:3|max:255',
                    'shipping_cost' => 'required|numeric',
                ];
            }
            case 'PUT': {
                return [];
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
