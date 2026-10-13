<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outpatient_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->text('chief_complaint')->nullable(); // Anamnez / Şikayet
            $table->text('physical_examination')->nullable(); // Fiziki Muayene
            $table->string('icd10_code', 150)->nullable(); // ICD-10 Tanı Kodu
            $table->text('treatment_plan')->nullable(); // Tedavi Planı / Öneriler
            $table->enum('status', ['in_progress', 'completed', 'referred', 'admitted'])->default('in_progress');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outpatient_examinations');
    }
};
