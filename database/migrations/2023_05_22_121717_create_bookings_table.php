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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('advisor_id')->unsigned()->nullable();
            $table->foreign('advisor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); 
            $table->bigInteger('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade'); 
            $table->bigInteger('slot_id')->unsigned()->nullable();
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade')->onUpdate('cascade');  
            $table->enum('status', ['pending', 'completed']);
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
