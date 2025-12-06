<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('team_member_id')->constrained()->cascadeOnDelete();

            $table->string('type')->default('NPLQ');
            $table->string('provider')->nullable();
            $table->date('issue_date')->default('2025-01-01');
            $table->date('expiry_date')->default('2027-01-01');
            $table->decimal('cpr_score', 5, 2)->nullable();
            $table->integer('training_hours')->default(0);
            $table->string('certificate_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};