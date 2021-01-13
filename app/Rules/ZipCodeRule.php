<?php

namespace App\Rules;

use App\Traits\ValidationTrait;
use Illuminate\Contracts\Validation\Rule;

class ZipCodeRule implements Rule
{
    use ValidationTrait;

    public function passes($attribute, $value)
    {
        return $this->validateBrZipCode($value);
    }

    public function message()
    {
        return "CEP inválido";
    }
}
