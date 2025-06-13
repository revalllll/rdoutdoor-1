<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 32);
            $table->string('customer_name', 100);
            $table->decimal('total_price', 12, 2); // ubah dari 'total' menjadi 'total_price'
            $table->date('order_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            // 7 field wajib
            $table->string('CompanyCode', 20);
            $table->tinyInteger('Status')->default(1);
            $table->tinyInteger('IsDeleted')->default(0);
            $table->string('CreatedBy', 32);
            $table->dateTime('CreatedDate');
            $table->string('LastUpdateBy', 32)->nullable();
            $table->dateTime('LastUpdateDate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};