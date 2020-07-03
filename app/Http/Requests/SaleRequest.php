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
                    'proof_of_payment' => 'required_if:proof_verified,0|nullable|mimes:pdf,jpg,jpeg',
                    'quantity' => 'required|numeric',
                    'seller_package' => 'required|min:3|max:255',
                    'seller_modifications' => 'required|min:3|max:255',
                    'delivery_type' => 'required',
                    'preferential_schedule' => 'required_if:delivery_schedule,Horario preferencial (costo extra)|required_if:delivery_type,Preferencial|nullable|min:3|max:255',
                    'observations_finances' => 'required|min:3|max:1000',
                    'observations_buildings' => 'required|min:3|max:1000',
                    'observations_shippings' => 'required|min:3|max:1000',
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
