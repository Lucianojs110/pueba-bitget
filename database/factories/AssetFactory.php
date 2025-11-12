<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
            'brand' => $this->faker->randomElement(['Toyota', 'Ford', 'Chevrolet', 'Volkswagen', 'Renault', 'Peugeot']),
            'model' => ucfirst($this->faker->word()),
            'year' => $this->faker->numberBetween(2000, 2024),
            'plate' => strtoupper($this->faker->bothify('??###??')),
            'vin' => strtoupper($this->faker->regexify('[A-HJ-NPR-Z0-9]{17}')),
            'notes' => $this->faker->sentence(),
            'last_odometer' => $this->faker->numberBetween(10000, 250000),
        ];
    }
}
