<?php
return [
    'updatePost' => [
        'type' => 2,
        'description' => 'Update Post',
    ],
    'updateOwnPost' => [
        'type' => 2,
        'description' => 'Update Own Post',
        'ruleName' => 'isAuthor',
        'children' => [
            'updatePost',
        ],
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'updateOwnPost',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'author',
            'updatePost',
        ],
    ],
];
