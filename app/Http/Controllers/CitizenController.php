<?php

namespace App\Http\Controllers;

use App\Repositories\CitizenRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function index(){
        $citizens = $this->citizenRepository->findAll();
        return response()->json($citizens);
    }

    public function show(int $id){
        $citizen = $this->citizenRepository->getById($id);
        return response()->json(['data' => $citizen]);
    }

    public function store(){

    }

    public function update(int $id){

    }

    public function destroy(int $id){
        $this->citizenRepository->destroy($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }


}
