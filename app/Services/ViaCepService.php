<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;
use App\Utils\MasksUtil;

class ViaCepService {

    use ConsumeExternalService;

    private $baseUrl;

    function __construct()
    {
        $this->baseUrl = config('services.via_cep.base_url');
    }

    public function fetchZipCodeData($zipCode){
        $zipCode = MasksUtil::unmask($zipCode);
        $url = "$this->baseUrl/{$zipCode}/json";
        $data = $this->jsonRequest('GET', $url);
        return $data;
    }
}
