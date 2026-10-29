<?php

declare(strict_types=1);

return [
    'navigation_group' => 'Blog',
    'navigation_label' => 'Blogkategóriák',
    'model_label' => 'Blogkategória',
    'plural_model_label' => 'Blogkategóriák',
    'fields' => [
        'name' => 'Név',
        'slug' => 'URL-azonosító',
        'is_active' => 'Aktív',
        'sort_order' => 'Sorrend',
    ],
    'columns' => [
        'name' => 'Név',
        'slug' => 'URL-azonosító',
        'posts_count' => 'Bejegyzések',
        'is_active' => 'Aktív',
        'created_at' => 'Létrehozva',
    ],
];
