<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('examination_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poliklinik_id')->constrained('polikliniks')->cascadeOnDelete();
            $table->string('name');
            $table->integer('capacity')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('examination_rooms');
    }
};
