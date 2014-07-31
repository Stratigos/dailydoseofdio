<?php
use yii\grid\GridView;
?>
<div class="category-index">
    <div>
        <h1>Bloggers Management</h1>
        <p class="lead">Create, Update, and Delete Bloggers.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createBloggerUrl ?>">Create a new Blogger</a></p>
        </div>
        <div>
            <p><em>Note: at this time, images are unavailable.</em></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $bloggersDataProvider,
                    'columns'      => [
                        'id',
                        'name',
                        'shortname',
                        // image file upload ...
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
                        'dio_favorite',
                        'rank',
                        'status',
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