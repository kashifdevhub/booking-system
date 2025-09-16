<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('booking_code')->unique();
        $table->string('type'); // hotel or flight
        $table->string('item_id');
        $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('currency', 3)->default('INR');
        $table->decimal('total_amount', 12, 2)->default(0);
        $table->string('status')->default('confirmed');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
