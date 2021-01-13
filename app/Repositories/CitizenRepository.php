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

    function findAll(string $nationalRegistry)
    {
        $citizens = $this->model->when($nationalRegistry != '',
        function($query)  use ($nationalRegistry){
            return $query->where('national_registry', $nationalRegistry);
        },
        function($query){
            return $query;
        });

        return $citizens->orderBy('name')->paginate(20);
    }

    function checkNationalRegistry(string $nationalRegistry): bool
    {
        return !!$this->model->where('national_registry', $nationalRegistry)->first();
    }
}
