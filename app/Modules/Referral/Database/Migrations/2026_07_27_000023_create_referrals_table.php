<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referral_code', 30)->unique(); // Örn: SVK-2026-8891
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('referring_doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->enum('referral_type', ['internal', 'external'])->default('internal'); // internal: Klinikler Arası, external: Hastaneler Arası
            $table->foreignId('target_clinic_id')->nullable()->constrained('clinics')->onDelete('set null');
            $table->string('target_hospital')->nullable(); // Örn: Ankara Şehir Hastanesi
            $table->text('reason'); // Sevk gerekçesi / nedeni
            $table->enum('transport_type', ['ambulance', 'self'])->default('self'); // ambulance: 112 / Ambulans, self: Kendi İmkânı
            $table->enum('status', ['pending', 'approved', 'transferred', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
