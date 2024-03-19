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
        Schema::create('booked_slots', function (Blueprint $table) {
            $table->id();
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('slot_id')->unsigned()->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_slots');
    }
};
