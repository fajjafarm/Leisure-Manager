<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_role_id')
                  ->nullable()
                  ->constrained('business_roles')
                  ->nullOnDelete();

            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('email')->unique()->default('');
            $table->string('phone')->nullable();
            $table->date('employment_start_date')->default('2025-01-01');  // ? DEFAULT ADDED
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};