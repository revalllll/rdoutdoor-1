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
        Schema::create('user_roles', function (Blueprint $table) {
                $table->id(); // id: bigIncrements
                $table->string('role_name');

                // 7 field tambahan
                $table->string('CompanyCode', 20)->nullable();
                $table->tinyInteger('Status')->default(1);
                $table->tinyInteger('IsDeleted')->default(0);
                $table->string('CreatedBy', 32)->nullable();
                $table->dateTime('CreatedDate')->nullable();
                $table->string('LastUpdateBy', 32)->nullable();
                $table->dateTime('LastUpdateDate')->nullable();

                // Tidak menggunakan timestamps (created_at dan updated_at)
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
