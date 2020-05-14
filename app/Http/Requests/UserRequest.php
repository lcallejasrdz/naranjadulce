<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'username' => 'required|unique:users|min:3|max:255',
                    'password' => 'required|min:6|max:16',
                    'first_name' => 'required|min:3|max:255',
                    'last_name' => 'required|min:3|max:255',
                    'email' => 'required|email|unique:users,email',
                ];
            }
            case 'PUT': {
                return [
                    'username' => 'required|min:3|max:255|unique:users,username,'.$this->id,
                    'password' => 'max:16',
                    'first_name' => 'required|min:3|max:255',
                    'last_name' => 'required|min:3|max:255',
                    'email' => 'required|email|unique:users,email,'.$this->id,
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
