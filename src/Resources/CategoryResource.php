<?php

namespace Madbox99\FilamentBlog\Resources;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Madbox99\FilamentBlog\Models\Category;
use Madbox99\FilamentBlog\Resources\CategoryResource\Pages;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = 2;

    #[\Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return static::$navigationGroup ?? __('filament-blog::categories.navigation_group');
    }

    #[\Override]
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? __('filament-blog::categories.navigation_label');
    }

    #[\Override]
    public static function getModelLabel(): string
    {
        return static::$modelLabel ?? __('filament-blog::categories.model_label');
    }

    #[\Override]
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ?? __('filament-blog::categories.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-blog::categories.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? ''))),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('filament-blog::categories.fields.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('filament-blog::categories.fields.is_active'))
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('filament-blog::categories.fields.sort_order'))
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-blog::categories.columns.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('filament-blog::categories.columns.slug')),
                Tables\Columns\TextColumn::make('posts_count')
                    ->label(__('filament-blog::categories.columns.posts_count'))
                    ->counts('posts'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('filament-blog::categories.columns.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-blog::categories.columns.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
