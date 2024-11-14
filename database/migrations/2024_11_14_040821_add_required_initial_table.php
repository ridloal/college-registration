<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_induk')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->uuid('faculty_id');
            $table->string('major_study');
            $table->decimal('gpa', 3, 2);
            $table->decimal('math_score', 4, 1);
            $table->decimal('science_score', 4, 1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('faculties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('faculty_code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('registration_date_start');
            $table->date('registration_date_end');
            $table->integer('quota')->default(100);
            $table->decimal('min_math_score', 4, 1);
            $table->decimal('min_science_score', 4, 1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('faculties');
        Schema::dropIfExists('settings');
    }
};
