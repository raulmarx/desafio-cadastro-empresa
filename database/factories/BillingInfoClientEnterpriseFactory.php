<?php

namespace Database\Factories;

use App\Models\ClientEnterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingInfoClientEnterprise>
 */
class BillingInfoClientEnterpriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_enterprise_id' => ClientEnterprise::factory(),
            'billing_address' => $this->faker->address,
            'billing_email' => $this->faker->companyEmail,
            'billing_responsible' => $this->faker->name,
            'update_billing_info' => $this->faker->boolean,
            'payment_methods' => json_encode($this->faker->randomElements(['Boleto', 'Contrato Faturado', 'Pix', 'Cartão'], $count = 2)),
            'payment_date' => $this->faker->date,
            'contract_type' => $this->faker->randomElement(['Recorrente', 'Por uso']),
            'package' => $this->faker->randomElement(['A', 'B', 'C'])  
        ];
    }
}
