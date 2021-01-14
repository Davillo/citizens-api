<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'street' => $this->faker->streetName,
            'neighborhood' => $this->faker->streetName,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'federative_unit' => $this->faker->stateAbbr
        ];
    }
}
