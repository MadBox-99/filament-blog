<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Madbox99\FilamentBlog\Resources\CategoryResource;
use Madbox99\FilamentBlog\Resources\CategoryResource\Pages\CreateCategory;
use Madbox99\FilamentBlog\Resources\CategoryResource\Pages\ListCategories;
use Madbox99\FilamentBlog\Resources\PostResource;
use Madbox99\FilamentBlog\Resources\PostResource\Pages\CreatePost;
use Madbox99\FilamentBlog\Resources\PostResource\Pages\ListPosts;
use Madbox99\FilamentBlog\Tests\Fixtures\SiteCategoryResource;

use function Pest\Livewire\livewire;

it('labels the resources in english by default', function (): void {
    expect(PostResource::getNavigationLabel())->toBe('Posts')
        ->and(PostResource::getModelLabel())->toBe('Post')
        ->and(PostResource::getPluralModelLabel())->toBe('Posts')
        ->and(PostResource::getNavigationGroup())->toBe('Blog')
        ->and(CategoryResource::getNavigationLabel())->toBe('Categories')
        ->and(CategoryResource::getModelLabel())->toBe('Category');

    livewire(CreatePost::class)
        ->assertSee('Publishing')
        ->assertSee('Featured Image')
        ->assertSee('Publish Date');
});

it('translates the post screens into hungarian', function (): void {
    app()->setLocale('hu');

    expect(PostResource::getNavigationLabel())->toBe('Blogbejegyzések')
        ->and(PostResource::getModelLabel())->toBe('Blogbejegyzés')
        ->and(PostResource::getPluralModelLabel())->toBe('Blogbejegyzések');

    livewire(ListPosts::class)
        ->assertSee('Cím')
        ->assertSee('Szerző')
        ->assertSee('Megjelent');

    livewire(CreatePost::class)
        ->assertSee('Tartalom')
        ->assertSee('Közzététel')
        ->assertSee('Megjelenés dátuma')
        ->assertSee('Kiemelt kép')
        ->assertDontSee('Publishing');
});

it('translates the category screens into hungarian', function (): void {
    app()->setLocale('hu');

    expect(CategoryResource::getNavigationLabel())->toBe('Blogkategóriák')
        ->and(CategoryResource::getModelLabel())->toBe('Blogkategória')
        ->and(CategoryResource::getPluralModelLabel())->toBe('Blogkategóriák');

    livewire(ListCategories::class)
        ->assertSee('Név')
        ->assertSee('Bejegyzések')
        ->assertSee('Aktív');

    livewire(CreateCategory::class)
        ->assertSee('URL-azonosító')
        ->assertSee('Sorrend');
});

it('keeps labels a subclass sets on its static properties', function (): void {
    app()->setLocale('hu');

    expect(SiteCategoryResource::getNavigationLabel())->toBe('Topics')
        ->and(SiteCategoryResource::getModelLabel())->toBe('Topic')
        ->and(SiteCategoryResource::getPluralModelLabel())->toBe('Topics')
        ->and(SiteCategoryResource::getNavigationGroup())->toBe('Blog');
});

it('has the same keys in every package language file', function (string $file): void {
    $flatten = fn (array $lines): array => array_keys(Arr::dot($lines));

    expect($flatten(require __DIR__."/../../resources/lang/hu/{$file}.php"))
        ->toBe($flatten(require __DIR__."/../../resources/lang/en/{$file}.php"));
})->with(['posts', 'categories']);
