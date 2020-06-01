<?php

namespace App\Http\Requests;

use App\Bussiness;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBussiness extends FormRequest
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
        $bussiness_id = $this->segment(2);

        $rules = Bussiness::$rules;
        $rules['name'] = 'required|unique:bussinesses,name,'.$bussiness_id;

        return $rules;
    }

    public function messages()
    {
        return [
            'role_id.required' => 'The role field is required.',
        ];
    }
}
