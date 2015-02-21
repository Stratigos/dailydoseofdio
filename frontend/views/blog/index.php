<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ListView; ?>
<div class="container">
    <div class="col-md-8">
        <h1 class="page-header">
            <p>Blogs</p>
        </h1>
        <?= ListView::widget([
            'dataProvider' => $blogsDP,
            'itemView'     => '@frontend/views/_partials/blogDefault.php',
            'emptyText'    => 'No Blogs found.',
            'separator'    => Html::tag('hr'),
            'summary'      => ''
        ]); ?>
    </div>
</div>
