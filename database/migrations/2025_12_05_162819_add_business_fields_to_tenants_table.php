<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('subscription_plan')->default('basic');
            $table->dropColumn('data'); // goodbye forever
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->json('data')->nullable();
            $table->dropColumn(['name', 'contact_name', 'email', 'phone', 'subscription_plan']);
        });
    }
};