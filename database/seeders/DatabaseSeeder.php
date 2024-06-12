<?php

namespace Database\Seeders;

use App\Models\ClientEnterprise;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ClientEnterprise::factory()->count(5)->hasBillingInfos(3)->create();

    }
}
