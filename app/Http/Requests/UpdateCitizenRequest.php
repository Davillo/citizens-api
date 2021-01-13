<?php

namespace App\Http\Requests;

use App\Rules\ZipCodeRule;
use App\Rules\NationalRegistryRule;
use App\Rules\PhoneRule;
use Pearl\RequestValidate\RequestAbstract;

class UpdateCitizenRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'celphone' => ['string','required', new PhoneRule],
            'national_registry' => ['required', 'string', new NationalRegistryRule],
            'zip_code' => ['required', 'string', new ZipCodeRule],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'last_name.required' => 'O sobrenome é obrigatório',
            'national_registry.required' => 'O CPF é obrigatório',
            'zip_code.required' => 'O CEP é obrigatório',
            'celphone.required' => 'O número de celular é obrigatório',
            'email.required' => 'O e-mail é obrigatório'
        ];
    }
}
