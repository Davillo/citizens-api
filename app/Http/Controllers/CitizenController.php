<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Repositories\CitizenRepository;
use App\Services\ViaCepService;
use App\Utils\MasksUtil;
use Illuminate\Database\QueryException;
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

    public function index(Request $request)
    {
        $nationalRegistry = MasksUtil::unmask($request->query('national_registry') ?? "");
        $citizens = $this->citizenRepository->findAll($nationalRegistry);
        return response()->json($citizens);
    }

    public function show(int $id)
    {
        $citizen = $this->citizenRepository->getById($id);
        return response()->json(['data' => $citizen]);
    }

    public function store(StoreCitizenRequest $request)
    {
        $data = $request->validated();

        if($this->citizenRepository->checkNationalRegistry(MasksUtil::unmask($data['national_registry']))){
            return response()->json(['message'=> 'Não foi possível completar o cadastro. CPF já cadastrado.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $addressData = $this->viaCepService->fetchZipCodeData($data['zip_code']);

        if(!$addressData){
            return response()->json(['message'=> 'Não foi possível completar o cadastro. CEP Não encontrado'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $citizen = $this->citizenRepository->store($data);
        $citizen->address()->create([
            'street' => $addressData->logradouro,
            'neighborhood' => $addressData->bairro,
            'zip_code' => $addressData->cep,
            'city' => $addressData->localidade,
            'federative_unit' => $addressData->uf,
        ]);

        return response()->json(['data' => $citizen], Response::HTTP_CREATED);
    }

    public function update(int $id, UpdateCitizenRequest $request)
    {
        $data = $request->validated();
        $citizen = $this->citizenRepository->getById($id);

        if($citizen->getRawOriginal('national_registry') !== MasksUtil::unmask($request->national_registry)){
            if($this->citizenRepository->checkNationalRegistry(MasksUtil::unmask($data['national_registry']))){
                return response()->json(['message'=> 'Não foi possível completar o cadastro. CPF já cadastrado.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $citizen->update($data);

        $data['zip_code'] = MasksUtil::unmask($data['zip_code']);
        $addressData = $this->viaCepService->fetchZipCodeData($data['zip_code']);

        if(!$addressData){
            return response()->json(['message'=> 'Não foi possível completar o cadastro. CEP Não encontrado'], Response::HTTP_BAD_REQUEST);
        }

        $citizen->address()->update([
            'street' => $addressData->logradouro,
            'neighborhood' => $addressData->bairro,
            'zip_code' => MasksUtil::unmask($addressData->cep),
            'city' => $addressData->localidade,
            'federative_unit' => $addressData->uf
        ]);

        return response()->json(['data' => $citizen], Response::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $this->citizenRepository->destroy($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }


}
