<?php use yii\helpers\Html; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h1><?= $post->title ?></h1>
            <?php if($post->blog) : ?>
                <h2><?= Html::a($post->blog->title, $post->blog->url); ?></h2>
            <?php endif; ?>
            <div class="post-meta">
                <?php if($post->blogger): ?>
                    <span class="post-byline">
                        by <?= Html::a($post->blogger->name, $post->blogger->url);?>
                    </span><span class="lt-grey"> | </span>
                <?php endif; ?>
                <span class="post-date">
                    <span class="glyphicon glyphicon-time"></span> <?= $date ?>
                </span>
            </div>            
            <hr />
            <div class="post-body"><?= $post->body ?></div>
            <hr />
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
            <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
        </div>
    </div>
</div>