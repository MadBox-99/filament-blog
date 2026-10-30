<?php

declare(strict_types=1);

return [
    'navigation_group' => 'Blog',
    'navigation_label' => 'Posts',
    'model_label' => 'Post',
    'plural_model_label' => 'Posts',
    'sections' => [
        'content' => 'Content',
        'publishing' => 'Publishing',
        'image' => 'Image',
    ],
    'fields' => [
        'title' => 'Title',
        'slug' => 'URL Slug',
        'excerpt' => 'Excerpt',
        'content' => 'Content',
        'is_published' => 'Published',
        'published_at' => 'Publish Date',
        'category' => 'Category',
        'category_name' => 'Name',
        'category_slug' => 'Slug',
        'author' => 'Author',
        'featured_image' => 'Featured Image',
    ],
    'columns' => [
        'featured_image' => 'Image',
        'title' => 'Title',
        'category' => 'Category',
        'author' => 'Author',
        'is_published' => 'Published',
        'published_at' => 'Published At',
        'created_at' => 'Created',
    ],
    'filters' => [
        'category' => 'Category',
        'is_published' => 'Published',
    ],
];
