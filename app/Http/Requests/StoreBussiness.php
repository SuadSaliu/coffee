<?php

namespace App\Http\Requests;

use App\Bussiness;
use Illuminate\Foundation\Http\FormRequest;

class StoreBussiness extends FormRequest
{
    /**
     * Determine if the bussiness is authorized to make this request.
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
        return Bussiness::$rules;
    }

    public function messages()
    {
        return [
            'role.required' => 'The role field is required.',
        ];
    }
}
