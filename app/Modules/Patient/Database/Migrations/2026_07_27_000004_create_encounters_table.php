<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('episode_of_care_id')->nullable()->constrained('episodes_of_care')->onDelete('set null');
            $table->foreignId('physician_id')->constrained('users');
            $table->enum('type', ['outpatient', 'emergency', 'inpatient', 'surgery', 'checkup']);
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('in_progress');
            $table->timestamp('encounter_date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('encounters'); }
};