<?php

use App\Models\Address;
use App\Models\Citizen;
use Illuminate\Support\Facades\DB;

class CitizensApiTest extends TestCase
{

    /**
     * /citizens [POST]
    */
    public function testCitizensStore(){
        DB::beginTransaction();

        $this->post("citizens", [
            'name' => 'foo',
            'last_name' => 'bar',
            'national_registry' => '06959077354',
            'email' => 'foobar@gmail.com',
            'celphone' => '88997334947',
            'zip_code' => '63119300',
        ]);

        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'data' =>
                [
                    'name',
                    'last_name',
                    'national_registry',
                    'email',
                    'celphone',
                    'created_at',
                    'updated_at',
                    'address' => [
                        'id',
                        'street',
                        'neighborhood',
                        'zip_code',
                        'city',
                        'federative_unit',
                        'created_at',
                        'updated_at'
                    ]
                ]
        ]);
        DB::rollBack();
    }

    /**
     * /citizens [GET]
    */
    public function testCitizensIndex(){
        DB::beginTransaction();

        Citizen::factory()->count(10)->create()->each(function ($citizen){
            Address::factory()->count(1)->create(['citizen_id' => $citizen->id]);
        });

        $this->get("citizens", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'name',
                    'last_name',
                    'national_registry',
                    'email',
                    'celphone',
                    'created_at',
                    'updated_at',
                    'address' => [
                        'id',
                        'street',
                        'neighborhood',
                        'zip_code',
                        'city',
                        'federative_unit',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        ]);
        DB::rollBack();
    }

     /**
     * /citizens/{id} [GET]
    */
    public function testCitizenShow(){
        DB::beginTransaction();

        $citizen = Citizen::factory()->create();
        Address::factory()->count(1)->create(['citizen_id' => $citizen->id]);


        $this->get("/citizens/{$citizen->id}", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' =>
                [
                    'name',
                    'last_name',
                    'national_registry',
                    'email',
                    'celphone',
                    'created_at',
                    'updated_at',
                    'address' => [
                        'id',
                        'street',
                        'neighborhood',
                        'zip_code',
                        'city',
                        'federative_unit',
                        'created_at',
                        'updated_at'
                    ]
                ]
        ]);
        DB::rollBack();
    }


     /**
     * /citizens/{id} [DELETE]
    */
    public function testCitizenDestroy(){
        DB::beginTransaction();

        $citizen = Citizen::factory()->create();
        Address::factory()->count(1)->create(['citizen_id' => $citizen->id]);


        $this->delete("/citizens/{$citizen->id}", []);
        $this->seeStatusCode(204);

        DB::rollBack();
    }
}
