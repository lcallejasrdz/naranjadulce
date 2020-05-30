<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyRequest extends FormRequest
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
                    'first_name' => 'required|min:3|max:255',
                    'last_name' => 'required|min:3|max:255',
                    'email' => 'nullable|email',
                    'phone' => 'required|min:3|max:255',
                    'postal_code' => 'required|min:4|max:5',
                    'state' => 'required|min:3|max:255',
                    'municipality' => 'required|min:3|max:255',
                    'colony' => 'required|min:3|max:255',
                    'street' => 'required|min:3|max:255',
                    'no_ext' => 'required|max:255',
                    'no_int' => 'nullable|max:255',
                    'address_type' => 'required',
                    'address_references' => 'required|min:3|max:255',
                    'parking' => 'required',
                    'who_sends' => 'required|min:3|max:255',
                    'who_receives' => 'required|min:3|max:255',
                    'package' => 'required|min:3|max:255',
                    'modifications' => 'nullable|min:3|max:255',
                    'buy_message' => 'nullable|min:3|max:255',
                    'delivery_date' => 'required|min:3|max:255',
                    'delivery_schedule' => 'required',
                    'observations' => 'nullable|max:255',
                    'how_know_us' => 'required',
                    'how_know_us_other' => 'required_if:how_know_us,Otro|max:255',
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
