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
        Schema::create('option_categories', function (Blueprint $table) {
            $table->id();
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('option_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('category_id')->unsigned()->nullable();
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
        Schema::dropIfExists('option_categories');
    }
};
