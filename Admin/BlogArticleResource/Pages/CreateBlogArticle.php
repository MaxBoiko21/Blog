<?php

namespace Modules\Blog\Admin\BlogArticleResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Blog\Admin\BlogArticleResource;

class CreateBlogArticle extends CreateRecord
{
    protected static string $resource = BlogArticleResource::class;
}
