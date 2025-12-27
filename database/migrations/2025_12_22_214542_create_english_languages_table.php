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
        Schema::create('english_languages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('test_type')->nullable();
            $table->string('duolingo')->nullable();
            $table->string('ielts_overall')->nullable();
            $table->string('ielts_listening')->nullable();
            $table->string('ielts_writing')->nullable();
            $table->string('ielts_speaking')->nullable();
            $table->string('ielts_reading')->nullable();
            $table->string('moi')->nullable();
            $table->string('oietc')->nullable();
            $table->string('pte_overall')->nullable();
            $table->string('pte_listening')->nullable();
            $table->string('pte_speaking')->nullable();
            $table->string('pte_writing')->nullable();
            $table->string('pte_reading')->nullable();
            $table->string('toefl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('english_languages');
    }
};
