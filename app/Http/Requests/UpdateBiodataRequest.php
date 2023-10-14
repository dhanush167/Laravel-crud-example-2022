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
                'image' => 'required|mimes:svg,jpeg,png,jpg|image|max:2048'
            ];
        } else {
            return [
                'first_name' => 'required|max:255|string|min:3',
                'last_name' => 'required|max:255|string|min:3',
            ];
        }


    }
}
