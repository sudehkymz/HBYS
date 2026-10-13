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
        Schema::disableForeignKeyConstraints();

        Schema::create('ai_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider')->default('openai'); // openai, ollama, mock vb.
            $table->string('version')->default('1.0');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_prompt_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_key')->unique(); // e.g. patient_summary, clinical_note, decision_support
            $table->string('name');
            $table->text('system_prompt');
            $table->text('user_prompt_template');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ai_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('request_type'); // patient_summary, clinical_note, decision_support
            $table->string('model_name')->default('gpt-4o-mini');
            $table->longText('anonymized_input');
            $table->string('status')->default('completed'); // pending, completed, failed
            $table->timestamps();
        });

        Schema::create('ai_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_request_id')->constrained('ai_requests')->onDelete('cascade');
            $table->longText('raw_response')->nullable();
            $table->longText('summary_text')->nullable();
            $table->json('clinical_suggestions_json')->nullable();
            $table->float('confidence_score')->default(0.95);
            $table->json('uncertainties_json')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_clinical_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_response_id')->constrained('ai_responses')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('suggestion_type'); // alert, test_recommendation, interaction_warning, guideline
            $table->string('title');
            $table->text('description');
            $table->string('severity')->default('info'); // info, warning, critical
            $table->string('status')->default('pending'); // pending, accepted, rejected, edited
            $table->timestamps();
        });

        Schema::create('ai_physician_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_response_id')->constrained('ai_responses')->onDelete('cascade');
            $table->unsignedBigInteger('physician_id')->nullable();
            $table->enum('action', ['accepted', 'edited', 'rejected']);
            $table->text('feedback_notes')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_physician_feedback');
        Schema::dropIfExists('ai_clinical_suggestions');
        Schema::dropIfExists('ai_responses');
        Schema::dropIfExists('ai_requests');
        Schema::dropIfExists('ai_prompt_templates');
        Schema::dropIfExists('ai_models');
    }
};
