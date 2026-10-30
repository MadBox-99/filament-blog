<?php

declare(strict_types=1);

return [
    'navigation_group' => 'Blog',
    'navigation_label' => 'Categories',
    'model_label' => 'Category',
    'plural_model_label' => 'Categories',
    'fields' => [
        'name' => 'Name',
        'slug' => 'URL Slug',
        'is_active' => 'Active',
        'sort_order' => 'Sort Order',
    ],
    'columns' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'posts_count' => 'Posts',
        'is_active' => 'Active',
        'created_at' => 'Created',
    ],
];
