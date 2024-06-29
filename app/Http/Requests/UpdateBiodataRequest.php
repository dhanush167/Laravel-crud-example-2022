<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBiodataRequest extends FormRequest
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

        if ($this->attributes->get('image')) {
            return [
                'first_name' => 'required|max:255|string|min:3',
                'last_name' => 'required|max:255|string|min:3',
                'image' => 'required|mimes:svg,jpeg,png,jpg|image|max:2048',
                'date_of_birth'=>'required|date|after:11/01/1925',
            ];
        } else {
            return [
                'first_name' => 'required|max:255|string|min:3',
                'last_name' => 'required|max:255|string|min:3',
                'date_of_birth'=>'required|date|after:11/01/1925',
            ];
        }


    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required !',
            'last_name.required' => 'Last Name is required !',
            'image.required' => 'Image is required !',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'first_name' => 'trim|capitalize|escape',
            'last_name' => 'trim|capitalize|escape'
        ];
    }

}
