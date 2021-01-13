<?php

namespace App\Traits;

trait ValidationTrait
{
    public function nationalRegistryValidation(string $value)
    {
        if (!preg_match("/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/", $value)) {
            return false;
        }

        $cpf = preg_replace("/[^0-9]/is", '', $value);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    function validateBrZipCode($zipCode){
        $zipCode = trim($zipCode);

        $validated = preg_match('/[0-9]{5,5}([-]?[0-9]{3})?$/', $zipCode);

        if($validated){
            return true;
        }

        return false;
    }

}
