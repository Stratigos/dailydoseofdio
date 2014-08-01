<?php
use yii\grid\GridView;
?>
<div class="blog-index">
    <div>
        <h1>Blog Management</h1>
        <p class="lead">Create, Update, and Delete Blog.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createBlogUrl ?>">Create a new Blog</a></p>
        </div>
        <div>
            <p><em>Note: at this time, images are unavailable.</em></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $blogDataProvider,
                    'columns'      => [
                        'id',
                        'title',
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
                        [
                            'label' => 'Meta Keywords',
                            'value' => function($data) {
                                return empty($data->keywords) ? '' : substr($data->keywords, 0, 50);
                            }
                        ],
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
