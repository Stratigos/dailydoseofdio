<?php use yii\widgets\LinkPager; ?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">Dose Archives</h1>
            <?php if(isset($posts) && !empty($posts)) :?>
                <?php foreach($posts as $post) : ?>
                    <?= $this->context->renderPartial(
                        '@frontend/views/_partials/postDefault.php',
                        ['model' => $post]
                    ); ?>
                <?php endforeach; ?>
                <?= LinkPager::widget(['pagination' => $pagination]); ?>
            <?php else : ?>
                <p>No Posts found.</p>
            <?php endif;?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">
            <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
        </div>
    </div>
    <hr>
</div>