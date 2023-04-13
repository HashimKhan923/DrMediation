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
        Schema::create('podcast_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('podcast_id')->unsigned()->nullable();
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
        Schema::dropIfExists('podcast_sub_categories');
    }
};
