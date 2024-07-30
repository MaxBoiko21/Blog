<?php

namespace Modules\Blog\Admin\BlogArticleResource\Pages;

use Modules\Blog\Admin\BlogArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogArticles extends ListRecords
{
    protected static string $resource = BlogArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
