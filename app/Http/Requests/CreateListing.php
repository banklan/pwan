<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateListing extends FormRequest
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
            'prop.name' => 'required|min:5|max:250|unique:property_listings,name',
            'prop.location' => 'required|min:5|max:500',
            'prop.landmark' => 'required|min:5|max:500',
            'prop.title' => 'max:300',
            'prop.detail' => 'required|min:10|max:1000',
            'prop.price' => 'required|numeric|between:1,100000000000',
            'prop.size' => 'max:20',
        ];
    }

    public function messages()
    {
        return[
            'prop.name.required' => 'The name of the listing is required',
            'prop.name.min' => 'The name must be at least 5 characters long',
            'prop.name.max' => 'The name must not exceed 250 characters',
            'prop.name.unique' => 'The property name has already been taken!',
            'prop.title.required' => 'The title is required!',
        ];
    }
}
