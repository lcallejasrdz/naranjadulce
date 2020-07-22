<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CanastaRosaRequest extends FormRequest
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
                    'origins_code' => 'required|min:3|max:255',
                    'quantity' => 'required|numeric',
                    'package' => 'required|min:3|max:255',
                    'nd_themathics_id' => 'required',
                    'modifications' => 'required|min:3|max:1000',
                    'who_sends' => 'required|min:3|max:255',
                    'who_receives' => 'required|min:3|max:255',
                    'dedication' => 'required|min:3|max:1000',
                    'delivery_date' => 'required|min:3|max:255',
                    'nd_delivery_schedules_id' => 'required',
                    'observations_buildings' => 'required|min:3|max:1000',
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
