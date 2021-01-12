<?php

namespace App\Rules;

use App\Utils\ValidationTrait;
use Illuminate\Contracts\Validation\Rule;

class NationalRegistryRule implements Rule
{
    use ValidationTrait;

    public function passes($attribute, $value)
    {
        return $this->nationalRegistryValidation($value);
    }

    public function message()
    {
        return "CPF inválido";
    }
}
