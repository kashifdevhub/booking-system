<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique(); // INR, USD
            $table->decimal('value', 14, 6)->default(1);
            $table->timestamps();
        });

        // Optional: seed default values
        DB::table('currencies')->insert([
            ['code' => 'INR', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'USD', 'value' => 0.012, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
