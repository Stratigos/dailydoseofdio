<?php
    $this->title                   = 'Create New Promoted Post';
    $this->params['breadcrumbs'][] = [
        'label' => 'Promoted Posts Index',
        'url'   => Yii::$app->urlManager->createUrl('promotedpost/index')
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div>
        <h3>Create New Promoted Post</h3>
    </div>
    <div class="body-content">
        <?php echo $this->render(
            '_promotedpost_form',
            [
                'promotedpost' => $post,
                'errors'       => $errors
            ]
        ); ?>
    </div>
</div>