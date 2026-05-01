<?php

namespace Madbox99\FilamentBlog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Madbox99\FilamentSeo\Models\SeoMeta;

class Post extends Model
{
    protected $guarded = [];

    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    #[\Override]
    public function getTable(): string
    {
        return config('filament-blog.table_names.posts', 'posts');
    }

    #[\Override]
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\\Models\\User'), 'author_id');
    }
}
