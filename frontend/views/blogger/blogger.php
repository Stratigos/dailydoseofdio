<?php use yii\widgets\LinkPager; ?>
<?php use yii\helpers\Html; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $blogger->name; ?></h1>
            <p><?= Html::img($blogger->getImage('500x500')); ?></p>
            <p><?= $blogger->description; ?></p>
            <p><b>Favorite Dio Track:</b>&nbsp;<i><?= $blogger->dio_favorite ?></i></p>
            <hr />
        </div>
        <div class="container">
            <h2>Doses from <?= $blogger->name ?></h2>
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
