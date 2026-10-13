<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_triages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->enum('triage_category', ['red', 'yellow', 'green'])->default('yellow'); // Kırmızı: Kritik, Sarı: Orta, Yeşil: Hafif
            $table->text('chief_complaint'); // Başvuru şikayeti
            $table->json('vital_signs')->nullable(); // Tansiyon, Nabız, Ateş, SpO2
            $table->foreignId('assigned_doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->enum('status', ['waiting', 'in_treatment', 'discharged', 'transferred'])->default('waiting');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_triages');
    }
};
