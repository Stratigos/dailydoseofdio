<?php use yii\widgets\LinkPager; ?>
<?php use yii\helpers\Html; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $blog->title; ?></h1>
            <?= Html::img($blog->getImage('200x200')); ?>
            <p><b>Description:</b>&nbsp;<?= $blog->description; ?> </p>
        </div>
        <div class="container">
            <?php if($posts = $postsDP->getModels()): ?>
                <?php foreach($posts as $post): ?>
                    <?= $this->context->renderPartial(
                        '@frontend/views/_partials/postDefault.php',
                        ['post' => $post]
                    ); ?>
                <?php endforeach; ?>
                <?= LinkPager::widget(['pagination' => $postsDP->pagination]); ?>
            <?php else : ?>
                <p>No Posts found.</p>
            <?php endif;?>
        </div>
    </div>
</div>
