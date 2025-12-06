<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('team_member_id')->constrained()->cascadeOnDelete();

            $table->string('title')->default('General Training');
            $table->integer('hours')->default(0);
            $table->date('date')->default('2025-01-01');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_logs');
    }
};