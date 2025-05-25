<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            // 7 field wajib (jika ingin konsisten)
            $table->string('company_code', 20)->default('default');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->string('created_by', 32)->default('system');
            $table->dateTime('created_date')->default(now());
            $table->string('last_update_by', 32)->nullable();
            $table->dateTime('last_update_date')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};