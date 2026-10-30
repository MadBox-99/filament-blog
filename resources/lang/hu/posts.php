<?php

declare(strict_types=1);

return [
    'navigation_group' => 'Blog',
    'navigation_label' => 'Blogbejegyzések',
    'model_label' => 'Blogbejegyzés',
    'plural_model_label' => 'Blogbejegyzések',
    'sections' => [
        'content' => 'Tartalom',
        'publishing' => 'Közzététel',
        'image' => 'Kép',
    ],
    'fields' => [
        'title' => 'Cím',
        'slug' => 'URL-azonosító',
        'excerpt' => 'Kivonat',
        'content' => 'Tartalom',
        'is_published' => 'Publikált',
        'published_at' => 'Megjelenés dátuma',
        'category' => 'Kategória',
        'category_name' => 'Név',
        'category_slug' => 'URL-azonosító',
        'author' => 'Szerző',
        'featured_image' => 'Kiemelt kép',
    ],
    'columns' => [
        'featured_image' => 'Kép',
        'title' => 'Cím',
        'category' => 'Kategória',
        'author' => 'Szerző',
        'is_published' => 'Publikált',
        'published_at' => 'Megjelent',
        'created_at' => 'Létrehozva',
    ],
    'filters' => [
        'category' => 'Kategória',
        'is_published' => 'Publikált',
    ],
];
