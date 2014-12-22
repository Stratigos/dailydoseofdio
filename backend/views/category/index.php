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
                        [
                            'label' => 'Short Description',
                            'value' => function($data) {
                                return empty($data->short_description) ? '' : substr($data->short_description, 0, 50);
                            }
                        ],
                        [
                            'label' => 'Description',
                            'value' => function($data) {
                                return empty($data->description) ? '' : substr($data->description, 0, 50);
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
                        ['class' => 'yii\grid\ActionColumn']
                    ]
                ])
            ); ?>
        </div>
    </div>
</div>