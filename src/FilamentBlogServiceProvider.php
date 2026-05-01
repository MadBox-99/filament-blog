<?php

declare(strict_types=1);

namespace Madbox99\FilamentBlog;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentBlogServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-blog';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->discoversMigrations()
            ->runsMigrations();
    }
}
