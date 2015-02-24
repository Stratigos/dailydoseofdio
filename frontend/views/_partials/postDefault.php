<?php use yii\helpers\Html; ?>
<p class="lead"><?= Html::a(Html::encode($model->title), $model->url); ?></p>
<p>by <a href="index.php"><?= $model->blogger? $model->blogger->name : 'Nobody Special'; ?></a></p>
<p><span class="glyphicon glyphicon-time"></span> <?= date('Y-m-d H:i:s', $model->published_at); ?></p>
<hr />
<div class="row">
    <div class="col-md-4 col-sm-4">
        <?php if($model->image_path) : ?>
            <?= Html::img($model->getImage('250x155'), ['title' => "{$model->title} Thumbnail"]); ?>
        <?php else: ?>
            <img class="img-responsive" src="http://placehold.it/250x155" alt="">
        <?php endif; ?>
    </div>
    <div class="col-md-8 col-sm-8"><?= $model->summary; ?><p></div>
</div>
<div class="clearfix"></div>
<a class="btn btn-primary media" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>