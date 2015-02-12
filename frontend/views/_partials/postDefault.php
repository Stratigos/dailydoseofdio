<?php use yii\helpers\Html; ?>
<h2><?= Html::a(Html::encode($post->title), $post->url); ?></h2>
<p class="lead">
    by <a href="index.php"><?= $post->blogger? $post->blogger->name : 'Nobody Special'; ?></a>
</p>
<p><span class="glyphicon glyphicon-time"></span> <?= date('Y-m-d H:i:s', $post->published_at); ?></p>
<hr />
<div class="row">
    <div class="col-md-4 col-sm-4">
        <img class="img-responsive" src="http://placehold.it/250x155" alt="">
    </div>
    <div class="col-md-8 col-sm-8"><?= substr($post->body, 0, 200) . '...' ?><p></div>
</div>
<div class="clearfix"></div>
<a class="btn btn-primary media" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
<hr />
