<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'request' => ['cookieValidationKey' => 'ihaznoideawhatiamdoing'], // required for cookie validation
        'urlManager' => [
            'enablePrettyUrl'     => TRUE,
            'enableStrictParsing' => TRUE,
            'showScriptName'      => FALSE,
            'class'               => 'yii\web\UrlManager',
            /**
             * @todo MOVE URL RULES TO SOME KIND OF routes.php SCRIPT
             */
            'rules'               => [

                '/'                                      => 'site/index',
                'archives/<page:\d+>'                    => 'archive/index',
                'archives'                               => 'archive/index',
                'categories'                             => 'category/index',
                'category/<shortname:[\w-]+>'            => 'category/category',
                'category/<shortname:[\w-]+>/<page:\d+>' => 'category/category'
            ]
        ],
        //'user' => ['identityClass' => 'common\models\User'],
        'log'  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'params' => $params
];
