<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ListView; ?>
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
</div>
