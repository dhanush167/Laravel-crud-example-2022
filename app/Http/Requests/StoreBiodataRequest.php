<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBiodataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*need change true*/
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
            'first_name'=>'required|max:255|string|min:3',
            'last_name'=>'required|max:255|string|min:3',
            'image'=>'required|mimes:svg,jpeg,png,jpg|image|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required !',
            'last_name.required' => 'Last Name is required !',
            'image.required' => 'Image is required !'
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
