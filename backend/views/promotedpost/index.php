<?php
    /**
    * @todo ADD JS TO ALLOW REORDERING VIA GRID VIEW
    */
    use yii\grid\GridView;
    use common\models\PromotedPost;
    $this->title                   = 'Promoted Posts Index';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h1>Promoted Posts Management</h1>
    </div>
    <div class="body-content">
        <div>
            <p class="lead"><a href="<?= $createPromotedPostUrl ?>">Promote a New Post</a></p>
            <hr/>
        </div>
        <div>
            <p><em>...widget to display carousel from homepage here...</em></p>
            <hr/>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $promotedPostDataProvider,
                    'columns'      => [
                        'id',
                        'post_id',
                        [
                            'label' => 'Title',
                            'value' => function($data) {
                                return StringHelper::truncateWords(
                                    HtmlHelper::encode($data->post->title), 7, '&hellip;'
                                );
                            }
                        ],
                        [
                            'label' => 'Description',
                            'value' => function($data) {
                                return $data->getSummary(50, '');
                            }
                        ],
                        'rank',
                        [
                            'label' => 'Status',
                            'value' => function($data) {
                                if($data->status == PromotedPost::STATUS_DRAFT) {
                                    return 'Draft';
                                } else if($data->status == PromotedPost::STATUS_PUBLISHED) {
                                    return 'Published';
                                }
                                return 'Invalid';
                            }
                        ],
                        [
                            'label' => 'Publish Date',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function($data) {
                                return empty($data->published_at) ? null : date('Y-m-d H:i:s', $data->published_at);
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
        <div>
            <hr/>
            <p class="lead"><a href="<?= $createPromotedPostUrl ?>">Promote a New Post</a></p>
        </div>
    </div>
</div>