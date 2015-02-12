<?php use yii\helpers\Html; ?>
<h2><?= Html::a(Html::encode($blog->title), $blog->url); ?></h2>
<div class="row">
    <?= Html::img($blog->getImage('200x200')); ?>
</div>
<div class="row">
    <p><?= $blog->short_description ?></p>
</div>
<div class="clearfix"></div>
<a
    class="btn btn-primary media"
    href="<?= Yii::$app->urlManager->createUrl(['blog/blog', 'shortname' => $blog->shortname]) ?>"
>Read Blog <span class="glyphicon glyphicon-chevron-right"></span></a>
<hr />