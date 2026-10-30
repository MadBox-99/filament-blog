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
use Madbox99\FilamentBlog\Models\Post;
use Madbox99\FilamentBlog\Resources\PostResource\Pages;
use Madbox99\FilamentSeo\Forms\SeoFields;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    #[\Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return static::$navigationGroup ?? __('filament-blog::posts.navigation_group');
    }

    #[\Override]
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? __('filament-blog::posts.navigation_label');
    }

    #[\Override]
    public static function getModelLabel(): string
    {
        return static::$modelLabel ?? __('filament-blog::posts.model_label');
    }

    #[\Override]
    public static function getPluralModelLabel(): string
    {
        return static::$pluralModelLabel ?? __('filament-blog::posts.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make(__('filament-blog::posts.sections.content'))
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label(__('filament-blog::posts.fields.title'))
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? ''))),
                                Forms\Components\TextInput::make('slug')
                                    ->label(__('filament-blog::posts.fields.slug'))
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Textarea::make('excerpt')
                                    ->label(__('filament-blog::posts.fields.excerpt'))
                                    ->rows(3)
                                    ->maxLength(500),
                                Forms\Components\RichEditor::make('content')
                                    ->label(__('filament-blog::posts.fields.content'))
                                    ->columnSpanFull(),
                            ]),
                        ...static::seoFields(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Schemas\Components\Group::make()
                    ->schema([
                        Schemas\Components\Section::make(__('filament-blog::posts.sections.publishing'))
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label(__('filament-blog::posts.fields.is_published'))
                                    ->default(false),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label(__('filament-blog::posts.fields.published_at')),
                                Forms\Components\Select::make('category_id')
                                    ->label(__('filament-blog::posts.fields.category'))
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('filament-blog::posts.fields.category_name'))
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('filament-blog::posts.fields.category_slug'))
                                            ->required(),
                                    ]),
                                Forms\Components\Select::make('author_id')
                                    ->label(__('filament-blog::posts.fields.author'))
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->default(auth()->id()),
                            ]),
                        Schemas\Components\Section::make(__('filament-blog::posts.sections.image'))
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label(__('filament-blog::posts.fields.featured_image'))
                                    ->image()
                                    ->directory('blog')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    /** @return array<Forms\Components\Component> */
    protected static function seoFields(): array
    {
        if (class_exists(SeoFields::class)) {
            return [SeoFields::make()];
        }

        return [];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label(__('filament-blog::posts.columns.featured_image'))
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament-blog::posts.columns.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('filament-blog::posts.columns.category'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('filament-blog::posts.columns.author'))
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label(__('filament-blog::posts.columns.is_published'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('filament-blog::posts.columns.published_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament-blog::posts.columns.created_at'))
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label(__('filament-blog::posts.filters.category')),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label(__('filament-blog::posts.filters.is_published')),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
