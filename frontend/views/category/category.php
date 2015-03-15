<?php use yii\widgets\LinkPager; ?>
<?php use yii\widgets\ListView; ?>
<?php use yii\helpers\Html; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $category->name; ?></h1>
            <p><b>Description:</b>&nbsp;<?= $category->description; ?> </p>
        </div>
        <?= ListView::widget([
            'dataProvider' => $postsDP,
            'itemView'     => '@frontend/views/_partials/postDefault.php',
            'emptyText'    => "No Doses found for {$category->name}.",
            'separator'    => Html::tag('hr'),
            'summary'      => ''
        ]); ?>
    </div>
</div>
