<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
if(empty($this->title)) {
    $this->title = Yii::$app->params['defaultTitle'] . ' *BETA*';
}

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>
    <?php $this->beginBody(); ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->params['defaultTitle'] . ' *BETA*',
                'brandUrl'   => Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top'
                ]
            ]);
            $menuItems = [
                [
                    'label' => 'Genres',
                    'url'   => Yii::$app->urlManager->createUrl('categories'),
                    'items' => [
                        [
                            'label' => 'Rainbow',
                            'url'   => Yii::$app->urlManager->createUrl('category/rainbow')
                        ],
                        [
                            'label' => 'Black Sabbath',
                            'url'   => Yii::$app->urlManager->createUrl('category/black-sabbath')
                        ],
                        [
                            'label' => 'Dio',
                            'url'   => Yii::$app->urlManager->createUrl('category/dio')
                        ]
                    ]
                ],
                ['label' => 'Anthems', 'url' => ['/blogs']],
                ['label' => 'Bards',   'url' => ['/bloggers']],
                ['label' => 'Odes',    'url' => ['/about']]
            ];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items'   => $menuItems
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
            ]); ?>
            <?= Alert::widget(); ?>
            <?= $content; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Todd Morningstar, 2014-2015</p>
        </div>
    </footer>

    <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>