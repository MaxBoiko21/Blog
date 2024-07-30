<?php

namespace Modules\Blog\Admin;

use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Modules\Blog\Admin\BlogArticleResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Blog\Models\BlogArticle;

class BlogArticleResource extends Resource
{
    protected static ?string $model = BlogArticle::class;

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
        return __('Blog article');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blog articles');
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
                    Schema::getSelect('blog_category_id')->relationship('category', 'name'),
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
            'index' => Pages\ListBlogArticles::route('/'),
            'create' => Pages\CreateBlogArticle::route('/create'),
            'edit' => Pages\EditBlogArticle::route('/{record}/edit'),
        ];
    }
}
