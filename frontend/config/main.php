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
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'class'               => 'yii\web\UrlManager',
            /**
             * @todo MOVE URL RULES TO SOME KIND OF routes.php SCRIPT
             */
            'rules'               => [
                '/'                                      => 'site/index',
                'archives/<page:\d+>'                    => 'archive/index',
                'blogs'                                  => 'blog/index',
                'blog/<shortname:[\w-]+>'                => 'blog/blog',
                'blog/<shortname:[\w-]+>/<page:\d+>'     => 'blog/blog',
                'bloggers'                               => 'blogger/index',
                'blogger/<shortname:[\w-]+>'             => 'blogger/blogger',
                'blogger/<shortname:[\w-]+>/<page:\d+>'  => 'blogger/blogger',
                'categories'                             => 'category/index',
                'category/<shortname:[\w-]+>'            => 'category/category',
                'category/<shortname:[\w-]+>/<page:\d+>' => 'category/category',
                'tag/<shortname:[\w-]+>'                 => 'tag/tag',
                'tag/<shortname:[\w-]+>/<page:\d+>'      => 'tag/tag',
                // Pages (custom URLs with no controller name in path)
                [
                    'pattern'  => 'about',
                    'route'    => 'page/page',
                    'defaults' => ['shortname' => 'about']
                ]
            ]
        ],
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
