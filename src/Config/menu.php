<?php

return [

    /**
     * Blog.
     */
    [
        'key' => 'blog',
        'name' => 'Blog',
        'route' => 'admin.blog.index',
        'sort' => 3,
        // 'icon' => 'icon-blog',
        'icon' => 'icon-attribute',
    ], [
        'key'        => 'blog.blogs',
        'name'       => 'Blogs',
        'route'      => 'admin.blog.index',
        'sort'       => 1,
        'icon'       => '',
    ], [
        'key'        => 'blog.category',
        'name'       => 'Category',
        'route'      => 'admin.blog.category.index',
        'sort'       => 2,
        'icon'       => '',
    ], [
        'key'        => 'blog.tag',
        'name'       => 'Tag',
        'route'      => 'admin.blog.tag.index',
        'sort'       => 3,
        'icon'       => '',
    ], [
        'key'        => 'blog.comment',
        'name'       => 'Comment',
        'route'      => 'admin.blog.comment.index',
        'sort'       => 4,
        'icon'       => '',
    ], [
        'key'        => 'blog.setting',
        'name'       => 'Setting',
        'route'      => 'admin.blog.setting.index',
        'sort'       => 5,
        'icon'       => '',
    ],

];
