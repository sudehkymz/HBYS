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
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('physician_id');
            $table->string('report_type'); // rest_report, disability_report, drug_report, committee_report
            $table->string('diagnosis');
            $table->integer('rest_days')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->longText('report_content');
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'rejected'])->default('draft');
            $table->string('chief_physician_approval_status')->default('pending');
            $table->string('e_rapor_no')->nullable();
            $table->timestamps();
        });

        Schema::create('report_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_report_id')->constrained('medical_reports')->onDelete('cascade');
            $table->unsignedBigInteger('approver_id');
            $table->enum('status', ['approved', 'rejected']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_approvals');
        Schema::dropIfExists('medical_reports');
    }
};
