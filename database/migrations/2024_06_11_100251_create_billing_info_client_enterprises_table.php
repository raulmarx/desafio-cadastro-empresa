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
        Schema::create('billing_info_client_enterprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_enterprise_id')->constrained('client_enterprises')->onDelete('cascade');
            $table->string('billing_address');
            $table->string('billing_email');
            $table->string('billing_responsible');
            $table->boolean('update_billing_info')->default(false);
            $table->json('payment_methods');
            $table->date('payment_date');
            $table->enum('contract_type', ['Recorrente', 'Por uso']);
            $table->enum('package', ['A', 'B', 'C'])->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_info_client_enterprises');
    }
};
