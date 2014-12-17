<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'console\controllers',
    'modules'             => [],
    'components'          => [
        'authManager' => [
            'class'          => 'yii\rbac\PhpManager',
            'assignmentFile' => '@backend/rbac/assignments.php',
            'itemFile'       => '@backend/rbac/items.php',
            'ruleFile'       => '@backend/rbac/rules.php'
        ],
        'log' => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => $params
];
