<?php

namespace Modules\Blog\Admin;

use App\Filament\Resources\TranslateResource\RelationManagers\TranslatableRelationManager;
use App\Models\Setting;
use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Modules\Blog\Admin\BlogCategoryResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\Models\BlogCategory;
use Modules\Seo\Admin\SeoResource\Pages\SeoRelationManager;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::query()->withoutGlobalScopes()->count();
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
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
            ->headerActions([
                Action::make(__('Help'))
                    ->iconButton()
                    ->icon('heroicon-o-question-mark-circle')
                    ->modalDescription(__('Here you can manage blog categories. Blog categories are used to group blog articles. You can create, edit and delete blog categories as you want. Blog category will be displayed on the blog page or inside slider(modules section). If you want to disable it, you can do it by changing the status of the blog category.'))
                    ->modalFooterActions([]),

            ])
            ->reorderable('sorting')
            ->filters([
                TableSchema::getFilterStatus(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('View')
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
                            'template' => setting(config('settings.blog.category.template'), []),
                            'design' => setting(config('settings.blog.category.design'), 'Zero')
                        ];
                    })
                    ->action(function (array $data): void {
                        setting([
                            config('settings.blog.category.template') => $data['template'],
                            config('settings.blog.category.design') => $data['design']
                        ]);
                        Setting::updatedSettings();
                    })
                    ->form(function ($form) {
                        return $form
                            ->schema([
                                Schema::getModuleTemplateSelect('Pages/BlogCategory'),
                                Section::make('')->schema([
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
