<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
?>
<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Bloggers</p>
        </h1>
        <?= ListView::widget([
            'dataProvider' => $bloggersDP,
            'itemView'     => '@frontend/views/_partials/bloggerDefault.php',
            'emptyText'    => 'No Bloggers found.',
            'separator'    => Html::tag('hr'),
            'summary'      => ''
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
    </div>
</div>
