<?php
use yii\grid\GridView;
?>
<div class="site-index">
    <div>
        <h1>Tags Management</h1>
        <p class="lead">Create, View, Update, and Delete Tags.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createTagUrl ?>">Create a new Tag</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $tagsDataProvider
                ])
            ); ?>
        </div>
    </div>
</div>