<?php use yii\helpers\Html; ?>
<p class="lead post-partial-title"><a href="<?= $model->url ?>"><?= Html::encode($model->title) ?></a></p>
<p class="post-partial-byline-author">by 
    <a href="index.php"><?= $model->blogger? $model->blogger->name : 'Nobody Special'; ?></a>
</p>
<p class="post-partial-byline-pubdate">
    <span class="glyphicon glyphicon-time"></span> <?= date('Y-m-d H:i:s', $model->published_at); ?>
</p>
<hr />
<div class="row">
    <div class="col-md-5 col-sm-5">
        <?php if($model->image_path) : ?>
            <?= Html::img($model->getImage('250x155'), ['title' => "{$model->title} Thumbnail"]); ?>
        <?php else: ?>
            <img class="img-responsive" src="http://placehold.it/250x155" alt="">
        <?php endif; ?>
    </div>
    <p><?= $model->summary; ?></p>
</div>
<br />
<div class="control-group">
    <a
        class="btn btn-primary"
        href="<?= $model->url ?>"
    >Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
</div>