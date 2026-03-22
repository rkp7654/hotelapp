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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->foreignId('order_inventory_id')
                ->constrained('inventory')
                ->cascadeOnDelete();
            $table->string('plan');
            $table->dateTime('from_date');
            $table->dateTime('to_date');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('payble_amount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
