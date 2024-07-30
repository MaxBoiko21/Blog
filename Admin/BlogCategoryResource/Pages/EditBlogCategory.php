<?php

namespace Modules\Blog\Admin\BlogCategoryResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Blog\Admin\BlogCategoryResource;

class EditBlogCategory extends EditRecord
{
    protected static string $resource = BlogCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
