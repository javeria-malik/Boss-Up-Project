<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable(); // For storing the image path
            $table->boolean('is_best_seller')->default(false); // Best Seller flag
            $table->boolean('is_new_arrival')->default(false); // New Arrival flag
            $table->boolean('is_hot_sale')->default(false); // Hot Sale flag
            $table->string('slug')->unique(); // For SEO-friendly URL
            $table->timestamps();
            $table->softDeletes(); // Enable Soft Deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
