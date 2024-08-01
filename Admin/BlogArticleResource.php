<?php

namespace Modules\Blog\Admin;

use App\Filament\Resources\TranslateResource\RelationManagers\TranslatableRelationManager;
use App\Models\Setting;
use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Modules\Blog\Admin\BlogArticleResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Models\BlogArticle;
use Modules\Blog\Models\BlogCategory;
use Modules\Seo\Admin\SeoResource\Pages\SeoRelationManager;

class BlogArticleResource extends Resource
{
    protected static ?string $model = BlogArticle::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()->withoutGlobalScopes()->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
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
                SelectFilter::make('blog_category_id')
                    ->label(__('Blog category'))
                    ->options(BlogCategory::pluck('name', 'id')->toArray())
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('View')
                    ->label(__('View'))
                    ->icon('heroicon-o-eye')
                    ->url(function ($record) {
                        return $record->route();
                    })->openUrlInNewTab(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Template')
                    ->slideOver()
                    ->icon('heroicon-o-cog')
                    ->fillForm(function (): array {
                        return [
                            'template' => setting(config('settings.blog.article.template'),[]),
                            'design' => setting(config('settings.blog.article.design'),'Zero')
                        ];
                    })
                    ->action(function (array $data): void {
                        setting([
                            config('settings.blog.article.template') => $data['template'],
                            config('settings.blog.article.design') => $data['design']
                        ]);
                        Setting::updatedSettings();
                    })
                    ->form(function ($form) {
                        return $form
                            ->schema([
                                Section::make('')->schema([
                                    Schema::getModuleTemplateSelect('Pages/BlogArticle'),
                                    Schema::getTemplateBuilder()->label(__('Template')),
                                ]),
                            ]);
                    })
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
            RelationGroup::make('Seo and translates', [
                TranslatableRelationManager::class,
                SeoRelationManager::class,
            ]),
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
