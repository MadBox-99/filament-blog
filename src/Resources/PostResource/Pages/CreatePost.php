<?php

namespace Madbox99\FilamentBlog\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Madbox99\FilamentBlog\Resources\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
