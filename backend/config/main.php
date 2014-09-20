<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ihavenoideawhatiamdoing',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => TRUE,
            //'enableStrictParsing' => TRUE,
            'showScriptName'      => FALSE,
            'class'               => 'yii\web\UrlManager',
            // 'rules'               => [
            //     // [
            //     //     'class'      => 'yii\rest\UrlRule',
            //     //     'controller' => 'user'
            //     // ]
            //     //'site/index' => 'index.php?r=site/index'
            // ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'params' => $params
];
