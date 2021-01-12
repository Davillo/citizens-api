<?php

namespace App\Http\Controllers;

use App\Repositories\CitizenRepository;

class CitizenController extends Controller
{

    private $citizenRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(CitizenRepository $citizenRepository)
    {
        $this->citizenRepository = $citizenRepository;
    }

    function index(){

    }

    function show(int $id){

    }

    function store(){

    }

    function update(int $id){

    }

    function destroy(int $id){

    }


}
