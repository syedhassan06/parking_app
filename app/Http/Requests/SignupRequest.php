<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'email|unique:users,email',
            'username' => 'nullable|unique:users,username',
            'password' => 'required|min:6|same:cpassword',
            'cpassword' => 'required|min:6'
        ];
    }

    public function messages(){
        return [
            'password.same' => "The password confirmation field doesn't match"
        ];
    }
}
