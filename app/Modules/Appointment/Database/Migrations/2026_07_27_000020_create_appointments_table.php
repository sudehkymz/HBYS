<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->onDelete('set null');
            $table->date('appointment_date');
            $table->string('appointment_time', 10); // Örn: '09:30'
            $table->enum('status', ['pending', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Aynı doktor için aynı tarih ve saatte mükerrer randevu oluşmasını engellemek amacıyla benzersiz indeks
            $table->unique(['doctor_id', 'appointment_date', 'appointment_time'], 'unique_doctor_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
