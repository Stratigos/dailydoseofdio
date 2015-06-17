<?php use yii\helpers\Html; ?>
<h2><?= Html::a(Html::encode($model->name), $model->url); ?></h2>
<div>
    <?= Html::img($model->getImage('200x200')); ?>
</div>
<div>
    <p><?= $model->short_description ?></p>
</div>
<div class="clearfix"></div>
<a
    class="btn btn-primary media"
    href="<?= Yii::$app->urlManager->createUrl($model->url) ?>"
>View Blogger <span class="glyphicon glyphicon-chevron-right"></span></a>
