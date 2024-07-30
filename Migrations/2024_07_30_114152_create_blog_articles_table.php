<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Blog\Models\BlogArticle;
use Modules\Blog\Models\BlogCategory;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(BlogArticle::getDb(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(BlogCategory::class)->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('slug')->unique();
            $table->integer('sorting')->default(0);
            $table->boolean('status')->default(1);
            $table->string('image')->nullable();
            $table->integer('views')->default(0);
            $table->json('template')->nullable();
            BlogArticle::timestampFields($table);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(BlogArticle::getDb());
    }
};
