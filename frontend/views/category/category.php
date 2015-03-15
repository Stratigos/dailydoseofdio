<?php use yii\widgets\LinkPager; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $category->name; ?></h1>
            <p><b>Description:</b>&nbsp;<?= $category->description; ?> </p>
        </div>
        <div class="container">
            <?php if($posts = $postsDP->getModels()): ?>
                <?php foreach($posts as $post): ?>
                    <?= $this->context->renderPartial(
                        '@frontend/views/_partials/postDefault.php',
                        ['model' => $post]
                    ); ?>
                <?php endforeach; ?>
                <?= LinkPager::widget(['pagination' => $postsDP->pagination]); ?>
            <?php else : ?>
                <p>No Posts found.</p>
            <?php endif;?>
        </div>
    </div>
</div>
