<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Personnel Tablosu Güncellemesi (Hiyerarşi ve Rol Ekleme)
        Schema::table('personnel', function (Blueprint $table) {
            $table->string('academic_title')->nullable()->after('role');
            $table->string('care_rank')->nullable()->after('academic_title');
        });

        // 2. Doctors Tablosu Güncellemesi (Tüm Detaylı Doktor Veri Alanları)
        Schema::table('doctors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->string('academic_title')->nullable()->after('specialty');
            $table->string('sub_specialty')->nullable()->after('academic_title');
            $table->json('other_clinics')->nullable()->after('clinic_id');
            $table->unsignedBigInteger('examination_room_id')->nullable()->after('other_clinics');
            $table->string('working_hours')->nullable()->after('examination_room_id');
            $table->integer('appointment_capacity')->default(30)->after('working_hours');
            $table->boolean('can_operate')->default(true)->after('appointment_capacity');
            $table->boolean('can_consult')->default(true)->after('can_operate');
            $table->boolean('can_report')->default(true)->after('can_consult');
            $table->boolean('has_e_signature')->default(true)->after('can_report');
            $table->json('leave_and_shift_info')->nullable()->after('has_e_signature');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('examination_room_id')->references('id')->on('examination_rooms')->onDelete('set null');
        });

        // 3. Tarih Aralıklı Doktor Ekip/Akademik Atama Tablosu (Asistan, İntern, Araştırma Görevlisi)
        Schema::create('doctor_academic_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('senior_doctor_id');
            $table->unsignedBigInteger('junior_doctor_id');
            $table->string('role_type'); // assistant, intern, research_assistant
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->foreign('senior_doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('junior_doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });

        // 4. Tarih Aralıklı Doktor - Hemşire Ekip Bağlantı Tablosu
        Schema::create('doctor_nurse_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('nurse_personnel_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('nurse_personnel_id')->references('id')->on('personnel')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_nurse_teams');
        Schema::dropIfExists('doctor_academic_assignments');

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['examination_room_id']);
            $table->dropColumn([
                'academic_title',
                'sub_specialty',
                'other_clinics',
                'examination_room_id',
                'working_hours',
                'appointment_capacity',
                'can_operate',
                'can_consult',
                'can_report',
                'has_e_signature',
                'leave_and_shift_info',
            ]);
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn(['academic_title', 'care_rank']);
        });
    }
};
