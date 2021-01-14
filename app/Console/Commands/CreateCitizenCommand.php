<?php

namespace App\Console\Commands;

use App\Repositories\CitizenRepository;
use App\Rules\NationalRegistryRule;
use App\Rules\PhoneRule;
use App\Rules\ZipCodeRule;
use App\Services\ViaCepService;
use App\Utils\MasksUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CreateCitizenCommand extends Command
{
    /**
     * CitizenRepository
     */
    private $citizenRepository;

    /**
     * ViaCepService
     */
    private $viaCepService;

    public function __construct(ViaCepService $viaCepService, CitizenRepository $citizenRepository)
    {
        parent::__construct();
        $this->viaCepService = $viaCepService;
        $this->citizenRepository = $citizenRepository;
    }
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "citizen:create {--name=} {--last_name=} {--national_registry=} {--email=} {--zip_code=} {--celphone=}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Creates a Citizen. Example: citizen:create --name=foo --last_name=bar --national_registry=111.111.111-52 --email=foobar@foo.com.br --zip_code=63119300 --celphone=88997334847";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $args = Arr::only($this->options(), ['name', 'last_name', 'national_registry', 'email', 'zip_code', 'celphone']);
        $this->validateOptions($args);
        $citizenData = Arr::only($args, ['name', 'last_name', 'national_registry', 'email', 'celphone']);

        if($this->citizenRepository->checkNationalRegistry(MasksUtil::unmask($citizenData['national_registry']))){
            $this->error('National registry already taken.');
            return 1;
        }

        $addressData = $this->viaCepService->fetchZipCodeData($this->option('zip_code'));

        if(!$addressData){
            $this->warn('Zip code Not found.');
            return 1;
        }

        $citizen = $this->citizenRepository->store($citizenData);

        $citizen->address()->create([
            'street' => $addressData->logradouro,
            'neighborhood' => $addressData->bairro,
            'zip_code' => $addressData->cep,
            'city' => $addressData->localidade,
            'federative_unit' => $addressData->uf,
        ]);

        $this->info('Citizen created.');
    }

    private function validateOptions(array $options){
        $validator = Validator::make([
            'name' => $options['name'],
            'last_name' => $options['last_name'],
            'national_registry' => $options['national_registry'],
            'email' => $options['email'],
            'zip_code' => $options['zip_code'],
            'celphone' => $options['celphone']
        ], [
            'name' => ['required'],
            'last_name' => ['required'],
            'national_registry' => ['required', new NationalRegistryRule],
            'email' => ['required', 'email'],
            'zip_code' => ['required', new ZipCodeRule],
            'celphone' => ['required', new PhoneRule],
        ]);

        if ($validator->fails()) {
            $this->warn('Citizen not created. the errors are below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
    }
}
