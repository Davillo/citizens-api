<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Repositories\CitizenRepository;
use App\Services\ViaCepService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CitizenController extends Controller
{

    /**
     * CitizenRepository
    */
    private $citizenRepository;

    /**
     * ViaCepService
    */
    private $viaCepService;

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(CitizenRepository $citizenRepository, ViaCepService $viaCepService)
    {
        $this->citizenRepository = $citizenRepository;
        $this->viaCepService = $viaCepService;
    }

    public function index(){
        $citizens = $this->citizenRepository->findAll();
        return response()->json($citizens);
    }

    public function show(int $id){
        $citizen = $this->citizenRepository->getById($id);
        return response()->json(['data' => $citizen]);
    }

    public function store(StoreCitizenRequest $request){
        $data = $request->validated();
    }

    public function update(int $id){

    }

    public function destroy(int $id){
        $this->citizenRepository->destroy($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }


}
