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
                    'quantity' => 'required|integer',
                    'package' => 'required|min:3|max:255',
                    'modifications' => 'required|min:3|max:1000',
                    'nd_delivery_types_id' => 'required',
                    'preferential_schedule' => 'required_if:delivery_schedules_id,3|required_if:nd_delivery_types_id,2|nullable|min:3|max:255',
                    'observations_finances' => 'required|min:3|max:1000',
                    'observations_buildings' => 'required|min:3|max:1000',
                    'observations_shippings' => 'required|min:3|max:1000',
                    'delivery_price' => 'required|numeric',
                    'proof_of_payment' => 'required_if:proof_verified,0|nullable|mimes:pdf,jpg,jpeg',
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
