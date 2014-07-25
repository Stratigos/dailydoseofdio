<?php
use yii\grid\GridView;
?>
<div class="diosite-index">
    <div>
        <h1>DioSites Management</h1>
        <p class="lead">Create, View, Update, and Delete Dio-Sites.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createDioSiteUrl ?>">Create a new Dio-Site</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $dioSitesDataProvider,
                    'columns'      => [
                        'id',
                        'url',
                        'title',
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