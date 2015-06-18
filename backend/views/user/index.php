<?php
    use yii\grid\GridView;
?>
<div class="tag-index">
    <div>
        <h1>Administrators (Users) Management</h1>
        <p class="lead">User CRUDs.</p>
    </div>
    <div class="body-content">
        <div class="row">
            <p><a href="<?= $createUserUrl ?>">Create a new User / Administrator</a></p>
        </div>
        <div>
            <?php echo(
                GridView::widget([
                    'dataProvider' => $usersDataProvider,
                    'columns'      => [
                        'id',
                        'username',
                        'email',
                        // 'role', // @see backend/rbac for role assignments
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
                            'template' => '{update}'
                        ]
                    ]
                ])
            ); ?>
        </div>
    </div>
</div>