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
        Schema::create('audio_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreign('audio_id')->references('id')->on('audio')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('audio_id')->unsigned()->nullable();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('subcategory_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_sub_categories');
    }
};
