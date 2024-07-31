<?php

use App\Models\StaticPage;
use App\Models\SystemPage;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Controllers\BlogController;

function blog_slug()
{
   $blogPage = StaticPage::query()->where('id', SystemPage::query()->where('name', 'Blog')->first()->page_id ?? 0)->first();
   return $blogPage && $blogPage->slug ? $blogPage->slug : 'blog';
}
Route::get(blog_slug() . '/{category}', [BlogController::class, 'category'])->name('blog-category');
Route::get(blog_slug() . '/{category}/{article}', [BlogController::class, 'article'])->name('blog-article');
