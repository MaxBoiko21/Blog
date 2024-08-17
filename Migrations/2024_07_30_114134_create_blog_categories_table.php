<?php

use App\Models\StaticPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Blog\Models\BlogCategory;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(BlogCategory::getDb(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(true);
            $table->integer('sorting')->default(0);
            $table->string('image')->nullable();
            $table->integer('views')->default(0);
            $table->json('template')->nullable();
            BlogCategory::timestampFields($table);
        });
        StaticPage::createSystemPage('Blog', 'blog::blog-component');
    }

    public function down(): void
    {
        Schema::dropIfExists(BlogCategory::getDb());
    }
};
