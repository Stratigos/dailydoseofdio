<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ListView; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $blog->title; ?></h1>
            <?= Html::img($blog->getImage('200x200')); ?>
            <p><b>Description:</b>&nbsp;<?= $blog->description; ?> </p>
        </div>
        <?= ListView::widget([
            'dataProvider' => $postsDP,
            'itemView'     => '@frontend/views/_partials/postDefault.php',
            'emptyText'    => "No Doses found for {$blog->title}.",
            'separator'    => Html::tag('hr'),
            'summary'      => 'Doses of Dio found in this Blog'
        ]); ?>
    </div>
</div>
