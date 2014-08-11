<?php
use yii\grid\GridView;
use common\models\Post;
?>
<div class="post-index">
    <div>
        <h1>Posts Management</h1>
        <p class="lead">Create, View, Update, and Delete Posts.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createPostUrl ?>">Create a new Post</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $postsDataProvider,
                    'columns'      => [
                        'id',
                        [
                            'label' => 'Title',
                            'value' => function($data) {
                                return substr($data->title, 0, 50);
                            }
                        ],
                        [
                            'label' => 'Publish Date',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function($data) {
                                return date('Y-m-d H:i:s', $data->published_at);
                            }
                        ],
                        [
                            'label' => 'Status',
                            'value' => function($data) {
                                // the following is a case where multiple return statements makes
                                //  more sense than a single return of an assigned property
                                if($data->status == Post::STATUS_DRAFT) {
                                    return 'Draft';
                                } else if($data->status == Post::STATUS_PUBLISHED) {
                                    return 'Published';
                                }
                                return 'Invalid';
                            }
                        ],
                        // TODO - add TYPE HERE
                        [
                            'label' => 'Category',
                            'value' => function($data) {
                                return empty($data->category_id) ? '' : $data->category->name;
                            }
                        ],
                        [
                            'label' => 'Blog',
                            'value' => function($data) {
                                return empty($data->blog_id) ? '' : $data->blog->title;
                            }
                        ],
                        [
                            'label' => 'Blogger',
                            'value' => function($data) {
                                return empty($data->blogger_id) ? '' : substr($data->blogger->name, 0, 50);
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
                            'template' => '{view} {update} {delete}'
                        ]
                    ]
                ])
            ); ?>
        </div>
    </div>
</div>