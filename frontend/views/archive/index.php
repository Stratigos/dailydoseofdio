<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-header">Dose Archives</h1>
            <?= ListView::widget([
                'dataProvider' => $postsDP,
                'itemView'     => '@frontend/views/_partials/postDefault.php',
                'emptyText'    => 'No Doses found.',
                'separator'    => Html::tag('hr'),
                'summary'      => ''
            ]); ?>
        </div>
        <div class="col-md-4">
            <?= $this->context->renderPartial('@frontend/views/_partials/sidebar.php'); ?>
        </div>
    </div>
    <hr />
</div>