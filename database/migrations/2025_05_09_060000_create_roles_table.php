<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('company_code', 20);
            $table->tinyInteger('status');
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('created_by', 32);
            $table->dateTime('created_date');
            $table->string('last_update_by', 32)->nullable();
            $table->dateTime('last_update_date')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};