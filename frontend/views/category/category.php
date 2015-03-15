<?php
    use yii\widgets\ListView;
    use yii\helpers\Html;
?>
<div class="container">
    <div class="col-md-8">
        <div>
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
    <div class="col-md-4">
        <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
    </div>
</div>
