<?php

namespace Modules\Blog\Admin\BlogCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Blog\Admin\BlogCategoryResource;

class ListBlogCategories extends ListRecords
{
    protected static string $resource = BlogCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
