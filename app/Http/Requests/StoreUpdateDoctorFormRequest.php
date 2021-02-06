<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateDoctorFormRequest extends FormRequest
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

    public function messages()
    {
        return [
            'email.unique'  => 'Médico já cadastrado.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);

        return [
            'name' => "required|min:3",
            'email' => "required|unique:doctors,email,{$id},id",
            'phone' => "required"
        ];
    }
}
