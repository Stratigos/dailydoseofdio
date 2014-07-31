<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
$this->title = 'DDOD Manage';
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Daily Dose of Dio: Management',
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],


            ]);
            $menuItems = [
                [
                    'label' => 'Home',
                    'url'   => ['/site/index']
                ],
                [
                    'label' => 'Content',
                    'items' => [
                        [
                            'label' => 'Posts',
                            'url'   => '#'
                        ],
                        [
                            'label' => 'Pages',
                            'url'   => '/index.php?r=page/index'
                        ],
                        [
                            'label' => 'Dio Sites',
                            'url'   => '/index.php?r=diosite/index'
                        ]
                    ]
                ],
                [
                    'label' => 'Taxonomy',
                    'items' => [
                        [
                            'label' => 'Blogs',
                            'url'   => '#'
                        ],
                        [
                            'label' => 'Bloggers',
                            'url'   => 'index.php?r=blogger/index'
                        ],
                        [
                            'label' => 'Categories',
                            'url'   => '/index.php?r=category/index'
                        ],
                        [
                            'label' => 'Tags',
                            'url'   => '/index.php?r=tag/index'
                        ]
                    ]
                ],
                [
                    'label' => 'Promotionals',
                    'items' => [
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Under Construction</li>'
                    ]
                ]
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Hello, ' . Yii::$app->user->identity->username,
                    'items' => [
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Cool Header Bro</li>',
                        [
                            'label' => 'Profile',
                            'url'   => '#'
                        ],
                        [
                            'label' => 'Some Crap',
                            'url'   => '#'
                        ],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Misc</li>',
                        [
                            'label' => 'Home',
                            'url'   => ['/site/index']
                        ],
                        [
                            'label'       => 'Logout',
                            'url'         => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ]
                    ]
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Todd <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
