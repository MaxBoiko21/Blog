<?php

namespace Modules\Blog\Admin;

use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Modules\Blog\Admin\BlogCategoryResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Blog\Models\BlogCategory;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Blog');
    }

    public static function getModelLabel(): string
    {
        return __('Blog category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blog categories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Schema::getReactiveName(),
                    Schema::getSlug(),
                    Schema::getStatus(),
                    Schema::getSorting(),
                    Schema::getImage('image', isMultiple: false),
                ])
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableSchema::getName(),
                TableSchema::getStatus(),
                TableSchema::getSorting(),
                TableSchema::getViews(),
                TableSchema::getUpdatedAt()
            ])
            ->reorderable('sorting')
            ->filters([
                TableSchema::getFilterStatus(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}
