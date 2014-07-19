<?php
use yii\grid\GridView;
?>
<div class="category-index">
    <div>
        <h1>Categories Management</h1>
        <p class="lead">Create, View, Update, and Delete Categories.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createCategoryUrl ?>">Create a new Category</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $categoriesDataProvider,
                    'columns'      => [
                        'id',
                        'name',
                        'shortname',
                        'short_description',
                        'description',
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
                            'class'   => 'yii\grid\ActionColumn',
                            'buttons' => []
                        ]
                    ]
                ])
            ); ?>
        </div>
    </div>
</div>