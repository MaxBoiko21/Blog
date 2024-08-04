<?php

namespace Modules\Blog\Controllers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Components\BlogArticlePage;
use Modules\Blog\Components\BlogCategoryPage;
use Modules\Blog\Models\BlogCategory;

class BlogController
{
   public function category(string $slug)
   {
      $blogCategory = BlogCategory::query()->slug($slug)->first();
      if ($blogCategory) {
         return Blade::renderComponent(new BlogCategoryPage($blogCategory));
      }
      abort(404);
   }
   public function article(string $categorySlug, string $articleSlug)
   {
      $blogCategory = BlogCategory::query()->slug($categorySlug)->first();
      if ($blogCategory) {
         $article = $blogCategory->articles()->where('slug', $articleSlug)->first();
         if ($article) {
            return Blade::renderComponent(new BlogArticlePage($article));
         }
      }
      abort(404);
   }
}
