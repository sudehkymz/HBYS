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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_code')->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('physician_id');
            $table->string('diagnosis_code')->nullable();
            $table->enum('status', ['draft', 'signed', 'dispensed', 'cancelled'])->default('draft');
            $table->boolean('is_erecepta_sent')->default(false);
            $table->string('erecepta_no')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->string('drug_name');
            $table->string('barcode')->nullable();
            $table->string('dosage');
            $table->string('frequency'); // e.g. 2x1
            $table->integer('box_count')->default(1);
            $table->string('usage_route')->default('oral');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
    }
};
