<?php

namespace Modules\Blog\Admin\BlogCategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Blog\Admin\BlogCategoryResource;

class CreateBlogCategory extends CreateRecord
{
    protected static string $resource = BlogCategoryResource::class;
}
