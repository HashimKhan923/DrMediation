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
        Schema::create('v_c_v_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('voice')->nullable();
            $table->decimal('chat')->nullable();
            $table->decimal('video')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_c_v_s');
    }
};
