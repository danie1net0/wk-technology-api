<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sale', static function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('sale_id')->constrained();
            $table->integer('quantity');
            $table->primary(['product_id', 'sale_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sale');
    }
};
