<?php

namespace App\Http\Requests;

use Error;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Routing\Middleware\ThrottleRequests;


class StoreUser extends FormRequest
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
            'username' => 'required',
            'password' => 'required|min:3',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Nama Specialized cannot be empty',
        ];
    }

    public function failedValidation($validator) 
    {
        throw new HttpResponseException(response()->json(
            ['success' => false, 'errors' => $validator->errors()], 422))  ;
    }

}
