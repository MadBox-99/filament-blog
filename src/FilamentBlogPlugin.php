<?php

namespace Madbox99\FilamentBlog;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Madbox99\FilamentBlog\Resources\CategoryResource;
use Madbox99\FilamentBlog\Resources\PostResource;

class FilamentBlogPlugin implements Plugin
{
    protected ?string $navigationGroup = 'Blog';

    protected ?int $navigationSort = 1;

    public function getId(): string
    {
        return 'filament-blog';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function navigationGroup(?string $group): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function navigationSort(?int $sort): static
    {
        $this->navigationSort = $sort;

        return $this;
    }

    public function getNavigationGroup(): ?string
    {
        return $this->navigationGroup;
    }

    public function getNavigationSort(): ?int
    {
        return $this->navigationSort;
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            PostResource::class,
            CategoryResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
