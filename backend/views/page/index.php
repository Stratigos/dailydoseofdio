<?php
use yii\grid\GridView;
?>
<div class="page-index">
    <div>
        <h1>Pages Management</h1>
        <p class="lead">Create, Update, and Delete Pages.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createPageUrl ?>">Create a new Page</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $pagesDataProvider,
                    'columns'      => [
                        'id',
                        'title',
                        'shortname',
                        [
                            'label' => 'Body',
                            'value' => function($data) {
                                return empty($data->body) ? '' : substr(strip_tags($data->body), 0, 50);
                            }
                        ],
                        [
                            'label' => 'Created',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function($data) {
                                return date('Y-m-d H:i:s', $data->created_at);
                            }
                        ],
                        [
                            'label' => 'Updated',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function($data) {
                                return date('Y-m-d H:i:s', $data->updated_at);
                            }
                        ],
                        [
                            'class'    => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}'
                        ]
                    ]
                ])
            ); ?>
        </div>
    </div>
</div>