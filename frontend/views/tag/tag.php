<?php use yii\widgets\LinkPager; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header">Doses Tagged: <b><?= $tag->name; ?></b></h1>
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
