<?php

namespace Database\Factories;

use App\Models\TaxRules;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxRulesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxRules::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'type' => 1,
            'price' => 10,
            'admin_id' => 1
        ];
    }
}
