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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->string('order_id')->unique();
        $table->string('roblox_username');
        $table->unsignedInteger('robux_amount');
        $table->unsignedBigInteger('total_price');

        $table->string('payment_method')->nullable();

        $table->string('payment_status')->default('pending');
        $table->string('order_status')->default('pending');

        $table->timestamp('expires_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
