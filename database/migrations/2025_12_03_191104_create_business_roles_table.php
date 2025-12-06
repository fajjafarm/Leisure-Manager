<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->default('Staff Member');
            $table->json('permissions')->nullable();
            $table->json('module_access')->default('["team"]');
            $table->integer('rank_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_roles');
    }
};