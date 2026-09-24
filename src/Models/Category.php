<?php

namespace Madbox99\FilamentBlog\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Lásd a {@see Post} megjegyzését: a táblanév `config()`-ból jön, ezért kell
 * felsorolni az oszlopokat.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property int $sort_order
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 */
class Category extends Model
{
    protected $guarded = [];

    #[\Override]
    public function getTable(): string
    {
        return config('filament-blog.table_names.categories', 'categories');
    }

    #[\Override]
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /** @return HasMany<Post, $this> */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
