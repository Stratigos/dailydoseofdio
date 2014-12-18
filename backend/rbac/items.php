<?php
return [
    'createBlog' => [
        'type' => 2,
        'description' => 'Create Blog',
    ],
    'updateBlog' => [
        'type' => 2,
        'description' => 'Update Blog',
    ],
    'viewBlog' => [
        'type' => 2,
        'description' => 'View Blog',
    ],
    'deleteBlog' => [
        'type' => 2,
        'description' => 'Delete Blog',
    ],
    'createBlogger' => [
        'type' => 2,
        'description' => 'Create Blogger',
    ],
    'updateBlogger' => [
        'type' => 2,
        'description' => 'Update Blogger',
    ],
    'viewBlogger' => [
        'type' => 2,
        'description' => 'View Blogger',
    ],
    'deleteBlogger' => [
        'type' => 2,
        'description' => 'Delete Blogger',
    ],
    'createCategory' => [
        'type' => 2,
        'description' => 'Create Category',
    ],
    'updateCategory' => [
        'type' => 2,
        'description' => 'Update Category',
    ],
    'viewCategory' => [
        'type' => 2,
        'description' => 'View Category',
    ],
    'deleteCategory' => [
        'type' => 2,
        'description' => 'Delete Category',
    ],
    'createTag' => [
        'type' => 2,
        'description' => 'Create Tag',
    ],
    'updateTag' => [
        'type' => 2,
        'description' => 'Update Tag',
    ],
    'viewTag' => [
        'type' => 2,
        'description' => 'View Tag',
    ],
    'deleteTag' => [
        'type' => 2,
        'description' => 'Delete Tag',
    ],
    'createPost' => [
        'type' => 2,
        'description' => 'Create Post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update Post',
    ],
    'viewPost' => [
        'type' => 2,
        'description' => 'View Post',
    ],
    'deletePost' => [
        'type' => 2,
        'description' => 'Delete Post',
    ],
    'createPage' => [
        'type' => 2,
        'description' => 'Create Page',
    ],
    'updatePage' => [
        'type' => 2,
        'description' => 'Update Page',
    ],
    'viewPage' => [
        'type' => 2,
        'description' => 'View Page',
    ],
    'deletePage' => [
        'type' => 2,
        'description' => 'Delete Page',
    ],
    'createDioSite' => [
        'type' => 2,
        'description' => 'Create DioSite',
    ],
    'updateDioSite' => [
        'type' => 2,
        'description' => 'Update DioSite',
    ],
    'viewDioSite' => [
        'type' => 2,
        'description' => 'View DioSite',
    ],
    'deleteDioSite' => [
        'type' => 2,
        'description' => 'Delete DioSite',
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'createPost',
            'updatePost',
            'viewPost',
            'deletePost',
            'createDioSite',
            'updateDioSite',
            'viewDioSite',
            'deleteDioSite',
            'viewPage',
            'viewBlog',
            'viewBlogger',
            'viewCategory',
            'createTag',
            'viewTag',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'author',
            'createPage',
            'updatePage',
            'deletePost',
            'createBlog',
            'updateBlog',
            'deleteBlog',
            'createBlogger',
            'updateBlogger',
            'deleteBlogger',
            'createCategory',
            'updateCategory',
            'deleteCategory',
            'updateTag',
            'deleteTag',
        ],
    ],
];
