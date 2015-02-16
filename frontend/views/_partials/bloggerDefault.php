<?php use yii\helpers\Html; ?>
<h2><?= Html::a(Html::encode($blogger->name), $blogger->url); ?></h2>
<div class="row">
    <?= Html::img($blogger->getImage('200x200')); ?>
</div>
<div class="row">
    <p><?= $blogger->short_description ?></p>
</div>
<div class="clearfix"></div>
<a
    class="btn btn-primary media"
    href="<?= Yii::$app->urlManager->createUrl($blogger->url) ?>"
>View Blogger <span class="glyphicon glyphicon-chevron-right"></span></a>
<hr />