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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('subheading');
            $table->text('excerpt');
            $table->enum('status', ['live', 'draft', 'scheduled']);
            $table->enum('allow_comments', ['allow', 'forbidden']);
            $table->string('featured_image');
            $table->string('featured_image_caption');
            $table->text('content');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();
            //published_at
            $table->timestamp('published_at')->nullable();
            //delete_at
            $table->softDeletes();
            //created_at && updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
