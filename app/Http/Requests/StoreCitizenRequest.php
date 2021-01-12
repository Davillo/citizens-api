<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

class StoreCitizenRequest extends RequestAbstract
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
            'national_registry' => ['string|required|unique:citizens,national_registry', new NationalRegistryRule($this->request->get('national_registry'))]
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
            //
        ];
    }
}
