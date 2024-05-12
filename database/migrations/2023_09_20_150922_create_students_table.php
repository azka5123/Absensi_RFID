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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name',55);
            $table->string('nis',5);
            $table->string('kelas',2);
            $table->string('jurusan',10);
            $table->integer('terlambat',1)->nullable();
            $table->integer('alfa',1)->nullable();
            $table->string('uid', 12);
            $table->string('hp_ortu', 14)->nullable();
            $table->string('face_trained',4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
