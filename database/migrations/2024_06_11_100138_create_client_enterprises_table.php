<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14)->unique();
            $table->string('name');
            $table->string('fantasy_name')->nullable();
            $table->string('address')->nullable();
            $table->enum('headquarters_unit', ['Sede', 'Unidade'])->nullable();
            $table->string('commercial_phone', 20)->nullable();
            $table->string('commercial_email')->nullable();
            $table->enum('employee_count', ['0-10', '11-50', '51-150', '151-300', '300+'])->nullable();
            $table->enum('company_size', ['Micro', 'Pequeno', 'Médio', 'Grande'])->nullable();
            $table->enum('business_segment', ['Indústria', 'Comércio/Serviço'])->nullable();
            $table->text('company_profile')->nullable();
            $table->boolean('structured_hr_department')->default(false);
            $table->string('responsible_name')->nullable();
            $table->string('responsible_email')->nullable();
            $table->string('responsible_whatsapp', 20)->nullable();
            $table->string('responsible_phone', 20)->nullable();
            $table->text('mission')->nullable();
            $table->text('values')->nullable();
            $table->boolean('pdi_program')->default(false);
            $table->json('work_regimes')->nullable();
            $table->string('profile_image_path')->nullable();

            $table->index('cnpj');
            $table->index('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_enterprises');
    }
};
