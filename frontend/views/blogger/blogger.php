<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ListView; ?>
<div class="container">
    <div class="col-md-8">
        <div class="container">
            <h1 class="page-header"><?= $blogger->name; ?></h1>
            <p><?= Html::img($blogger->getImage('500x500')); ?></p>
            <p><?= $blogger->description; ?></p>
            <p><b>Favorite Dio Track:</b>&nbsp;<i><?= $blogger->dio_favorite ?></i></p>
            <hr />
        </div>
        <?= ListView::widget([
            'dataProvider' => $postsDP,
            'itemView'     => '@frontend/views/_partials/postDefault.php',
            'emptyText'    => "No Doses found from {$blogger->name}.",
            'separator'    => Html::tag('hr'),
            'summary'      => "<h2>Doses from {$blogger->name}</h2>"
        ]); ?>
    </div>
</div>
