<?php

namespace App\Repositories;

use App\Models\Citizen;
use App\Repositories\BaseRepository;

class CitizenRepository extends BaseRepository
{

    function __construct(Citizen $citizen = null)
    {
        parent::__construct($citizen ?? new Citizen());
    }

    function findAll(){
        return $this->model->orderBy('name')->paginate(20);
    }

    function checkNationalRegistry(string $nationalRegistry){
        return !!$this->model->where('national_registry', $nationalRegistry)->first();
    }
}
