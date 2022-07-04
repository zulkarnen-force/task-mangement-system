<?php

namespace App\Http\Requests;

use Error;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;


class StoreTicket extends FormRequest
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
            'user_id' => 'required',
            'title' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'message' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    // public function messages()
    // {
    //     // return [
    //     //     'username.required' => 'Nama Specialized cannot be empty',
    //     // ];
    // }

    public function failedValidation($validator) 
    {
        throw new HttpResponseException(response()->json(
            ['status' => false, 'errors' => $validator->errors()], 422))  ;
    }

}
