<?php

declare(strict_types=1);

namespace Madbox99\FilamentBlog\Tests\Fixtures;

use Madbox99\FilamentBlog\Resources\CategoryResource;

/**
 * A site's subclass that names the resource itself, as apps using the package do.
 */
class SiteCategoryResource extends CategoryResource
{
    protected static ?string $navigationLabel = 'Topics';

    protected static ?string $modelLabel = 'Topic';

    protected static ?string $pluralModelLabel = 'Topics';
}
