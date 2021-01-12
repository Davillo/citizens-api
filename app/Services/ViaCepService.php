<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class ViaCepService {

    use ConsumeExternalService;

    private $baseUrl;

    function __construct()
    {
        $this->baseUrl = config('via_cep.base_url');
    }

    public function fetchZipCodeData($zipCode){
        $url = "$this->baseUrl/{$zipCode}/json";
        $data = $this->jsonRequest('GET', $url);
        return $data;
    }
}
