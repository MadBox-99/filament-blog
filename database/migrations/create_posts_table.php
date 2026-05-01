<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $categoriesTable = config('filament-blog.table_names.categories', 'categories');

        Schema::create(config('filament-blog.table_names.posts', 'posts'), function (Blueprint $table) use ($categoriesTable) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained($categoriesTable)->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('filament-blog.table_names.posts', 'posts'));
    }
};
