<?php

namespace App\Http\Requests;

use App\Rules\BrZipCodeRule;
use App\Rules\NationalRegistryRule;
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
            'name' => 'string|nullable',
            'last_name' => 'string|nullable',
            // 'national_registry' => ['nullable', 'string', new NationalRegistryRule],
            'zip_code' => ['nullable', 'string', new BrZipCodeRule],
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
