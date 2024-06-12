<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientEnterprise>
 */
class ClientEnterpriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cnpj' => $this->faker->unique()->numerify('########0001##'),
            'name' => $this->faker->company,
            'fantasy_name' => $this->faker->companySuffix,
            'address' => $this->faker->address,
            'headquarters_unit' => $this->faker->randomElement(['Sede', 'Unidade']),
            'commercial_phone' => substr($this->faker->phoneNumber, 0, 20),
            'commercial_email' => $this->faker->companyEmail,
            'employee_count' => $this->faker->randomElement(['0-10', '11-50', '51-150', '151-300', '300+']),
            'company_size' => $this->faker->randomElement(['Micro', 'Pequeno', 'Médio', 'Grande']),
            'business_segment' => $this->faker->randomElement(['Indústria', 'Comércio/Serviço']),
            'company_profile' => $this->faker->paragraph,
            'structured_hr_department' => $this->faker->boolean,
            'responsible_name' => $this->faker->name,
            'responsible_email' => $this->faker->email,
            'responsible_whatsapp' => substr($this->faker->phoneNumber, 0, 20),
            'responsible_phone' => substr($this->faker->phoneNumber, 0, 20),
            'mission' => $this->faker->paragraph,
            'values' => $this->faker->paragraph,
            'pdi_program' => $this->faker->boolean,
            'work_regimes' => json_encode($this->faker->randomElements(['CLT', 'Autônomo', 'Trainee', 'Estagiário', 'Jovem Aprendiz', 'Menor Aprendiz'], $count = 3)),
            'profile_image_path' => $this->faker->imageUrl,
        ];
    }
}
