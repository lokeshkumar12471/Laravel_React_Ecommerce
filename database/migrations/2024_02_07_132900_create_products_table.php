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
        Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->integer('category_id');
                $table->string('meta_title')->nullable();
                $table->string('meta_keyword')->nullable();
                $table->string('meta_descrip')->nullable();
                $table->string('slug');
                $table->string('name');
                $table->mediumText('description')->nullable();
                $table->string('brand');
                $table->string('selling_price');
                $table->string('original_price');
                $table->string('qty');
                $table->string('image')->nullable();
                $table->tinyInteger('featured')->default(0)->nullable();
                $table->tinyInteger('popular')->default(0)->nullable();
                $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};