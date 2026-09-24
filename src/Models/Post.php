<?php

namespace Madbox99\FilamentBlog\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Madbox99\FilamentSeo\Models\SeoMeta;

/**
 * A táblanév `config()`-ból jön, amit a statikus elemzés nem tud feloldani:
 * a migrációból így egyetlen oszlopot sem ismer fel. Ezért sorolja fel őket
 * ez a blokk — enélkül a csomagot használó alkalmazásban minden mezőre
 * „undefined property" jön.
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $author_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $content
 * @property string|null $featured_image
 * @property bool $is_published
 * @property CarbonInterface|null $published_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 */
class Post extends Model
{
    protected $guarded = [];

    /** @return MorphOne<SeoMeta, $this> */
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

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A szerző modellje az alkalmazás `auth` beállításából jön, ezért csak az
     * ősosztálya nevezhető meg itt.
     *
     * @return BelongsTo<Model, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', 'App\\Models\\User'), 'author_id');
    }
}
